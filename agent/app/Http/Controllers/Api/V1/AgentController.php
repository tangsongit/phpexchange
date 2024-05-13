<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function getUser($id){
        $agent = Agent::query()->where("is_agency",1)->get()->toArray();
        if( $id == 0  ) return [];

        $res = self::getChildren($agent,$id);

        return $res;
    }

    static function getChildren($data,$pid){

        static $arr=array();
        foreach ($data as $v) {
            /*if( $v["is_agency"] == "1" ) continue;*/

            if ( $v['pid']==$pid ) {
                $arr[]=$v['user_id'];

                self::getChildren($data,$v['user_id']);
            }
        }

        return $arr;
    }



    public function merge($arr){

        $array = array();
        $k = 0;
        foreach ($arr as $value ){

            if( $value["user_id"] == 1 ) continue;
            $array[$k] = $value["user_id"];
            $k++;
        }
        return $array;
    }



}
