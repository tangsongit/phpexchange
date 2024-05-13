<?php


namespace App\Services;


use App\Exceptions\ApiException;
use App\Jobs\HandleEntrust;
use App\Models\CoinAccount;
use App\Models\InsideListBuy;
use App\Models\InsideListSell;
use App\Models\InsideTradeBuy;
use App\Models\InsideTradeOrder;
use App\Models\InsideTradePair;
use App\Models\InsideTradeSell;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;

class InsideTradeService
{
    public function getCurrentEntrust($user,$params)
    {
        $buyBuilder = InsideTradeBuy::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeBuy::status_wait,InsideTradeBuy::status_trading]);

        $sellBuilder = InsideTradeSell::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeSell::status_wait,InsideTradeSell::status_trading]);

        if(isset($params['symbol'])){
            $buyBuilder->where('symbol',$params['symbol']);
            $sellBuilder->where('symbol',$params['symbol']);
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

    public function getHistoryEntrust($user,$params)
    {
        $buyBuilder = InsideTradeBuy::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeBuy::status_cancel,InsideTradeBuy::status_completed]);

        $sellBuilder = InsideTradeSell::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeSell::status_cancel,InsideTradeSell::status_completed]);

        if(isset($params['symbol'])){
            $buyBuilder->where('symbol',$params['symbol']);
            $sellBuilder->where('symbol',$params['symbol']);
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

    public function getEntrustTradeRecord($user,$params)
    {
        $builder = InsideTradeOrder::query();
        if($params['entrust_type'] == 1){
            $builder->where('buy_id',$params['entrust_id'])->where('buy_user_id',$user['user_id']);
        }else{
            $builder->where('sell_id',$params['entrust_id'])->where('sell_user_id',$user['user_id']);
        }

        return $builder->orderByDesc('created_at')->get();
    }

    public function cancelEntrust($user,$entrust)
    {
        if(!$entrust->can_cancel()) throw new ApiException('当前委托不可撤销');

        DB::beginTransaction();
        try{
            //更新委托
            $res = $entrust->update([
                'status' => 0,
                'cancel_time' => time(),
            ]);

            //删除交易列表中的记录
            if($entrust['entrust_type'] == 1){
                //删除交易列表中的记录
                InsideListBuy::query()->where('order_no',$entrust['order_no'])->delete();

                //更新用户资产
                $return_money = $entrust['money'] - $entrust['traded_money'];
                $user->update_wallet_and_log($entrust['quote_coin_id'],'usable_balance',$return_money,UserWallet::asset_account,'cancel_entrust');
                $user->update_wallet_and_log($entrust['quote_coin_id'],'freeze_balance',-$return_money,UserWallet::asset_account,'cancel_entrust');
            }else{
                //删除交易列表中的记录
                InsideListSell::query()->where('order_no',$entrust['order_no'])->delete();

                //更新用户资产
                $return_money = $entrust['surplus_amount'];
                $user->update_wallet_and_log($entrust['base_coin_id'],'usable_balance',$return_money,UserWallet::asset_account,'cancel_entrust');
                $user->update_wallet_and_log($entrust['base_coin_id'],'freeze_balance',-$return_money,UserWallet::asset_account,'cancel_entrust');
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }

        return $res;
    }

    public function batchCancelEntrust($user,$params)
    {
        $buyBuilder = InsideTradeBuy::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeBuy::status_wait,InsideTradeBuy::status_trading]);

        $sellBuilder = InsideTradeSell::query()
            ->where('user_id',$user['user_id'])
            ->whereIn('status',[InsideTradeSell::status_wait,InsideTradeSell::status_trading]);

        if(isset($params['symbol'])){
            $buyBuilder->where('symbol',$params['symbol']);
            $sellBuilder->where('symbol',$params['symbol']);
        }

        $entrusts =  $sellBuilder->union($buyBuilder)->get();
        if(blank($entrusts)) throw new ApiException('暂无委托');

        DB::beginTransaction();
        try{

            foreach ($entrusts as $entrust) {
                $this->cancelEntrust($user,$entrust);
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }

        return api_response()->success('撤单成功');
    }

    public function storeBuyEntrust($user,$params)
    {
        $pair = InsideTradePair::query()->where('pair_name',$params['symbol'])->first();
        if(blank($pair)) throw new ApiException('交易对不存在');

        //基础货币账户
        $wallet = UserWallet::query()->where(['user_id' => $user->user_id,'coin_id' => $pair['quote_coin_id']])->first();
        if(blank($wallet)) throw new ApiException('钱包类型错误');
        $balance = $wallet->usable_balance;

        //1限价交易 买入卖出数量单位都是exchange_coin
        //2市价交易 买入数量单位是交易额base_coin 卖出数量单位是exchange_coin
        if($params['type'] == 1){
            $entrust_price = $params['entrust_price'];
            $amount = $params['amount'];
            $money = PriceCalculate($params['entrust_price'],'*',$params['amount'],4);
        }else{
            $entrust_price = null;
            $amount = null;
            $money = $params['amount'];
        }
        if($balance <= $money) throw new ApiException('余额不足');

        DB::beginTransaction();
        try{

            //创建订单
            $order_data = [
                'user_id' => $user['user_id'],
                'order_no' => get_order_sn('EB'),
                'symbol' => $params['symbol'],
                'type' => $params['type'],
                'entrust_price' => $entrust_price,
                'quote_coin_id' => $pair['quote_coin_id'],
                'base_coin_id' => $pair['base_coin_id'],
                'amount' => $amount,
                'money' => $money,
            ];
            $entrust = InsideTradeBuy::query()->create($order_data);

            //扣除用户可用资产 冻结
            $user->update_wallet_and_log($wallet['coin_id'],'usable_balance',-$money,UserWallet::asset_account,'store_buy_entrust');
            $user->update_wallet_and_log($wallet['coin_id'],'freeze_balance',$money,UserWallet::asset_account,'store_buy_entrust');

            //添加待处理委托Job
            HandleEntrust::dispatch($entrust)->onQueue('handleEntrust');

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }

        return $entrust;
    }

    public function storeSellEntrust($user,$params)
    {
        $pair = InsideTradePair::query()->where('pair_name',$params['symbol'])->first();
        if(blank($pair)) throw new ApiException('交易对不存在');

        //卖出货币账户：要交换的货币
        $wallet = UserWallet::query()->where(['user_id' => $user->user_id,'coin_id' => $pair['base_coin_id']])->first();
        if(blank($wallet)) throw new ApiException('钱包类型错误');
        $balance = $wallet->usable_balance;

        //1限价交易 买入卖出数量单位都是exchange_coin
        //2市价交易 买入数量单位是交易额base_coin 卖出数量单位是exchange_coin
        if($params['type'] == 1){
            $entrust_price = $params['entrust_price'];
            $amount = $params['amount'];
        }else{
            $entrust_price = null;
            $amount = $params['amount'];
        }
        if($balance <= $amount) throw new ApiException('余额不足');

        DB::beginTransaction();
        try{

            //创建订单
            $order_data = [
                'user_id' => $user['user_id'],
                'order_no' => get_order_sn('ES'),
                'symbol' => $params['symbol'],
                'type' => $params['type'],
                'entrust_price' => $entrust_price,
                'quote_coin_id' => $pair['quote_coin_id'],
                'base_coin_id' => $pair['base_coin_id'],
                'amount' => $amount,
            ];
            $entrust = InsideTradeSell::query()->create($order_data);

            //扣除用户可用资产 冻结
            $user->update_wallet_and_log($wallet['coin_id'],'usable_balance',-$amount,UserWallet::asset_account,'store_sell_entrust');
            $user->update_wallet_and_log($wallet['coin_id'],'freeze_balance',$amount,UserWallet::asset_account,'store_sell_entrust');

            //添加待处理委托Job
            HandleEntrust::dispatch($entrust)->onQueue('handleEntrust');

            DB::commit();

        }catch (\Exception $e){
            DB::rollBack();
            throw new ApiException($e->getMessage());
        }

        return $entrust;
    }

}
