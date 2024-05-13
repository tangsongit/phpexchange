<?php

namespace App\Jobs;

use App\Exceptions\ApiException;
use App\Models\ContractTradeBuy;
use App\Models\ContractTradeSell;
use App\Models\ContractBuy;
use App\Models\ContractOrder;
use App\Models\ContractSell;
use App\Models\User;
use App\Models\SustainableAccount;
use App\Models\UserWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class HandleContractEntrustment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $entrust;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($entrust)
    {
        $this->entrust = $entrust;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $entrust = $this->entrust;
        if(blank($entrust)) return ;

        $where_data = [
            'quote_coin_id' => $entrust['quote_coin_id'],
            'base_coin_id' => $entrust['base_coin_id'],
            'entrust_price' => $entrust['entrust_price'],
            'user_id' => $entrust['user_id'],
        ];
        if($entrust['entrust_type'] == 1){
            if(!$entrust->can_trade()) return ;
            //限价交易 获取可交易卖单 撮单
            //市价交易 吃单
            //获取可交易列表
            $sellList = ContractTradeSell::getSellTradeList($entrust['type'],$where_data);
            if(blank($sellList)){
                //卖单盘口 没有可交易订单 则先挂单
                $order_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'entrust_type' => $entrust['entrust_type'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => $entrust['entrust_price'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => $entrust['amount'],
                    'money' => $entrust['money'],
                ];
                ContractTradeBuy::query()->create($order_data);
            }else{
                //有可交易订单 撮单
                DB::beginTransaction();
                try{

                    $this->handleBuyTrade($entrust,$sellList);

                    DB::commit();
                }catch (\Exception $e){
                    DB::rollBack();
                    throw $e;
                }
            }
        }else{
            if(!$entrust->can_trade()) return ;
            //限价交易 获取可交易买单 撮单
            //市价交易 吃单
            //获取可交易列表
            $buyList = ContractTradeBuy::getBuyTradeList($entrust['type'],$where_data);
            if(blank($buyList)){
                //卖单盘口 没有可交易订单 则先挂单
                $order_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'entrust_type' => $entrust['entrust_type'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => $entrust['entrust_price'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => $entrust['amount'],
                ];
                ContractTradeSell::query()->create($order_data);
            }else{
                //有可交易订单 撮单
                DB::beginTransaction();
                try{

                    $this->handleSellTrade($entrust,$buyList);

                    DB::commit();
                }catch (\Exception $e){
                    DB::rollBack();
                    throw $e;
                }
            }
        }
    }

    public function handleBuyTrade($entrust,$sellList)
    {
        $fee_rate = 0.002; //交易手续费比率
        $entrust_amount = $entrust['amount'];
        $entrust_money = $entrust['money'];
        $entrust_traded_amount = $entrust['traded_amount']; //交易量 单位：exchange_coin
        $entrust_traded_money = $entrust['traded_money'];  //交易额 单位：base_coin
        foreach ($sellList as $sell){
            if( $tradeSell = ContractSell::query()->where('order_no',$sell['order_no'])->first() ){
                //获取可交易量、可交易额
                if($entrust['type'] == 1){
                    //买单限价委托 可与卖单限价委托和市价委托交易
                    $entrust_surplus_amount = $entrust['amount'] - $entrust_traded_amount; //剩余交易量 计量单位
                    $exchange_amount = min($entrust_surplus_amount,$sell['surplus_amount']);
                    $unit_price = $tradeSell['type'] == 1 ? $tradeSell['entrust_price'] : $entrust['entrust_price']; //成交价
                    $exchange_money = $exchange_amount * $unit_price;
                    $entrust_amount -= $exchange_amount;
                    $entrust_money -= $exchange_money;
                    $entrust_traded_amount += $exchange_amount;
                    $entrust_traded_money += $exchange_money;
                }else{
                    //买单市价委托 只可与卖单限价委托交易
                    $entrust_surplus_money = $entrust['money'] - $entrust_traded_money; //剩余交易额 计量单位
                    $buy_amount = $entrust_surplus_money / $tradeSell['entrust_price']; //剩余交易量
                    $exchange_amount = min($buy_amount,$sell['surplus_amount']);
                    $unit_price = $tradeSell['entrust_price']; //成交价
                    $exchange_money = $exchange_amount * $unit_price;
                    $entrust_amount -= $exchange_amount;
                    $entrust_money -= $exchange_money;
                    $entrust_traded_amount += $exchange_amount;
                    $entrust_traded_money += $exchange_money;
                }

                //更新卖单
                $sell_traded_amount = $sell['traded_amount'] + $exchange_amount;
                $sell_traded_money = $sell['traded_money'] + $exchange_money;
                if($sell_traded_amount == $sell['amount']){
                    //卖单全部成交
                    $sell->delete();
                    $tradeSell->update([
                        'traded_amount' => $sell_traded_amount,
                        'traded_money' => $sell_traded_money,
                        'status' => ContractSell::status_completed,
                    ]);
                }else{
                    //卖单部分成交
                    $sell->update([
                        'traded_amount' => $sell_traded_amount,
                        'traded_money' => $sell_traded_money,
                    ]);
                    $tradeSell->update([
                        'traded_amount' => $sell_traded_amount,
                        'traded_money' => $sell_traded_money,
                        'status' => ContractSell::status_trading,
                    ]);
                }

                $buy_fee = PriceCalculate($exchange_amount ,'*', $fee_rate);
                $sell_fee = PriceCalculate($exchange_money ,'*', $fee_rate);
                //增加委托成交匹配记录
                ContractOrder::query()->create([
                    'buy_order_no' => $entrust['order_no'],
                    'sell_order_no' => $tradeSell['order_no'],
                    'buy_id' => $entrust['id'],
                    'sell_id' => $tradeSell['id'],
                    'buy_user_id' => $entrust['user_id'],
                    'sell_user_id' => $tradeSell['user_id'],
                    'unit_price' => $unit_price,
                    'symbol' => $entrust['symbol'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'trade_amount' => $exchange_amount,
                    'trade_money' => $exchange_money,
                    'trade_fee' => $buy_fee,
                ]);

                //更新用户钱包
                $buy_user = User::query()->find($entrust['user_id']);
                $sell_user = User::query()->find($tradeSell['user_id']);
                //买家得到base_coin_id 扣除quote_coin_id
                $buy_user->update_wallet_and_log($entrust['quote_coin_id'],'freeze_balance',-$exchange_money,UserWallet::asset_account,'entrust_exchange');
                $buy_user->update_wallet_and_log($entrust['base_coin_id'],'usable_balance',$exchange_amount - $buy_fee,UserWallet::asset_account,'entrust_exchange');
                //卖家得到quote_coin_id 扣除base_coin_id
                $sell_user->update_wallet_and_log($entrust['quote_coin_id'],'usable_balance',$exchange_money - $sell_fee,UserWallet::asset_account,'entrust_exchange');
                $sell_user->update_wallet_and_log($entrust['base_coin_id'],'freeze_balance',-$exchange_amount,UserWallet::asset_account,'entrust_exchange');

                //买单委托交易完成 退出循环 更新买单
                if($entrust['type'] == 1){
                    if($entrust_amount == 0) {
                        $entrust_update_data = [
                            'traded_amount' => $entrust_traded_amount,
                            'status' => ContractBuy::status_completed,
                        ];
                        if( ($entrust_surplus_money = $entrust['money'] - $entrust_traded_money) > 0){
                            //买家多余冻结余额返还
                            $buy_user->update_wallet_and_log($entrust['quote_coin_id'],'usable_balance',$entrust_surplus_money,UserWallet::asset_account,'entrust_exchange');
                            $buy_user->update_wallet_and_log($entrust['quote_coin_id'],'freeze_balance',-$entrust_surplus_money,UserWallet::asset_account,'entrust_exchange');
                        }

                        $entrust->update($entrust_update_data);

                        break;
                    }else{
                        $entrust->update([
                            'traded_amount' => $entrust_traded_amount,
                            'traded_money' => $entrust_traded_money,
                            'status' => ContractBuy::status_trading,
                        ]);
                    }
                }else{
                    if($entrust_money == 0) {
                        $entrust->update([
                            'traded_amount' => $entrust_traded_amount,
                            'traded_money' => $entrust_traded_money,
                            'status' => ContractBuy::status_completed,
                        ]);
                        break;
                    }else{
                        $entrust->update([
                            'traded_amount' => $entrust_traded_amount,
                            'traded_money' => $entrust_traded_money,
                            'status' => ContractBuy::status_trading,
                        ]);
                    }
                }

            }
        }

        //买单委托未交易完 挂单
        if($entrust['type'] == 1){
            if($entrust_amount > 0){
                $list_buy_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => $entrust['entrust_price'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => $entrust['amount'],
                    'traded_amount' => $entrust_traded_amount,
                    'money' => $entrust['money'],
                    'traded_money' => $entrust_traded_money,
                ];
                ContractTradeBuy::query()->create($list_buy_data);
            }
        }else{
            if($entrust_money > 0){
                $list_buy_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => null,
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => null,
                    'traded_amount' => $entrust_traded_amount,
                    'money' => $entrust['money'],
                    'traded_money' => $entrust_traded_money,
                ];
                ContractTradeBuy::query()->create($list_buy_data);
            }
        }

    }

    public function handleSellTrade($entrust,$buyList)
    {
        $fee_rate = 0.002; //交易手续费比率
        $entrust_amount = $entrust['amount'];
        $entrust_traded_amount = $entrust['traded_amount']; //交易量 单位：exchange_coin
        $entrust_traded_money = $entrust['traded_money'];  //交易额 单位：base_coin
        foreach ($buyList as $buy){
            if( $tradeBuy = ContractBuy::query()->where('order_no',$buy['order_no'])->first() ){

                //卖单限价委托 可与买单限价委托和市价委托交易 （卖单委托计量单位都是交易量amount）
                //卖单市价委托 只可与买单限价委托交易
                $entrust_surplus_amount = $entrust['amount'] - $entrust_traded_amount; //剩余交易量 计量单位
                if($buy['type'] == 1){
                    $unit_price = $tradeBuy['entrust_price'];
                    $exchange_amount = min($entrust_surplus_amount,$buy['surplus_amount']);
                }else{
                    $unit_price = $entrust['entrust_price'];
                    $buy_surplus_amount = $buy['money'] / $unit_price; //计算买单可交易量
                    $exchange_amount = min($entrust_surplus_amount,$buy_surplus_amount);
                }
                $exchange_money = $exchange_amount * $unit_price;
                $entrust_amount -= $exchange_amount;
                $entrust_traded_amount += $exchange_amount;
                $entrust_traded_money += $exchange_money;

                $buy_traded_amount = $buy['traded_amount'] + $exchange_amount;
                $buy_traded_money = $buy['traded_money'] + $exchange_money;

                if( ($tradeBuy['type'] == 1 && $buy_traded_amount == $buy['amount']) || ($tradeBuy['type'] == 2 && $buy_traded_money == $buy['money']) ){
                    //买单全部成交
                    $buy->delete();
                    $tradeBuy->update([
                        'traded_amount' => $buy_traded_amount,
                        'traded_money' => $buy_traded_money,
                        'status' => ContractBuy::status_completed,
                    ]);
                }else{
                    //买单部分成交
                    $buy->update([
                        'traded_amount' => $buy_traded_amount,
                        'traded_money' => $buy_traded_money,
                    ]);
                    $tradeBuy->update([
                        'traded_amount' => $buy_traded_amount,
                        'traded_money' => $buy_traded_money,
                        'status' => ContractBuy::status_trading,
                    ]);
                }

                $buy_fee = PriceCalculate($exchange_amount ,'*', $fee_rate);
                $sell_fee = PriceCalculate($exchange_money ,'*', $fee_rate);
                //增加委托成交匹配记录
                ContractOrder::query()->create([
                    'buy_order_no' => $tradeBuy['order_no'],
                    'sell_order_no' => $entrust['order_no'],
                    'buy_id' => $tradeBuy['id'],
                    'sell_id' => $entrust['id'],
                    'buy_user_id' => $tradeBuy['user_id'],
                    'sell_user_id' => $entrust['user_id'],
                    'unit_price' => $unit_price,
                    'symbol' => $entrust['symbol'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'trade_amount' => $exchange_amount,
                    'trade_money' => $exchange_money,
                    'trade_fee' => $buy_fee,
                ]);

                //更新用户钱包
                $buy_user = User::query()->find($tradeBuy['user_id']);
                $sell_user = User::query()->find($entrust['user_id']);
                //买家得到base_coin_id 扣除quote_coin_id
                $buy_user->update_wallet_and_log($entrust['quote_coin_id'],'freeze_balance',-$exchange_money,UserWallet::asset_account,'entrust_exchange');
                $buy_user->update_wallet_and_log($entrust['base_coin_id'],'usable_balance',$exchange_amount - $buy_fee,UserWallet::asset_account,'entrust_exchange');
                //卖家得到quote_coin_id 扣除base_coin_id
                $sell_user->update_wallet_and_log($entrust['quote_coin_id'],'usable_balance',$exchange_money - $sell_fee,UserWallet::asset_account,'entrust_exchange');
                $sell_user->update_wallet_and_log($entrust['base_coin_id'],'freeze_balance',-$exchange_amount,UserWallet::asset_account,'entrust_exchange');

                //卖单委托交易完成 退出循环
                if($entrust_amount == 0) {
                    $entrust->update([
                        'traded_amount' => $entrust_traded_amount,
                        'traded_money' => $entrust_traded_money,
                        'status' => ContractSell::status_completed,
                    ]);
                    break;
                }else{
                    $entrust->update([
                        'traded_amount' => $entrust_traded_amount,
                        'traded_money' => $entrust_traded_money,
                        'status' => ContractSell::status_trading,
                    ]);
                }

            }
        }

        //卖单委托未交易完 挂单
        if($entrust_amount > 0){
            if($entrust['type'] == 1){
                $list_sell_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => $entrust['entrust_price'],
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => $entrust['amount'],
                    'traded_amount' => $entrust_traded_amount,
                    'traded_money' => $entrust_traded_money,
                ];
                ContractTradeSell::query()->create($list_sell_data);
            }else{
                $list_sell_data = [
                    'user_id' => $entrust['user_id'],
                    'order_no' => $entrust['order_no'],
                    'symbol' => $entrust['symbol'],
                    'type' => $entrust['type'],
                    'entrust_price' => null,
                    'quote_coin_id' => $entrust['quote_coin_id'],
                    'base_coin_id' => $entrust['base_coin_id'],
                    'amount' => $entrust['amount'],
                    'traded_amount' => $entrust_traded_amount,
                    'traded_money' => $entrust_traded_money,
                ];
                ContractTradeSell::query()->create($list_sell_data);
            }
        }

    }

}
