<?php

namespace App\Models;

use App\Events\HandDividendEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OptionSceneOrder extends Model
{
    //期权订单

    protected $table = 'option_scene_order';
    protected $primaryKey = 'order_id';
    protected $guarded = [];

    protected $casts = [
        'fee' => 'real',
        'bet_amount' => 'real',
        'odds' => 'real',
        'range' => 'real',
        'delivery_amount' => 'real',
    ];

    protected $attributes = [
        'status' => 1,
    ];

    public $appends = ['status_text', 'delivery_time_text', 'lottery_time', 'begin_time_text'];

    const status_wait = 1;
    const status_delivered = 2;
    const status_cancel = 3;

    public static $statusMap = [
        self::status_wait => '待交割',
        self::status_delivered => '已交割',
        self::status_cancel => '流局',
    ];

    public function getStatusTextAttribute()
    {
        return self::$statusMap[$this->status];
    }

    public function getDeliveryTimeTextAttribute()
    {
        return blank($this->delivery_time) ? '--' : Carbon::createFromTimestamp($this->delivery_time)->toDateTimeString();
    }

    public function getLotteryTimeAttribute()
    {
        return ($lottery_time = $this->end_time - time()) > 0 ? $lottery_time : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function scene()
    {
        return $this->belongsTo(OptionScene::class, 'scene_id', 'scene_id');
    }

    public function bonus()
    {
        return $this->morphMany('App\Models\BonusLog', 'bonusable');
    }

    public function getBeginTimeTextAttribute()
    {
        return blank($this->begin_time) ? '--' : Carbon::createFromTimestamp($this->begin_time)->toDateTimeString();
    }

    public function option_order_cancel()
    {
        if (blank($this) || $this->status !== OptionSceneOrder::status_wait || !blank($this->delivery_time)) {
            return;
        }

        try {
            DB::beginTransaction();

            //更新订单
            $this->update([
                'status' => OptionSceneOrder::status_cancel,
            ]);

            event(new HandDividendEvent($this, 0));

            $user = $this->user;
            $user->update_wallet_and_log($this->bet_coin_id, 'usable_balance', $this->bet_amount, UserWallet::asset_account, 'option_order_cancel');

            DB::commit();
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
        }
    }

    public function option_order_delivery($delivery_result)
    {
        if (blank($this) || $this->status !== OptionSceneOrder::status_wait || !blank($this->delivery_time)) {
            return;
        }

        try {
            DB::beginTransaction();

            //            $fee_rate = 0.002; //期权手续费比率

            $delivery_amount = -$this->bet_amount;
            $fee = 0;
            /*
            * 当属于买涨买跌时  交割结果>= 所买range
            * 当属于买平时  交割结果<= 所买range
            */
            if (($this->up_down == $delivery_result['delivery_up_down'] && $this->range <= $delivery_result['delivery_range'])
                || ($this->up_down == 3 && $this->up_down == $delivery_result['delivery_up_down'] && $this->range >= $delivery_result['delivery_range'])
            ) {
                info('option_order_delivery:' . $this->order_id);
                $user = User::query()->find($this->user_id);

                $fee_rate = OptionTime::query()->where('time_id', $this->time_id)->value('fee_rate'); //期权手续费比率

                $complete_amount = PriceCalculate($this->bet_amount, '*', $this->odds, 8);
                $fee = PriceCalculate($complete_amount, '*', $fee_rate, 8);
                $delivery_amount = $complete_amount - $fee;

                $user->update_wallet_and_log($this->bet_coin_id, 'usable_balance', $delivery_amount, UserWallet::asset_account, 'option_order_delivery');
            }

            //更新订单
            $this->update([
                'status' => OptionSceneOrder::status_delivered,
                'delivery_time' => time(),
                'fee' => $fee,
                'delivery_amount' => $delivery_amount,
            ]);

            event(new HandDividendEvent($this, 1));

            DB::commit();
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            //            throw $e;
        }
    }
}
