<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/7
 * Time: 16:32
 */

namespace App\Services;
use App\Exceptions\ApiException;
use App\Jobs\HandleEntrust;
use App\Models\ContractOrder;
use App\Models\ContractPosition;
use App\Models\HistoricalCommission;
use App\Models\SustainableAccount;
use App\Models\ContractBuy;
use App\Models\ContractSell;
use App\Models\ContractTradeBuy;
use App\Models\ContractTradeSell;
use App\Models\ContractPair;
use App\Models\Withdraw;
use App\Services\HuobiService\HuobiapiService;
use App\Services\HuobiService\lib\HuobiLibService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
class PerpetualContractService
{
    public function orderPlacement($user_id,$array)
    {
        #下单
        $order_id=$array['client_order_id'].date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        ContractOrder::query()->where(['user_id'=>$user_id])->insert([
            'user_id'=>$user_id,
            'type'=>$array['type'],
            'contract_code'=>$array['contract_code'],
            'entrust_price'=>$array['entrust_price'],
            'volume'=>$array['volume'],
            'direction'=>$array['direction'],
            'offset'=>$array['offset'],
            'lever_rate'=>$array['lever_rate'],
            'client_order_id'=>$order_id,
            'created_at'=>time(),
        ]);
//        return api_response()->success("提交成功");
        #持仓信息
        SustainableAccount::query()->where(['user_id'=>$user_id,'coin_name'=>$array['coin_name']])->firstOrFail();
        ContractPosition::query()->insert([
            'user_id'=>$user_id,
            'contract_code'=>$array['contract_code'],
            'client_order_id'=>$order_id,
            'margin_mode'=>$array['margin_mode'],
            'liquidation_price'=>$array['liquidation_price'],
            'position'=>$array['position'],
            'avail_position'=>$array['avail_position'],
            'margin'=>$array['margin'],
            'avg_cost'=>$array['avg_cost'],
            'settlement_price'=>$array['settlement_price'],
            'instrument_id'=>$array['instrument_id'],
            'leverage'=>$array['leverage'],
            'realized_pnl'=>$array['realized_pnl'],
            'side'=>$array['side'],
            'timestamp'=>$array['timestamp'],
            'maintenance_margin'=>$array['maintenance_margin'],
            'settled_pnl'=>$array['settled_pnl'],
            'last'=>$array['last'],
            'unrealized_pnl'=>$array['unrealized_pnl'],
        ]);
        #历史委托

        HistoricalCommission::query()->insert([
            'client_order_id'=>$array['client_order_id'],
            'symbol'=>$array['symbol'],
            'contract_code'=>$array['contract_code'],
            'lever_rate'=>$array['lever_rate'],
            'direction'=>$array['direction'],
            'offset'=>$array['offset'],
            'volume'=>$array['volume'],
            'price'=>$array['price'],
            'profit'=>$array['profit'],
            'trade_volume'=>$array['offset'],
            'fee'=>$array['fee'],
            'trade_avg_price'=>$array['trade_avg_price'],
            'order_type'=>$array['order_type'],
            'status'=>$array['status'],
            'liquidation_type'=>$array['liquidation_type'],
            'create_date'=>$array['create_date'],

        ]);
        return dd($array,$user_id);

    }
    #买入做多
    public function buyLong($user,$array)
    {
        DB::beginTransaction();
        try{
        $coin_name=substr($array['contract_code'] , 0 , 3);
        $order_id=$array['client_order_id'].date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        #合约里面的余额
        $money=SustainableAccount::query()->where(['user_id'=>$user['user_id'],'coin_name'=>$coin_name])->firstOrFail();
        #开仓数量
        $opening_quantity=$money['usable_balance'];
        $exchange_coin_id=$money['coin_id'];
        $number=($array['entrust_price']*$array['volume'])/$array['lever_rate'];

        if($opening_quantity<$number)
        {
            return api_response()->error(200,"开仓数大于可开仓数");
        }
        $usable_balance=$opening_quantity-$number;
        $result1=ContractBuy::query()->insert([
            'user_id'=>$user['user_id'],
            'type'=>$array['type'],
            'contract_code'=>$array['contract_code'],
            'entrust_price'=>$array['entrust_price'],
            'exchange_coin_id'=>$exchange_coin_id,
            'volume'=>$array['volume'],
            'direction'=>$array['direction'],
            'offset'=>$array['offset'],
            'lever_rate'=>$array['lever_rate'],
            'client_order_id'=>$order_id,
        ]);

        $result2=SustainableAccount::query()->where(['user_id'=>$user['user_id'],'coin_name'=>$coin_name])->update([
            'usable_balance'=>$usable_balance,
            'freeze_balance'=>$number,
        ]);
        if($result1&&$result2)
        {
            DB::commit();
            return api_response()->success("下单成功");
        }
        }catch (\Exception $e){
            DB::rollBack();
            return api_response()->error(200,"下单失败");
//            return $this->error(0,$e->getMessage(),$e);
        }

    }
    #卖出做空
    public function sellShort($user,$array)
    {
        DB::beginTransaction();
        try{
        $coin_name=substr($array['contract_code'] , 0 , 3);
        $order_id=$array['client_order_id'].date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        #合约里面的余额
        $money=SustainableAccount::query()->where(['user_id'=>$user['user_id'],'coin_name'=>$coin_name])->firstOrFail();
        #开仓数量
        $opening_quantity=$money['usable_balance'];
        $exchange_coin_id=$money['coin_id'];
        #开仓的价值
        $number=($array['entrust_price']*$array['volume'])/$array['lever_rate'];
        if($opening_quantity<$number)
        {
            return api_response()->error(200,"开仓数大于可开仓数");
        }
        $usable_balance=$opening_quantity-$number;
        $result1= ContractSell::query()->insert([
            'user_id'=>$user['user_id'],
            'type'=>$array['type'],
            'contract_code'=>$array['contract_code'],
            'entrust_price'=>$array['entrust_price'],
            'exchange_coin_id'=>$exchange_coin_id,
            'volume'=>$array['volume'],
            'direction'=>$array['direction'],
            'offset'=>$array['offset'],
            'lever_rate'=>$array['lever_rate'],
            'client_order_id'=>$order_id,
        ]);
        $result2=SustainableAccount::query()->where(['user_id'=>$user['user_id'],'coin_name'=>$coin_name])->update([
                'usable_balance'=>$usable_balance,
                'freeze_balance'=>$number,
            ]);
            if($result1&&$result2)
            {
                DB::commit();
            return api_response()->success("下单成功");
            }
        }catch (\Exception $e){
            DB::rollBack();
            return api_response()->error(200,"下单失败");
        }

    }

    #当前合约委托
    public function currentCommission($user,$params)
    {

        $buyBuilder = ContractBuy::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[ContractBuy::status_wait,ContractBuy::status_trading]);
        $sellBuilder = ContractSell::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[ContractSell::status_wait,ContractSell::status_trading]);

        if(isset($params['contract_code'])){
            $buyBuilder->where('contract_code',$params['contract_code']);
            $sellBuilder->where('contract_code',$params['contract_code']);
        }
        if(isset($params['type'])){
            $buyBuilder->where('type',$params['type']);
            $sellBuilder->where('type',$params['type']);
        }

        if(isset($params['direction'])){
            if($params['direction'] == 'buy'){
                return $buyBuilder->orderByDesc('created_at')->paginate();
            }else{
                return $sellBuilder->orderByDesc('created_at')->paginate();
            }
        }

        return $sellBuilder->union($buyBuilder)->orderByDesc('created_at')->paginate();

    }


    #持仓信息
    public function contractPosition($user_id,$params)
    {

//        dd((new HuobiapiService())->getDetailMerged('btcusdt'));
        #当前比特币最新价格
        $btc_price = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
//        dd($btc_tickers);
        $position=10;
        #结算均价
        $settlement_price=40;
        #开仓均价
        $avg_cost=100;
        #杠杆倍数
        $leverage=10;
        #开仓手数等于
        #需要展示的信息   1.开仓均价，2.收益，3.预估强平价4.收益率 6.保证金7.持仓量8.保证金率9.可平量10.维持保证金率11.调整杠杆12.平仓
        $position=1000;
        #结算均价
        $settlement_price=40;
        #开仓均价
        $avg_cost=10;
        #杠杆倍数
        $leverage=10;
        $data=ContractPosition::query()->where(['user_id'=>$user_id,'contract_code'=>$params['contract_code'],'client_order_id'=>$params['client_order_id']])->firstOrFail();
        #开仓均价
        $avg_cost=$data['avg_cost'];
        #持仓信息
        $contract_code=$data['contract_code'];
        #持仓量 可平数量
        $position=$data['position'];
        #保证金
        $margin=$data['margin'];
        #收益美金 $settlement_price代表的是当前价格  代表当前BTC价格 $btc_price
        $income=$position*($settlement_price-$avg_cost);
        #调整杠杆
        $leverage=$data['leverage'];
        #收益率
        $yield=$income/($position*$avg_cost);
        $yield_rate=$yield*$leverage;
        #仓位模式  '仓位模式：全仓crossed   逐仓 fixed'
        $margin_mode=$data['margin_mode'];
        if($margin_mode=='fixed')
        {
            $maintenance_margin=$margin/($avg_cost*$position)*100;
            #1000   5000  2
            #强平价格
            $liquidation_price=$avg_cost-($avg_cost*$maintenance_margin/100-$avg_cost*1/100);
        }else
        {
            $coin_name=substr($params['contract_code'] , 0 , 3);
            $crossed=SustainableAccount::query()->where(['user_id'=>$user_id,'coin_name'=>$coin_name])->firstOrFail();
            #全仓维持保证金率
            $maintenance_margin=($crossed['usable_balance']+$margin)/($avg_cost*$position)*100;

            #强平价格
            $liquidation_price=$avg_cost-($avg_cost*$maintenance_margin/100-$avg_cost*1/100);
        }
        #如果当前价格小于或者等于爆仓价，则被强平
        if($settlement_price<=$liquidation_price)
        {
            ContractPosition::query()->where(['user_id'=>$user_id,'contract_code'=>$contract_code])->firstOrFail();
            ContractPosition::query()->where(['user_id'=>$user_id,'contract_code'=>$contract_code])->delete();
        }

       return ContractPosition::query()->where(['user_id'=>$user_id,'client_order_id'=>$params['client_order_id'],'contract_code'=>$contract_code])->get();

    }
    #平仓
    public function closeOut()
    {
        return "我在呢"."<span> What Is Da </span>";

    }

    #历史委托
    public function historicalCommission($user_id,$contract_code)
    {
        global  $wallet_data;

        $result=HistoricalCommission::query()->where(['user_id'=>$user_id,'contract_code'=>$contract_code])->get();
        return api_response()->success('SUCCESS',$result);
//        foreach ($result as $coin) {
//               $wallet_data[]=$coin['create_date'];
//               $wallet_data[]=$coin['contract_code'];
//               $wallet_data[]=$coin['lever_rate'];
//               $wallet_data[]=$coin['turnover_ratio'];
//               $wallet_data[]=$coin['direction'];
//               $wallet_data[]=$coin['offset'];
//               $wallet_data[]=$coin['volume'];
//               $wallet_data[]=$coin['trade_avg_price'];
//               $wallet_data[]=$coin['price'];
//               $wallet_data[]=$coin['profit'];
//               $wallet_data[]=$coin['fee'];
//               $wallet_data[]=$coin['status'];
//
//
//        }
//        return api_response()->success($wallet_data);
    }
}