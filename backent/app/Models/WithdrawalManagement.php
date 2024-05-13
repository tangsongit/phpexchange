<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-23 15:35:52
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class WithdrawalManagement extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_withdrawal_management';
    protected $guarded = [];



    public static $address_type_map = [
        1 => 'OMNI',
        2 => 'ERC20',
        3 => 'TRC20'
    ];
}
