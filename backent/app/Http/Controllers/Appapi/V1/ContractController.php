<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-09-01 14:52:56
 */

namespace App\Http\Controllers\Appapi\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminSetting;
use App\Models\Article;
use App\Models\Coins;
use App\Models\ContractPair;
use App\Models\SecondConfig;
use App\Models\SecondOrder;
use App\Models\SecondUser;
use App\Models\InsideTradePair;
use App\Models\UserAgreementLog;
use App\Services\ContractService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractController extends ApiController
{
    // 永续合约

    protected $service;

    public function __construct(ContractService $contractService)
    {
        $this->service = $contractService;
    }

    // 获取永续合约协议开通状态
    public function openStatus()
    {
        $user = $this->current_user();

        $open = UserAgreementLog::query()->where(['type' => 'contract', 'user_id' => $user['user_id']])->exists();
        if ($open) {
            $data['open'] = 1;
        } else {
            $data['open'] = 0;
            $agreement = Article::query()->where('category_id', 36)->first();
            $agreement = $agreement->makeHidden("translations");
            $data['contractAgreement'] = $agreement;
        }
        return $this->successWithData($data);
    }

    // 开通永续合约
    public function opening()
    {
        $user = $this->current_user();

        $res = UserAgreementLog::query()->create([
            'user_id' => $user['user_id'],
            'type' => 'contract',
            'open_time' => time(),
        ]);

        if ($res) {
            return $this->success();
        }
        return $this->error();
    }

    // 获取永续合约市场信息
    public function getMarketList()
    {
        $contracts = ContractPair::query()->with('coin')->where('status', 1)->get();
        $marketList = [];
        $kk = 0;
        foreach ($contracts as $k => $contract) {
            $coin = Coins::query()->where('coin_name', 'USDT')->first();
            $marketList[$kk]['coin_name'] = $coin['coin_name'];
            $marketList[$kk]['full_name'] = $coin['full_name'];
            $marketList[$kk]['coin_icon'] = getFullPath($coin['coin_icon']);
            $marketList[$kk]['coin_content'] = $coin['coin_content'];
            $marketList[$kk]['qty_decimals'] = $coin['qty_decimals'];
            $marketList[$kk]['price_decimals'] = $coin['price_decimals'];
            $cd = Cache::store('redis')->get('swap:' . $contract['symbol'] . '_detail');
            $data = $cd;
            $data['price'] = $cd['close'];
            $data['qty_decimals'] = $contract['qty_decimals'];
            $data['price_decimals'] = $contract['price_decimals'];
            $data['symbol'] = $contract['symbol'];
            $data['pair_name'] = $contract['contract_coin_name'] . '/' . $contract['type'];
            $data['type'] = $contract['type'];
            $data['icon'] = $contract['coin']['coin_icon'];
            $data['min_qty'] = $contract['min_qty'];
            $data['max_qty'] = $contract['max_qty'];
            $data['total_max_qty'] = $contract['total_max_qty'];
            $marketList[$kk]['marketInfoList'][$k] = $data;
        }

        return $this->successWithData($marketList);
    }

    // 获取合约市场初始化盘面信息（买卖盘 成交盘）
    public function getMarketInfo(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required',
        ])) return $vr;

        $symbol = $request->input('symbol');

        $buyList = Cache::store('redis')->get('swap:' . $symbol . '_depth_buy');
        $sellList = Cache::store('redis')->get('swap:' . $symbol . '_depth_sell');
        $tradeList = array_reverse(Cache::store('redis')->get('swap:' . 'tradeList_' . $symbol));

        $coins = config('coin.swap_symbols');
        foreach ($coins as $coin => $class) {
            if ($symbol == $coin) {
                $kline = $class::query()->where('is_1min', 1)->where('Date', '<', time())->orderByDesc('Date')->first();
                if (blank($kline)) {
                    $tradeList = [];
                } else {
                    $kline_cache_data = Cache::store('redis')->get('swap:' . $symbol . '_detail');

                    for ($i = 0; $i <= 19; $i++) {
                        if ($i == 0) {
                            $buyList[$i] = [
                                'id' => Str::uuid(),
                                "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                'price' => $kline_cache_data['close'],
                            ];
                        } else {
                            $open = $kline['Open'];
                            $close = $kline['Close'];
                            $min = min($open, $close) * 100000;
                            $max = max($open, $close) * 100000;
                            $price = round(mt_rand($min, $max) / 100000, 5);

                            $buyList[$i] = [
                                'id' => Str::uuid()->toString(),
                                "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                'price' => $price,
                            ];
                        }
                    }

                    if ($coin != strtolower(config('coin.coin_symbol'))) {
                        for ($i = 0; $i <= 19; $i++) {
                            if ($i == 0) {
                                $sellList[$i] = [
                                    'id' => Str::uuid(),
                                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                    'price' => $kline_cache_data['close'],
                                ];
                            } else {
                                $open = $kline['Open'];
                                $close = $kline['Close'];
                                $min = min($open, $close) * 100000;
                                $max = max($open, $close) * 100000;
                                $price = round(mt_rand($min, $max) / 100000, 5);

                                $sellList[$i] = [
                                    'id' => Str::uuid()->toString(),
                                    "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                    'price' => $price,
                                ];
                            }
                        }
                    }

                    for ($i = 0; $i <= 30; $i++) {
                        if ($i == 0) {
                            $tradeList[$i] = [
                                'id' => Str::uuid(),
                                "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                'price' => $kline_cache_data['close'],
                                'tradeId' => Str::uuid()->toString(),
                                'ts' => Carbon::now()->getPreciseTimestamp(3),
                                'increase' => -0.1626,
                                'increaseStr' => "-16.26%",
                                'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                            ];
                        } else {
                            $open = $kline['Open'];
                            $close = $kline['Close'];
                            $min = min($open, $close) * 100000;
                            $max = max($open, $close) * 100000;
                            $price = round(mt_rand($min, $max) / 100000, 5);

                            $tradeList[$i] = [
                                'id' => Str::uuid()->toString(),
                                "amount" => round((mt_rand(10000, 3000000) / 1000), 4),
                                'price' => $price,
                                'tradeId' => Str::uuid()->toString(),
                                'ts' => Carbon::now()->getPreciseTimestamp(3),
                                'increase' => -0.1626,
                                'increaseStr' => "-16.26%",
                                'direction' => mt_rand(0, 1) == 0 ? 'buy' : 'sell',
                            ];
                        }
                    }
                }

                break;
            }
        }

        $data = [
            'swapBuyList' => $buyList ?? [],
            'swapSellList' => $sellList ?? [],
            'swapTradeList' => $tradeList ?? [],
        ];
        return $this->successWithData($data);
    }

    //获取初始Kline数据
    public function getKline(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required',
            'period' => 'required',
            'size' => 'required',
            'zip' => '',
        ])) return $vr;

        $params = $request->all();
        $size = $request->input('size', 200);
        $zip = $request->input('zip', 0);
        $symbol = $params['symbol'];

        $history_data_key = 'swap:' . $symbol . '_kline_book_' . $params['period'];
        $history_cache_data = Cache::store('redis')->get($history_data_key);
        $data['data'] = $history_cache_data;
        $data['ch'] = "swap." . $symbol . ".kline." . $params['period'];
        $data['ts'] = Carbon::now()->getPreciseTimestamp(3);
        $data['status'] = 'ok';

        $coins = config('coin.swap_symbols');
        foreach ($coins as $coin => $class) {
            if ($symbol == $coin) {
                $data['data'] = $class::getKlineData($symbol, $params['period'], $params['size']);
                $data['ch'] = "swap." . $symbol . ".kline." . $params['period'];
                $data['ts'] = Carbon::now()->getPreciseTimestamp(3);
                $data['status'] = 'ok';

                break;
            }
        }
        // 使Size参数有效
        // if ($size) {
        //     // $data['data'] = 
        //     $data_count = count($data['data']);
        //     $step = bcdiv($data_count, $size, 0);
        //     for ($i = 0; ($i * $step) < $data_count; $i++) {
        //         $new_data[] = $data['data'][$i * $step];
        //     }
        //     $data['data'] = $new_data;
        // }
        if ($zip) {
            $json = json_encode($data['data']);
            $gzstr = gzcompress($json);
            $data['data'] = base64_encode($gzstr);
            return $this->successWithData($data);
        } else {
            return $this->successWithData($data);
        }
    }

    //获取用户账户余额
    public function getUserCoinBalance(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', // 合约名称 参数格式：BTC
        ])) return $vr;
    }

    // 获取合约信息
    public function getSymbolDetail(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', // 合约名称 参数格式：BTC
        ])) return $vr;

        $params = $request->only(['symbol']);
        $data = $this->service->getSymbolDetail($params);
        //second-config-data
        $sconf = SecondConfig::query()->where('status', '1')->get(['id','seconds','profit_rate','min_amount']);
        $data["seconf"]=$sconf;
        //second-config-data end
        return $this->successWithData($data);
    }
    public function randomFloat($min = 0, $max = 1) {
   	   $num = $min + mt_rand() / mt_getrandmax() * ($max - $min);
   	   return sprintf("%.2f",$num);
	}
    // 秒合约
    public function secondContract(Request $request)
    {
        //update order
        $orderprofit_rate = $request->input('profit_rate');
        $order = SecondOrder::find($request->input('oid'));
        if($order->control_status>0) {
            return $this->successWithData(['code'=>200]);
        }
        $user = $this->current_user();
        $uid = $user['user_id'];
        $user = SecondUser::where('user_id',$uid)->first();
        $offset = $this->randomFloat(0.1010,1.9090);
        if($user->result_status==0) {
            $order->close_price = $request->input('entrust_price');
            if($order->expected == 1 && $order->close_price > $order-> order_price) {
                $order->result_status = 1;
                $order->profit = $orderprofit_rate/100*$order->amount;
            }elseif ($order->expected == 0 && $order->close_price < $order-> order_price) {
                $order->result_status = 1;
                $order->profit = $orderprofit_rate/100*$order->amount;
            }else{
                $order->result_status = 2;
                $order->profit = -$orderprofit_rate/100*$order->amount;
            }
        } elseif($user->result_status==1 ) {
            $order->result_status = 1;
            $order->control_status = 1;
            $order->profit = $orderprofit_rate/100*$order->amount;
            if($order->expected == 1) {
                $order->close_price = $order-> order_price+$offset;
            }elseif ($order->expected == 0 ) {
                $order->close_price = $order-> order_price-$offset;
            }
        } elseif($user->result_status==2) {
            $order->result_status = 2;
            $order->control_status = 2;
            $order->profit = -$orderprofit_rate/100*$order->amount;
            if($order->expected == 1) {
                $order->close_price = $order-> order_price-$offset;
            }elseif ($order->expected == 0 ) {
                $order->close_price = $order-> order_price+$offset;
            }
        }
        $order->close_status = 0;
        $order->save();
        $data["code"]=200;
        return $this->successWithData($data);
    }
    public function secondContractinit(Request $request)
    {
        $user = $this->current_user();
        $uid = $user['user_id'];
        SecondUser::firstOrCreate(['user_id'=>$uid]);
        //order
        $order = new SecondOrder();
        //$order->close_price = $request->input('entrust_price');
        $order->order_price = $request->input('buyprice');
        $order->trade_pair_id = $request->input('symbolid');
        $order->amount = $request->input('amount');
        $order->second_id = $request->input('secondid');
        $order->expected = $request->input('side');
        $order->user_id = $uid;
        $order->result_status = 0;
        $order->profit = 0;
        $order->close_status = 1;
        $order->save();
        $data["oid"]=$order->id;
        return $this->successWithData($data);
    }
    public function getHistorysc(Request $request)
    {
        $lang = $request->header('Lang');
        $buyingupdown = ["Up","Down"];
        $profitorloss = ["Profit","Loss"];
        if($lang=="zh-CN") {
            $buyingupdown = ["买涨","买跌"];
            $profitorloss = ["赢","输"];
        }
        $user = $this->current_user();
        $uid = $user['user_id'];
        $order = SecondOrder::where('close_status', 0)->where('user_id',$uid)
               ->orderBy('id', 'desc')
               ->get();
        $ordertext = [];       
        foreach ($order as $k=>$i) {
            $second = SecondConfig::find($i['second_id']);
            $secondtext = $second['seconds'];
            $pair = InsideTradePair::find($i['trade_pair_id']);
            $pairtext = $pair['pair_name'];
            $sidetext = $i['expected'];// == 1 ? $buyingupdown[0] : $buyingupdown[1];
            $resulttext = $i['result_status'];// == 1 ? $profitorloss[0] : $profitorloss[1];
            $ordertext[$k]['seconds'] = $secondtext;
            $ordertext[$k]['side'] = $sidetext;
            $ordertext[$k]['result'] = $resulttext;
            $ordertext[$k]['closetime'] = date_format($i['updated_at'],"Y/m/d H:i:s");
            $ordertext[$k]['profit'] = $i['profit'];
            $ordertext[$k]['orderprice'] = $i['order_price'];
            $ordertext[$k]['closeprice'] = $i['close_price'];
            $ordertext[$k]['amount'] = $i['amount'];
            $ordertext[$k]['id'] = $i['id'];
            $ordertext[$k]['pair'] = $pairtext;
        }
        $data["data"]=$ordertext;
        return $this->successWithData($data);
    }
    public function getCurrentsc(Request $request)
    {
        $user = $this->current_user();
        $uid = $user['user_id'];
        $order = SecondOrder::where('close_status', 1)->where('user_id',$uid)
               ->orderBy('id', 'desc')
               ->get();
        $ordertext = [];       
        foreach ($order as $k=>$i) {
            $second = SecondConfig::find($i['second_id']);
            $secondtext = $second['seconds'];
            $pair = InsideTradePair::find($i['trade_pair_id']);
            $pairtext = $pair['pair_name'];
            $sidetext = $i['expected'] == 1 ? '买涨' : '买跌';
            $resulttext = $i['result_status'] == 0 ? '  ' : '输';
            $ordertext[$k]['seconds'] = $secondtext;
            $ordertext[$k]['side'] = $sidetext;
            $ordertext[$k]['result'] = $resulttext;
            $ordertext[$k]['closetime'] = date_format($i['updated_at'],"Y/m/d H:i:s");
            $ordertext[$k]['profit'] = $i['profit'];
            $ordertext[$k]['orderprice'] = $i['order_price'];
            $ordertext[$k]['closeprice'] = $i['close_price'];
            $ordertext[$k]['amount'] = $i['amount'];
            $ordertext[$k]['id'] = $i['id'];
            $ordertext[$k]['pair'] = $pairtext;
        }
        $data["data"]=$ordertext;
        return $this->successWithData($data);
    }
    //    /**
    //     * 获取所有合约账户列表
    //     * @param Request $request
    //     * @return \Illuminate\Http\JsonResponse
    //     * @throws \App\Exceptions\ApiException
    //     */
    //    public function contractAccountList(Request $request)
    //    {
    //        $user = $this->current_user();
    //        $data = $this->service->contractAccountList($user);
    //        return $this->successWithData($data);
    //    }

    /**
     * 获取合约账户流水
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function contractAccountFlow(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => '', // 合约名称 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->only(['symbol']);
        $data = $this->service->contractAccountFlow($user, $params);
        return $this->successWithData($data);
    }

    // 获取合约账户信息
    public function contractAccount(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => '', // 合约名称 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();
        $data = $this->service->contractAccount($user, $params);
        return $this->successWithData($data);
    }

    // 合约多空比趋势
    public function tend(Request $request)
    {
    }

    // 获取用户合约持仓信息
    public function holdPosition(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => '', // 合约名称 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();
        $data = $this->service->holdPosition($user, $params);
        return $this->successWithData($data);
    }

    // 获取用户委托可开张数
    public function openNum(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', // 合约名称 参数格式：BTC
            'lever_rate' => 'required', // 杠杆倍数
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->only(['symbol', 'lever_rate']);

        $res = $this->service->openNum($user, $params);
        return $this->successWithData($res);
    }

    // 合约开仓
    public function openPosition(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'side' => 'required|integer|in:1,2', //买卖方向 1买入开多 2卖出开空
            'type' => 'required|integer|in:1,2', //委托方式 1限价交易 2市价交易 3止盈止损
            'symbol' => 'required', //合约名称 参数格式：BTC
            'entrust_price' => 'required_if:type,1,3', //委托价格
            'trigger_price' => 'required_if:type,3', //触发价
            'amount' => 'required|integer|min:1', //委托数量(张)
            'lever_rate' => 'required', // 杠杆倍数
            'tp_trigger_price' => 'nullable|numeric', // 止盈价
            'sl_trigger_price' => 'nullable|numeric', // 止损价
            // 'tp_ratio' => 'nullable|numeric', // 止盈比率
            // 'sl_ratio' => 'nullable|numeric', // 止损比率
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $orderLockKey = 'open_contract_entrust_lock:' . $user['user_id'];
        if (!$this->setKeyLock($orderLockKey, 3)) { //订单锁
            return $this->error();
        }

        // 开仓
        $res = $this->service->openPosition($user, $params);
        if (!$res) {
            return $this->error(0, '委托失败');
        }
        return $this->success('委托成功');
    }

    // 合约平仓
    public function closePosition(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'side' => 'required|integer|in:1,2', //买卖方向 1买入平空 2卖出平多
            'type' => 'required|integer|in:1,2,3', //委托方式 1限价交易 2市价交易
            'symbol' => 'required', //合约名称 参数格式：BTC
            'entrust_price' => 'required_if:type,1,3', //委托价格
            'trigger_price' => 'required_if:type,3', //触发价
            'amount' => 'required|integer|min:1', //委托数量(张)
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $orderLockKey = 'close_contract_entrust_lock:' . $user['user_id'];
        if (!$this->setKeyLock($orderLockKey, 3)) { //订单锁
            return $this->error();
        }

        // 平仓
        $res = $this->service->closePosition($user, $params);
        if (!$res) {
            return $this->error(0, '委托失败');
        }
        return $this->success('委托成功');
    }

    // 市价全平
    public function closeAllPosition(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', //合约名称 参数格式：BTC
            'side' => 'required|integer|in:1,2', //买卖方向 1买入平空 2卖出平多
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();
        $orderLockKey = 'closeAllPositionLock:' . $user['user_id'];
        if (!$this->setKeyLock($orderLockKey, 3)) { //订单锁
            return $this->error();
        }

        return $this->service->closeAllPosition($user, $params);
    }

    /**
     * 一键全仓
     * @param Request $request
     * @return \App\Services\ApiResponseService|\Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function onekeyAllFlat(Request $request)
    {
        $user = $this->current_user();
        $orderLockKey = 'onekeyAllFlatLock:' . $user['user_id'];
        if (!$this->setKeyLock($orderLockKey, 2)) { //订单锁
            return $this->error();
        }
        return $this->service->onekeyAllFlat($user['user_id']);
    }

    /**
     * 一键反向
     * @param Request $request
     * @return \App\Services\ApiResponseService|\Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function onekeyReverse(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', //合约名称 参数格式：BTC
            'position_side' => 'required|integer|in:1,2', //仓位方向 1多仓 2空仓
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();
        $orderLockKey = 'onekeyReverseLock:' . $user['user_id'];
        if (!$this->setKeyLock($orderLockKey, 2)) { //订单锁
            return $this->error();
        }
        return $this->service->onekeyReverse($user, $params);
    }

    /**
     * 设置止盈止损
     * @param Request $request
     * @return \App\Services\ApiResponseService|\Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function setStrategy(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', //合约名称 参数格式：BTC
            'position_side' => 'required|integer|in:1,2', //仓位方向 1多仓 2空仓
            'sl_trigger_price' => '', //止损触发价
            'tp_trigger_price' => '', //止盈触发价
            'iscanel'   => 'nullable|integer', //撤销止盈止损
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();
        return $this->service->setStrategy($user, $params);
    }

    //获取当前委托
    public function getCurrentEntrust(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'order_type' => 'string|in:1,2', //交易类型 1开仓 2平仓
            'side' => 'string|in:1,2', //买卖方向 1买入 2卖出
            'type' => 'integer|in:1,2,3', //委托方式 1限价交易 2市价交易
            'symbol' => '', // 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $data = $this->service->getCurrentEntrust($user, $params);
        return $this->successWithData($data);
    }

    //获取历史委托
    public function getHistoryEntrust(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'order_type' => 'string|in:1,2', //交易类型 1开仓 2平仓
            'side' => 'string|in:1,2', //买卖方向 1买入 2卖出
            'type' => 'integer|in:1,2,3', //委托方式 1限价交易 2市价交易
            'symbol' => '', // 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $data = $this->service->getHistoryEntrust($user, $params);
        return $this->successWithData($data);
    }

    //获取委托成交明细
    public function getEntrustDealList(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', // 参数格式：BTC
            'entrust_id' => 'required', //委托ID
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $data = $this->service->getEntrustDealList($user['user_id'], $params);
        return $this->successWithData($data);
    }

    //获取成交记录
    public function getDealList(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'order_type' => 'string|in:1,2', //交易类型 1开仓 2平仓
            'symbol' => '', //交易对 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $data = $this->service->getDealList($user['user_id'], $params);
        return $this->successWithData($data);
    }

    //撤单
    public function cancelEntrust(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', // 参数格式：BTC
            'entrust_id' => 'required', //委托ID
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->only(['entrust_id', 'symbol']);

        $res = $this->service->cancelEntrust($user, $params);
        if (!$res) {
            return $this->error();
        }
        return $this->success();
    }

    //批量撤单
    public function batchCancelEntrust(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => '', // 参数格式：BTC
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->only(['symbol']);

        return $this->service->batchCancelEntrust($user, $params);
    }

    /**
     * 持仓盈亏分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function positionShare(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', //合约名称 参数格式：BTC
            'position_side' => 'required|integer|in:1,2', //仓位方向 1多仓 2空仓
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $lang = App::getLocale();

        if ($lang !== 'en' && $lang !== 'zh-CN') {

            App::setLocale('en');
        }

        $tip = [[
            "imgtitle0" => "梭哈!!!",
            "imgtitle1" => "赢了别墅嫩模",
            "imgtitle2" => "输了下地干活",
        ], [
            "imgtitle0" => "神机妙算  无可匹敌",
        ], [
            "imgtitle0" => "赚了就跑",
            "imgtitle1" => "真金入腰包",
        ], [
            "imgtitle0" => "HI",
            "imgtitle1" => "年轻人，我是巴菲特,",
            "imgtitle2" => "我指定你做我的接班人",
        ], [
            "imgtitle0" => "如果你还没有做好",
            "imgtitle1" => "承受痛苦的准备",
            "imgtitle2" => "那就离开吧",
            "imgtitle3" => "别指望会成为常胜将军",
        ], [
            "imgtitle0" => "小哥哥你太急了",
            "imgtitle1" => "看准了再下手嘛!"
        ]];

        $tip = [[
            "imgtitle0" => __("梭哈!!!"),
            "imgtitle1" => __("赢了别墅嫩模"),
            "imgtitle2" => __("输了下地干活"),
        ], [
            "imgtitle0" => __("神机妙算  无可匹敌"),
        ], [
            "imgtitle0" => __("赚了就跑"),
            "imgtitle1" => __("真金入腰包"),
        ], [
            "imgtitle0" => __("HI"),
            "imgtitle1" => __("年轻人，我是巴菲特,"),
            "imgtitle2" => __("我指定你做我的接班人"),
        ], [
            "imgtitle0" => __("如果你还没有做好"),
            "imgtitle1" => __("承受痛苦的准备"),
            "imgtitle2" => __("那就离开吧"),
            "imgtitle3" => __("别指望会成为常胜将军"),
        ], [
            "imgtitle0" => __("小哥哥你太急了"),
            "imgtitle1" => __("看准了再下手嘛!")
        ]];

        $data = $this->service->positionShare($user, $params);
        $data['tip'] = $tip;
        return $this->successWithData($data);
    }

    /**
     * 平仓委托盈亏分享
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ApiException
     */
    public function entrustShare(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
            'symbol' => 'required', //合约名称 参数格式：BTC
            'entrust_id' => 'required|integer', //委托ID
        ])) return $vr;

        $user = $this->current_user();
        $params = $request->all();

        $data = $this->service->entrustShare($user, $params);
        return $this->successWithData($data);
    }

    // 合约说明
    public function instruction(Request $request)
    {

        $language = App::getLocale();
        switch ($language) {
            case 'zh-CN':
                $key = 'contract_instruction_cn';
                break;
            case 'cn':
                $key = 'contract_instruction_cn';
                break;
            case 'en':
                $key = 'contract_instruction_en';
                break;
            default:
                $key = 'contract_instruction_en';
        }
        $instruction = AdminSetting::query()
            ->where('key', $key)
            ->value('value');
        return $this->successWithData($instruction);
    }
}
