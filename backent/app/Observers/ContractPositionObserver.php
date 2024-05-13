<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:42:09
 */

namespace App\Observers;

use App\Models\ContractPosition;
use App\Models\ContractStrategy;

class ContractPositionObserver
{
    /**
     * Handle the contract position "created" event.
     *
     * @param ContractPosition $contractPosition
     * @return void
     */
    public function created(ContractPosition $contractPosition)
    {
        //
    }

    /**
     * Handle the contract position "updated" event.
     *
     * @param ContractPosition $contractPosition
     * @return void
     */
    public function updated(ContractPosition $contractPosition)
    {
        if ($contractPosition['hold_position'] == 0) {
            ContractStrategy::query()
                ->where('user_id', $contractPosition['user_id'])
                ->where('contract_id', $contractPosition['contract_id'])
                ->where('position_side', $contractPosition['side'])
                ->update(['status' => 0]);
        }
    }

    /**
     * Handle the contract position "deleted" event.
     *
     * @param ContractPosition $contractPosition
     * @return void
     */
    public function deleted(ContractPosition $contractPosition)
    {
        //
    }

    /**
     * Handle the contract position "restored" event.
     *
     * @param ContractPosition $contractPosition
     * @return void
     */
    public function restored(ContractPosition $contractPosition)
    {
        //
    }

    /**
     * Handle the contract position "force deleted" event.
     *
     * @param ContractPosition $contractPosition
     * @return void
     */
    public function forceDeleted(ContractPosition $contractPosition)
    {
        //
    }
}
