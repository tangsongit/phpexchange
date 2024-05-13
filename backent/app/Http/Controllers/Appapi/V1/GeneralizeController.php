<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: GuaPi
 * @Date: 2021-07-29 10:40:49
 * @LastEditors: GuaPi
 * @LastEditTime: 2021-08-25 11:31:23
 */

namespace App\Http\Controllers\Appapi\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\AdminSetting;
use App\Models\InvitePoster;
use App\Models\User;
use App\Models\UserWalletLog;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManagerStatic as Image;

class GeneralizeController extends ApiController
{
    // 推广

    //获取推广信息
    public function getGeneralizeInfo()
    {
        $user = $this->current_user();

        $data = [];

        $log_types = ['dividend'];
        $logs = UserWalletLog::query()->where('user_id', $user['user_id'])
            ->where('rich_type', 'usable_balance')
            ->whereIn('log_type', $log_types)
            ->get()->groupBy('coin_name');
        $amt = 0;
        foreach ($logs as $coin_name => $items) {
            if ($coin_name == 'USDT') {
                $price = 1;
            } else {
                $ticker = Cache::store('redis')->get('market:' . strtolower($coin_name) . 'usdt' . '_detail');
                $price = $ticker['close'] ?? 1;
            }
            $amount = abs($items->sum('amount'));
            $amt += PriceCalculate($amount, '*', $price, 4);
        }

        $data['invite_user_num'] = User::query()->where('pid', $user['user_id'])->count();
        $data['invite_dividend'] = $amt;
        $data['invite_code'] = $user['invite_code'];
        $data['invite_url'] = config('app.h5_url') . "/#/pages/reg/index?invite_code=" . $user['invite_code'];

        return $this->successWithData($data);
    }

    //推广邀请记录
    public function generalizeList(Request $request)
    {
        $user = $this->current_user();

        $per_page = $request->input('per_page', 10);

        //        $data = User::query()->where('referrer',$user['user_id'])->paginate();
        $data = User::query()->where('pid', $user['user_id'])->paginate($per_page);
        return $this->successWithData($data);
    }

    //推广返佣记录
    public function generalizeRewardLogs(Request $request)
    {
        $user = $this->current_user();

        $log_types = ['dividend'];

        $logs = UserWalletLog::query()->where('user_id', $user['user_id'])
            ->where('rich_type', 'usable_balance')
            ->whereIn('log_type', $log_types)
            ->paginate();

        return $this->successWithData($logs);
    }

    //申请代理
    public function applyAgency(Request $request)
    {
    }


    public function poster(Request $request)
    {
        if ($res = $this->verifyField($request->all(), [
            'bg_id' => 'nullable|integer',
        ])) return $res;

        $bg_id = $request['bg_id'] ?? null;
        $poster_data = InvitePoster::query()
            ->where('status', true)
            ->get();
        if (blank($bg_id)) return $this->successWithData($poster_data);
        $user = $this->current_user();
        $save_path = "poster/user-{$user['user_id']}-{$bg_id}.jpg"; //设置保存路径
        // 如果存在一小时内的图片
        if (
            File::isFile(public_path('storage/' . $save_path))
            &&
            ((time() - filemtime(public_path('storage/' . $save_path))) < 86400)
        ) return $this->successWithData(getFullPath($save_path));
        try {
            // 获取标题海报
            $setting = AdminSetting::query()
                ->where('module', 'invite')
                ->get()
                ->pluck('value', 'key');
            $invite_url = config('app.h5_url') . "/#/pages/reg/index?invite_code=" . $user['invite_code'];
            $background_path = $poster_data->find($bg_id)->image ?? null;
            if (blank($background_path)) return $this->error('not found');
            $qrcode = Image::make(QrCode::format('png')
                ->size(190)
                ->margin(1)
                ->generate($invite_url));
            $img = Image::make(public_path('storage/' . $background_path))->fit(1080, 2340);
            // 创建文字背景
            $content = Image::canvas(1080, 230, '#fff');
            $content->insert($qrcode, 'bottom-right', 20, 20);
            $content->text($setting['invite_title'], 40, 55, function ($font) {
                $font->file(public_path('storage/font/MSYH.TTC'));
                $font->size(50);
                $font->color('#1d313c');
                $font->align('left');
                $font->valign('top');
                $font->angle(0);
            });
            $content->text($setting['invite_subtitle'], 40, 140, function ($font) {
                $font->file(public_path('storage/font/MSYHL.TTC'));
                $font->size(43);
                $font->color('#8e9698');
                $font->align('left');
                $font->valign('top');
                $font->angle(0);
            });
            $img->insert($content, 'bottom', 0, 0);
            $img->save(public_path('storage/' . $save_path), null, 'jpg');
            return $this->successWithData(getFullPath($save_path));
        } catch (\Exception $e) {
            info($e);
            return $this->error('error');
        }
    }
    public function invite_qrcode()
    {
        $user = $this->current_user();
        $save_path = "invite_qrcode/user-{$user['user_id']}.png";
        // 如果存在一小时内的图片
        if (
            File::isFile(public_path('storage/' . $save_path))
            &&
            ((time() - filemtime(public_path('storage/' . $save_path))) < 86400)
        ) return $this->successWithData(getFullPath($save_path));
        $invite_url = config('app.h5_url') . "/#/pages/reg/index?invite_code=" . $user['invite_code'];
        QrCode::format('png')
            ->size(190)
            ->margin(1)
            ->generate($invite_url, public_path('storage/' . $save_path));
        return $this->successWithData(getFullPath($save_path));
    }
}
