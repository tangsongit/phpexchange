<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:08
 */
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:41:07
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRisk extends Model
{
    // 合约交易风控任务

    protected $table = 'contract_risk';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'range' => 'real',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = blank($value) ? null : strtotime($value);
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = blank($value) ? null : strtotime($value);
    }

    public function contract()
    {
        return $this->belongsTo(ContractPair::class, 'contract_id', 'id');
    }
}
