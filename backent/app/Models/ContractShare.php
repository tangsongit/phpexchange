<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-13 15:26:59
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ContractShare extends Model
{

    protected $table = 'contract_share';
    protected $guarded = [];
    protected $dateFormat = 'U';

    protected $casts = [
        'data' => 'array',
    ];

    public function translations()
    {
        return $this->hasMany(ContractShareTranslation::class, 'contract_share_id', 'id');
    }
}
