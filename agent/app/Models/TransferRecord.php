<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRecord  extends Model
{
    //划转记录

    protected $primaryKey = 'id';
    protected $table = 'user_transfer_record';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }

}
