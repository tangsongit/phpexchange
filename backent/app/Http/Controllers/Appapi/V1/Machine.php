<?php

namespace App\Http\Controllers\Appapi\V1;

use App\Models\Coins;
use App\Models\TransferRecord;
use App\Models\UserWallet;
use App\Models\UserWalletLog;
use App\Services\UserService;
use App\Services\UserWalletService;
use App\Services\OtcService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\AdminSetting;
use App\Models\KuangjiList;
use App\Models\KuangjCycle;

class Machine extends ApiController
{
   
    //矿机列表
    public function machine_list(Request $request)
    {
        $data = KuangjiList::get();
        return $this->successWithData($data);
    }
    //矿机详情
    public function machine_details(Request $request)
    {
        if ($vr = $this->verifyField($request->all(), [
           'id' => 'required|string',
        ])) return $vr;
        $id =  $request->input('id');
        
        
        $data = KuangjCycle::where('kuang_id',$id)->get();
        
        return $this->successWithData($data);
    }
    //购买矿机
    public function machine_buy(Request $request){
        if ($vr = $this->verifyField($request->all(), [
           'id' => 'required|string', //周期id
        ])) return $vr;
        
         $user = $this->current_user();
         dd($user);
    }
}
