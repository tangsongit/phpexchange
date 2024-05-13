<?php

/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2018/8/16
 * Time: 下午5:13
 * desc: 公共方法
 */

use App\Mail\VerifyCode;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Overtrue\EasySms\PhoneNumber;

function get_agent_child($data, $fid, $deep = null)
{
    $result = array();
    $fids = array($fid);
    //print_r($data);
    do {
        $cids = array();
        $flag = false;
        foreach ($fids as $fid) {
            for ($i = count($data) - 1; $i >= 0; $i--) {
                $node = $data[$i];

                if ($node['pid'] == $fid) {

                    array_splice($data, $i, 1);
                    //if(empty($deep)){
                    $result[] = $node['id'];
                    // }else{
                    //     if($node['deep'] == $deep){
                    //         $result[] = $node['id'];
                    //     }
                    // }
                    //echo $node['pid'] . "--".$node['id']."--" . $fid . "***";
                    $cids[] = $node['id'];
                    $flag = true;
                }
            }
        }
        $fids = $cids;
    } while ($flag === true);
    //print_r($result);
    return $result;
}

/**
 * @description: 获取用户无限极下级
 * @param {*} $user_id 用户ID
 * @param {*} $users    用户列表
 * @return {*} Array
 */
function get_childs($user_id, $users = null)
{
    if (blank($users)) {
        $users = \App\Models\User::all(['user_id', 'pid', 'is_agency']);
    };
    $childs = [];
    foreach ($users as $user) {
        if ($user['pid'] == $user_id) {
            $childs[] = $user;
            $childs = array_merge($childs, get_childs($user['user_id'], $users));
        }
    }
    return $childs;
}

/**
 * RSA私钥解密，需在php.ini开启php_openssl.dll扩展
 * @param string $after_encode_data 前端传来，经 RSA 加密后的数据
 * @return string 返回解密后的数据
 */
function rsa_decode($after_encode_data)
{
    $private_key = config('rsakey.private_key');
    openssl_private_decrypt(base64_decode($after_encode_data), $decode_result, $private_key);
    return $decode_result;
}

/**
 * @param $account
 * @param string $slider_type register|login
 * @return string
 */
function getSliderToken($account, $slider_type = 'register')
{
    $vKey = 'user:sliderVerify' . $slider_type . ':' . $account;
    $token = encrypt(getCode());
    Cache::put($vKey, $token, 300);
    return $token;
}

function checkSliderVerify($account, $token, $slider_type = 'register')
{
    $vKey = 'user:sliderVerify' . $slider_type . ':' . $account;
    if (!Cache::has($vKey)) return '验证已过期请重新验证';
    $cacheValue = Cache::get($vKey);
    if ((string)$cacheValue === (string)$token) {
        Cache::forget($vKey);
        return true;
    } else {
        return '验证失败';
    }
}

function custom_number_format($value, $decimals)
{
    return number_format($value, $decimals, '.', '');
}

function generateSignature($data)
{
    $key = encrypt($data);
    Cache::put($key, $data, 300);
    return $key;
}

function forgetSignature($key)
{
    return Cache::forget($key);
}

function getSignatureData($key)
{
    if (!Cache::has($key)) return false;
    return Cache::get($key);
}

function getFullPath($path, $disk = 'public')
{
    if (Str::contains($path, '//')) {
        return $path;
    }
    return blank($path) ? '' : url(\Illuminate\Support\Facades\Storage::disk($disk)->url($path));
}

function checkGoogleToken($google_token, $google_code)
{
    $google2fa = app('pragmarx.google2fa');
    if ($google2fa->verifyKey($google_token, $google_code) !== true) {
        return '谷歌验证失败';
    }
    return true;
}

function date_range(Carbon\Carbon $from, Carbon\Carbon $to, $seconds = 300, $inclusive = true)
{
    if ($from->gt($to)) {
        return null;
    }

    $from = $from->copy()->startOfDay();
    $to = $to->copy()->startOfDay();

    if ($inclusive) {
        $to->addDay();
    }

    $step = Carbon\CarbonInterval::seconds($seconds);
    $period = new DatePeriod($from, $step, $to);

    $range = [];

    foreach ($period as $day) {
        $range[] = (new Carbon\Carbon($day))->toDateTimeString();
    }

    return !empty($range) ? $range : null;
}

if (!function_exists('get_setting')) {
    /**
     * 根据key获取setting
     */
    function get_setting($key)
    {
        return \App\Models\Admin\AdminSetting::query()->where('key', $key)->first();
    }
}

if (!function_exists('get_setting_value')) {
    /**
     * 根据key获取setting
     */
    function get_setting_value($key, $default = null)
    {
        $builder = \App\Models\Admin\AdminSetting::query()->where('key', $key);

        $settingValue = $builder->first();

        return ($settingValue === null) ? $default : $settingValue->value;
    }
}

if (!function_exists('getLatLng')) {
    /**
     * 根据地址获取经纬度
     * @param string $address 地址
     * @param string $city 城市名
     * @return array
     */
    function getLatLng($address = '', $city = '')
    {
        $result = array();
        $ak = 'VnzK1bks0Ua5mU7GXPfiBUByhYZtVsET'; //您的百度地图ak，可以去百度开发者中心去免费申请
        $url = "http://api.map.baidu.com/geocoder?output=json&address=" . $address . "&city=" . $city . "&ak=" . $ak;
        $data = file_get_contents($url);

        $data = json_decode($data, true);
        //        dd($data);
        if (!empty($data) && $data['status'] == 'OK') {
            $result['lat'] = $data['result']['location']['lat'];
            $result['lng'] = $data['result']['location']['lng'];
            return $result; //返回经纬度结果
        } else {
            return null;
        }
    }
}

function second_array_unique_bykey($arr, $key)
{
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {
            $re = array_search($v[$key], $tmp_arr);
            unset($tmp_arr[$re]);
        }
        $tmp_arr[$k] = $v[$key];
    }

    foreach ($tmp_arr as $k => $v) {
        if (array_key_exists($k, $arr)) {
            $tmp[] = $arr[$k];
        }
    }
    return $tmp;
}

if (!function_exists('api_response')) {
    /**
     * API接口返回函数
     *
     * @param string $content
     * @param int    $status
     * @param array  $headers
     * @return \App\Services\ApiResponseService
     */
    function api_response($content = '', int $status = 200, array $headers = [])
    {
        return new \App\Services\ApiResponseService($content, $status, $headers);
    }
}
/**
 * PHP精确计算  主要用于货币的计算用法
 * @param $n1
 * @param $symbol  + - * / %
 * @param $n2
 * @param string $scale 精度 默认为小数点后两位
 * @return  string
 */
function PriceCalculate($n1, $symbol, $n2, $scale = '2')
{
    $res = "";
    if (function_exists("bcadd")) {
        switch ($symbol) {
            case "+": //加法
                $res = bcadd($n1, $n2, $scale);
                break;
            case "-": //减法
                $res = bcsub($n1, $n2, $scale);
                break;
            case "*": //乘法
                $res = bcmul($n1, $n2, $scale);
                break;
            case "/": //除法
                $res = bcdiv($n1, $n2, $scale);
                break;
            case "%": //求余、取模
                $res = bcmod($n1, $n2, $scale);
                break;
            default:
                $res = "";
                break;
        }
    } else {
        switch ($symbol) {
            case "+": //加法
                $res = $n1 + $n2;
                break;
            case "-": //减法
                $res = $n1 - $n2;
                break;
            case "*": //乘法
                $res = $n1 * $n2;
                break;
            case "/": //除法
                $res = $n1 / $n2;
                break;
            case "%": //求余、取模
                $res = $n1 % $n2;
                break;
            default:
                $res = "";
                break;
        }
    }
    return $res == 0 ? 0 : $res;
}

/**
 * 把数字1-1亿换成汉字表述，如：123->一百二十三
 * @param [num] $num [数字]
 * @return [string] [string]
 */

function numToWord($num)
{
    $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
    $chiUni = array('', '十', '百', '千', '万', '十', '百', '千', '亿', '十', '百', '千', '万', '十', '百', '千');
    $uniPro = array(4, 8);
    $chiStr = '';

    $num_str = (string)$num;

    $count = strlen($num_str);
    $last_flag = true; //上一个 是否为0
    $zero_flag = true; //是否第一个
    $temp_num = null; //临时数字
    $uni_index = 0;

    $chiStr = ''; //拼接结果
    if ($count == 2) { //两位数
        $temp_num = $num_str[0];
        $chiStr = $temp_num == 1 ? $chiUni[1] :                  $chiNum[$temp_num] . $chiUni[1];
        $temp_num = $num_str[1];
        $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
    } else if ($count > 2) {
        $index = 0;
        for ($i = $count - 1; $i >= 0; $i--) {
            $temp_num = $num_str[$i];
            if ($temp_num == 0) {
                $uni_index = $index % 15;
                if (in_array($uni_index, $uniPro)) {
                    $chiStr = $chiUni[$uni_index] . $chiStr;
                    $last_flag = true;
                } else if (!$zero_flag && !$last_flag) {
                    $chiStr = $chiNum[$temp_num] . $chiStr;
                    $last_flag = true;
                }
            } else {
                $chiStr = $chiNum[$temp_num] . $chiUni[$index % 16] . $chiStr;

                $zero_flag = false;
                $last_flag = false;
            }
            $index++;
        }
    } else {
        $chiStr = $chiNum[$num_str[0]];
    }
    return $chiStr;
}

/**
 * 分割中文字符串
 * $str 字符串
 * $count 个数
 */
function mb_zdystr_split($str, $count)
{
    $leng = strlen($str) / 3;     //中文长度
    $arr = array();
    for ($i = 0; $i < $leng; $i += $count) {
        $arr[] = mb_substr($str, $i, $count);
    }
    return $arr;
}

/**
 * @uses 根据生日计算年龄，生日的格式是：2016-09-23
 * @param string $birthday
 * @return string|number
 */
function calcAge($birthday)
{
    $iage = 0;
    if (!empty($birthday)) {
        $year = date('Y', strtotime($birthday));
        $month = date('m', strtotime($birthday));
        $day = date('d', strtotime($birthday));

        $now_year = date('Y');
        $now_month = date('m');
        $now_day = date('d');

        if ($now_year > $year) {
            $iage = $now_year - $year - 1;
            if ($now_month > $month) {
                $iage++;
            } else if ($now_month == $month) {
                if ($now_day >= $day) {
                    $iage++;
                }
            }
        }
    }
    return $iage;
}
function get_user_id_and_pids()
{
    $userIds = \Illuminate\Support\Facades\DB::table('users')->get(['user_id', 'pid'])->toArray();
    foreach ($userIds as &$v) {
        $v = ['user_id' => $v->user_id, 'pid' => $v->pid];
    }
    return $userIds;
}

function get_tree_child2($data, $fid)
{
    $result = array();
    $fids = array($fid);
    do {
        $cids = array();
        $flag = false;
        foreach ($fids as $fid) {
            for ($i = count($data) - 1; $i >= 0; $i--) {
                $node = $data[$i];
                if ($node['pid'] == $fid) {
                    array_splice($data, $i, 1);
                    $result[] = $node['user_id'];
                    $cids[] = $node['user_id'];
                    $flag = true;
                }
            }
        }
        $fids = $cids;
    } while ($flag === true);
    return $result;
}

//获取文章分类无限子分类
function get_tree_child($data, $fid)
{
    $result = array();
    $fids = array($fid);
    do {
        $cids = array();
        $flag = false;
        foreach ($fids as $fid) {
            for ($i = count($data) - 1; $i >= 0; $i--) {
                $node = $data[$i];
                if ($node['pid'] == $fid) {
                    array_splice($data, $i, 1);
                    $result[] = $node['category_id'];
                    $cids[] = $node['category_id'];
                    $flag = true;
                }
            }
        }
        $fids = $cids;
    } while ($flag === true);
    return $result;
}

//文章分类
function getParents1($categorys, $catId)
{
    $tree = array();
    while ($catId != 0) {
        foreach ($categorys as $item) {
            if ($item['id'] == $catId) {
                $tree[] = $item['id'];
                $catId = $item['pid'];
                break;
            }
        }
    }
    return $tree;
}

//商品分类
function getParents2($categorys, $catId)
{
    $tree = array();
    while ($catId != 0) {
        foreach ($categorys as $item) {
            if ($item['category_id'] == $catId) {
                $tree[] = $item['category_id'];
                $catId = $item['pid'];
                break;
            }
        }
    }
    return $tree;
}

function get_tree_parent($data, $id)
{
    $result = array();
    $obj = array();
    foreach ($data as $node) {
        $obj[$node['category_id']] = $node;
    }

    $value = isset($obj[$id]) ? $obj[$id] : null;
    while ($value) {
        $id = null;
        foreach ($data as $node) {
            if ($node['category_id'] == $value['pid']) {
                $id = $node['category_id'];
                $result[] = $node['category_id'];
                break;
            }
        }
        if ($id === null) {
            $result[] = $value['pid'];
        }
        $value = isset($obj[$id]) ? $obj[$id] : null;
    }
    unset($obj);
    return $result;
}

/**
 * 关联数组转换为索引数组
 * @param $arr
 * @return mixed
 */
function toIndexArr($arr)
{
    $i = 0;
    foreach ($arr as $key => $value) {
        $newArr[$i] = $value;
        $i++;
    }
    return $newArr;
}

/**
 * 多维数组去重
 * @param array
 * @return array
 */
function super_unique($array, $recursion = true)
{
    // 序列化数组元素,去除重复
    $result = array_map('unserialize', array_unique(array_map('serialize', $array)));
    //    dd($result);
    // 递归调用
    if ($recursion) {
        foreach ($result as $key => $value) {
            //            dd($value);
            if (is_array($value)) {
                $result[$key] = super_unique($value);
            }
        }
    }
    return $result;
}

//二维数组去重
function super_array_unique($array)
{

    $result = toIndexArr(array_map('unserialize', array_unique(array_map('serialize', $array))));

    return $result;
}

/**
 * 获取数组中的某一列
 * @param array $arr 数组
 * @param string $key_name  列名
 * @return array  返回那一列的数组
 */
function get_arr_column($arr, $key_name)
{
    $arr2 = array();
    foreach ($arr as $key => $val) {
        $arr2[] = $val[$key_name];
    }
    return $arr2;
}

function article_category_tree($data, $pid = 0)
{
    $tree = [];
    foreach ($data as $row) {
        if ($row['pid'] == $pid) {
            $tmp = article_category_tree($data, $row['id']);
            if ($tmp) {
                $row['children'] = $tmp;
            } else {
                $row['leaf'] = true;
            }
            $tree[] = $row;
        }
    }
    return $tree;
}

function comment_tree($data, $pid = 0)
{
    $tree = [];
    foreach ($data as $row) {
        if ($row['pid'] == $pid) {
            $tmp = comment_tree($data, $row['id']);
            if ($tmp) {
                $row['children'] = $tmp;
            } else {
                $row['leaf'] = true;
            }
            $tree[] = $row;
        }
    }
    return $tree;
}

function tree($data, $pid = 0)
{
    $tree = [];
    foreach ($data as $row) {
        if ($row['pid'] == $pid) {
            $tmp = tree($data, $row['category_id']);
            if ($tmp) {
                $row['children'] = $tmp;
            } else {
                $row['leaf'] = true;
            }
            $tree[] = $row;
        }
    }
    return $tree;
}

function outTree($tree)
{ //dd($tree);
    $data = [];
    foreach ($tree as $key => $row) {
        if (isset($row['children'])) {
            unset($tree[$key]['children']);
            $data = array_merge([$tree[$key]], outTree($row['children']));
        } else {
            $data[] = $row;
        }
    }
    return $data;
}

function datetime()
{
    return date('Y-m-d H:i:s', time());
}

//发送短信验证码
function sendCodeSMS($phone, $scene = 'verify', $countryCode = '86', $content = '')
{
    $key = $countryCode . $scene . ':' . $phone;
    //    if (Cache::has($key)){
    //        return '请勿重复发送';
    //    }
    $code = getCode();

    $easySms = app('easysms');
    $sign = SMSSign($scene);
    $content = $content == '' ? sprintf(SMSTemplates($scene), $code) : sprintf($content, $code);
    $content = '【' . $sign . '】' . $content;

    $phone = new PhoneNumber($phone, $countryCode);

    try {
        $result = $easySms->send($phone, [
            'content'  =>  $content
        ]);
    } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
        $message = $exception->getMessage();
        //dd($exception->getExceptions());
        throw new \App\Exceptions\ApiException($message ?: '短信发送异常');
    }

    if ($result) {
        //        dd($result);
        Cache::put($key, $code, 300);
        return true;
    } else {
        return '发送失败';
    }
}
//验证
function checkSMSCode($phone, $code, $scene = 'verify', $countryCode = '86')
{
    $key = $countryCode . $scene . ':' . $phone;

    if (!Cache::has($key)) return '手机验证码过期';
    $cacheValue = Cache::get($key);
    if ((string)$cacheValue === (string)$code) {
        //        Cache::forget($key);
        return true;
    } else {
        return '手机验证码不正确';
    }
}

function deleteSMSCode($phone, $scene = 'verify', $countryCode = '86')
{
    $key = $countryCode . $scene . ':' . $phone;
    Cache::forget($key);
}

function SMSTemplates($scene = 'verify')
{
    $app_locale = App::getLocale();
    if ($app_locale == 'en') {
        $scenes = [
            'verify' => 'Dear user, your SMS verification code is %s, valid within 3 minutes, please ignore if it is not operated by yourself.', //通用验证码
        ];
    } else {
        $scenes = [
            'verify' => '亲爱的用户，您的短信验证码为%s，在3分钟内有效，若非本人操作请忽略。', //通用验证码
        ];
    }

    if (!isset($scenes[$scene])) return $scenes['verify'];
    return $scenes[$scene];
}
function SMSSign($scene = 'verify')
{
    $scenes = [
        'verify' => env('MSG_SIGN') //用户注册验证码签名
    ];
    if (!isset($scenes[$scene])) return env('MSG_SIGN');
    return $scenes[$scene];
}
function currenctUser()
{
    try {
        return auth('api')->user();
    } catch (Exception $exception) {
        return false;
    }
}

/*发送邮箱验证码*/
function sendEmailCode($email, $scene = 'verify_code')
{
    $key = $scene . ':' . $email;
    //    if (Cache::has($key)){
    //        return '请勿重复发送';
    //    }
    $code = getCode();
    Mail::send('emails.verify_code', ['code' => $code], function ($message) use (&$email) {
        $message->to($email, 'TXSmall')->subject('Email验证邮件');
    }); //dd(Mail::failures());
    if (Mail::failures()) {
        return '发送失败';
    } else {
        Cache::put($key, $code, 300);
        return true;
    }
}

function checkEmailCode($email, $code, $scene = 'verify_code')
{
    $key = $scene . ':' . $email;
    if (!Cache::has($key)) return '邮箱验证码过期';
    $cacheValue = Cache::get($key);
    if ((string)$cacheValue === (string)$code) {
        return true;
    } else {
        return '邮箱验证码不正确';
    }
}

function getCode()
{
    return rand(100000, 999999);
}

//防注入，字符串处理，禁止构造数组提交
//字符过滤
//陶
function safe_replace($string)
{
    if (is_array($string)) {
        $string = implode('，', $string);
        $string = htmlspecialchars(str_shuffle($string));
    } else {
        $string = htmlspecialchars($string);
    }
    $string = str_replace('%20', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%2527', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace("select", "", $string);
    $string = str_replace("join", "", $string);
    $string = str_replace("union", "", $string);
    $string = str_replace("where", "", $string);
    $string = str_replace("insert", "", $string);
    $string = str_replace("delete", "", $string);
    $string = str_replace("update", "", $string);
    $string = str_replace("like", "", $string);
    $string = str_replace("drop", "", $string);
    $string = str_replace("create", "", $string);
    $string = str_replace("modify", "", $string);
    $string = str_replace("rename", "", $string);
    $string = str_replace("alter", "", $string);
    $string = str_replace("cas", "", $string);
    $string = str_replace("or", "", $string);
    $string = str_replace("=", "", $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('--', '', $string);
    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);

    return $string;
}

function curlPost($url, $postFields)
{
    $postFields = json_encode($postFields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json; charset=utf-8'
        )
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec($ch);
    if (false == $ret) {
        $result = curl_error($ch);
    } else {
        $rsp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $rsp) {
            $result = "请求状态 " . $rsp . " " . curl_error($ch);
        } else {
            $result = $ret;
        }
    }
    curl_close($ch);

    return $result;
}

function freeApiCurl($url, $params = false, $ispost = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'free-api');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
        return false;
    }
    curl_close($ch);
    return $response;
}

if (!function_exists('get_order_sn')) {
    // 生成订单编号
    function get_order_sn($prefix = '')
    {
        // 获取当前微秒数
        list($msec, $sec) = explode(" ", microtime());
        $msec = substr($msec, 2, 3);

        // 产生随机数
        $rand = mt_rand(100, 999);

        $orderSn = $prefix . $sec . $msec . $rand;

        return $orderSn;
    }
}

if (!function_exists('get_goods_sn')) {
    // 生成商品编号
    function get_goods_sn($prefix = 'goods')
    {
        // 获取当前微秒数
        list($msec, $sec) = explode(" ", microtime());
        $msec = substr($msec, 2, 3);

        // 产生随机数
        $rand = mt_rand(100, 999);

        $orderSn = $prefix . $sec . $msec . $rand;

        return $orderSn;
    }
}

function arr2xml($data)
{
    if (!is_array($data) || count($data) <= 0) {
        return false;
    }

    $xml = "<xml>";
    foreach ($data as $key => $val) {
        if (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        } else {
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
    }

    $xml .= "</xml>";

    return $xml;
}

/**
 * 解析 xml 为 array
 * @param $xml
 * @return array|SimpleXMLElement
 */
function parse_xml($xml)
{
    $data = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
    if (is_object($data) && get_class($data) === 'SimpleXMLElement') {
        $data = (array)$data;
    }

    return $data;
}
if (!function_exists('get_random_str')) {
    function get_random_str($len, $special = false)
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
        );

        if ($special) {
            $chars = array_merge($chars, array(
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ));
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }
}

if (!function_exists('set_sku_no')) { //获取商品sku编号

    function set_sku_no()
    {

        return 'sku' . date('YmdHi', time()) . get_random_str(5);
    }
}

function get_client_ip()
{
    $ip = FALSE;
    //客户端IP 或 NONE
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (!eregi("^(10│172.16│192.168).", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    //客户端IP 或 (最后一个)代理服务器 IP
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

// 两个数组相同键的值相加
function merge_array_add($arr1, $arr2)
{
    foreach ($arr2 as $x => $x_value) {
        if (array_key_exists($x, $arr1)) {
            $arr1[$x] += $arr2[$x];
        } else {
            $arr1[$x] = $arr2[$x];
        }
    }
    return $arr1;
}

// 两个数组相同键的值相减（数组1-数组二）
function merge_array_del($arr1, $arr2)
{
    foreach ($arr2 as $x => $x_value) {
        if (array_key_exists($x, $arr1)) {
            $arr1[$x] -= $arr2[$x];
        } else {
            $arr1[$x] = -$arr2[$x];
        }
    }
    return $arr1;
}
