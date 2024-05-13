<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:42:01
 */
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-09 17:42:01
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUpgradeLog extends Model
{
    // 用户升级日志

    protected $primaryKey = 'id';
    protected $table = 'user_upgrade_logs';
    protected $guarded = [];
}
