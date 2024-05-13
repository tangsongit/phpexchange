<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-08-13 15:19:00
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 15:32:30
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractShareTranslation extends Model
{
    protected $table = 'contract_share_translations';

    protected $guarded = [];

    public function translations()
    {
        return $this->belongsTo(ContractShare::class, 'id', 'contract_share_id');
    }
}
