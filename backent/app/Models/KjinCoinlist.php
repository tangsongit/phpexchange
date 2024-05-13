<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KjinCoinlist extends Model
{
    //

    protected $table = 'kuangji_coinlist';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function can_store()
    {
        if ($this->status == 0) {
            return '交易暂时关闭';
        }
        return true;
    }
}
