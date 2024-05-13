<?php


namespace App\Http\Controllers\Api\V1;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Banner;
use App\Models\BlackList;
use App\Models\Collect;
use App\Models\InsideTradePair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Object_;


class IndexController extends ApiController
{
    #首页数据
    public function indexList(){


        $banner = Banner::query()->where(["status"=>1,"location_type"=>1])->limit(3)->get()->toArray();
        $icon = Article::query()->where(["status"=>1,"category_id"=>20])->limit(5)->get()->toArray();
        $market = [];

        $user = $this->current_user();
        if(blank($user)){
            $collect = [];
        }else{
            $collect = Collect::query()->where(array("user_id"=>$user->user_id))->pluck('pair_name')->toArray();
        }

        $data = InsideTradePair::query()->where("status",1)->get()->groupBy('quote_coin_name')->toArray();
        $kk = 0;
        foreach ($data as $coin_key => $items){
            $market[$kk]['coin_name'] = $coin_key;
            $quote_coin_name = strtolower($coin_key);
            foreach ($items as $key2 => $item){
                $market[$kk]['marketInfoList'][$key2] = Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $item['symbol'] . '_detail');
                $market[$kk]['marketInfoList'][$key2]['coin_name'] = $quote_coin_name;
                $market[$kk]['marketInfoList'][$key2]["pair_name"] = $item['pair_name'];
                $market[$kk]['marketInfoList'][$key2]["pair_id"] = $item['pair_id'];
                if(in_array($item['pair_name'],$collect)){
                    $market[$kk]['marketInfoList'][$key2]["is_collect"] = 1;
                }else{
                    $market[$kk]['marketInfoList'][$key2]["is_collect"] = 0;
                }

                $market[$kk]['marketInfoList'][$key2]["marketInfoList"] = $item['base_coin_name'];
            }
            $kk++;
        }

        $k = 0;
        $symbols = [];
        foreach ($market as $key=> $items) {

            foreach ($items["marketInfoList"] as  $coin) {

                $mark = strtolower($coin["marketInfoList"]).strtolower($items["coin_name"]);

                // 取实时的交易价格
                $symbol_name = 'market:' . $mark . '_newPrice';
                $data = Cache::store('redis')->get($symbol_name);

                $symbols[$k]['pair'] = $coin["marketInfoList"]."/".$items["coin_name"];
                $symbols[$k]["price"] = $data["price"];

                $symbols[$k]['increase'] = (float)$data["increase"];
                $symbols[$k]['increaseStr'] = $data["increaseStr"];
                $k++;
            }

        }


        $arr["iconList"] = $icon;
        $arr["homeList"] = $symbols;
        #公告

        $arr["articleList"] = Article::query()->where(array("category_id"=>"4"))->limit(5)->get()->toArray();
        $arr["marketList"] = $market;
        $arr["bannerList"] = $banner;
        return $this->successWithData($arr);

    }

    #黑名单
    public function blackList(){

        $ip = get_client_ip();

        $name = $this->get_info($ip);
        $black = BlackList::query()->where("nation_name",$name)->first();
        if( $black ){
            return $this->successWithData(true);
        }
        return  $this->responseJson("400","fail",false);
    }

    #添加取消自选交易对
    public function collect(Request $request){
        $user = $this->current_user();
        if( empty($user)) return $this->error("400","当前用户未登陆");

        if ( $res = $this->verifyField($request->all(),[
            /*'pair_id'=>'required|integer',*/
            'pair_name'=>'required'
        ])) return $res;

        $data = $request->all();
        $pair_name = $data["pair_name"];
        $data["user_id"] = $user->user_id;

        $where = array("user_id"=>$data["user_id"],"pair_name"=>$pair_name);

        $result = Collect::query()->where($where)->first();

        if( $result ){
            Collect::query()->where($where)->delete();
            return $this->responseJson(200,"cancelSuccess",false);
        }

        $data["created_at"] = time();
        Collect::create($data);
        return $this->responseJson(200,"addSuccess",true);
    }

    #获取自选交易对
    public function getCollect(Request $request){

        $user = $this->current_user();
        if( empty($user)) return $this->error(400,"当前用户未登陆");
        /*  $user = new Object_();
          $user->user_id = 17;*/
        $result = Collect::query()->where(array("user_id"=>$user->user_id))->pluck('pair_name')->toArray();

        if( !$result ){
            return  $this->responseJson(200,"success",[]);
        }

        foreach ( $result as $itmes ){

            $symbol = strtolower(str_before($itmes,'/') . str_after($itmes,'/'));
            $quote_coin_name = strtolower(str_after($itmes,'/'));
            $cache_data =  Cache::store('redis')->tags('market_detail_' . $quote_coin_name)->get('market:' . $symbol . '_detail');
            $cache_data['pair_name'] = $itmes;
            $data[] = $cache_data;
        }

        return  $this->responseJson("200","success",$data);
    }

    #帮助中心分类参数
    public function cataLog(){

        $article = ArticleCategory::query()->select("id","name")->find([1,2,3]);
        return $this->responseJson("200","successs",$article);
    }

    #联系我们详情信息
    public function relevance(){
        $rele = ArticleCategory::query()->where("name","联系我们")->value("id");

        $relevance = Article::query()->where("category_id",$rele)->value("excerpt");
        //$explode = explode(" ",$relevance);
        preg_match_all("/[^\s　]+/s",$relevance,$mt);
        if( empty($mt) ) return $this->error();
        $data = array();
        foreach ( $mt[0] as $value ){
            $split = explode(":",$value);
            if( !isset($split[1])){
                $split = explode("：",$value);
            }
            $data[$split[0]] = $split[1];

        }
        return $data;

    }

    #首页系统公告
    public function sysNotice(){
        $noticle = Article::query()->where("category_id",4)->limit(5)->get()->toArray();//1：未读 0：已读
        return $this->successWithData($noticle);
    }

    #联系我们
    public function contactUs(Request $request){
        if ($res = $this->verifyField($request->all(),[
            'realname'=>'required|string',
            'email' => 'required|string',
            'contents'=>'required|string',
            ''
        ])) return $res;



    }

    #学院一分钟如何购买比特币
    public function dealStrat(){
        $category = Article::query()->where("category_id",2)->get()->toArray();
        foreach ( $category as $value ){
            dd($value["body"],strip_tags($value["body"]));
        }
        dd($category);
    }

    #获取底部信息
    public function floor(){


        $res = ArticleCategory::query()
            ->where("pid",0)
            ->whereIn("name",["服务","学院","关于"])
            ->get()
            ->toArray();
        $arr = array();
        foreach ( $res as $k=>$value ){
            $arr[$k]["id"] = $value["id"];
            $arr[$k]["name"] = $value["name"];
            $arr[$k]["category"] =  ArticleCategory::query()
                ->where("pid", $value["id"])
                ->orderBy("order")
                ->select("id","name")
                ->get()->toArray();

        }
        #logo
        $logo = Banner::query()->where(["location_type"=>2])->first();
        $floor["logo"] = $logo;
        $floor["contactinfo"] = $this->relevance();
        $floor["floorList"] = $arr;
        $floor["power"] = $this->copyright();#版权
        return $this->successWithData($floor);
    }

    #版权信息
    public function copyright(){
        $classID = ArticleCategory::query()->where("name","版权信息")->value("id");
        return  Article::query()->where("category_id",$classID)->select("id","excerpt")->first();
    }


    public static function get_info($ip)
    {
        $url = "http://whois.pconline.com.cn/jsFunction.jsp?callback=jsShow&ip=" . $ip;

        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $info = iconv('GB2312', 'UTF-8', $output); //因为是js调用 所以接收到的信息为字符串，注意编码格式
        return  self::substr11($info);  //ArrayHelper是助手函数 可以将下面的方法追加到上面
    }

    public static function substr11($str)
    {
        preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $str, $regs);//preg_match_all（“正则表达式”,"截取的字符串","成功之后返回的结果集（是数组）"）
        $s = join('', $regs[0]);//join("可选。规定数组元素之间放置的内容。默认是 ""（空字符串）。","要组合为字符串的数组。")把数组元素组合为一个字符串
        $s = mb_substr($s, 0, 80, 'utf-8');//mb_substr用于字符串截取，可以防止中文乱码的情况
        return $s;
    }




}
