<?php

namespace App\Models;

use App\Exceptions\ApiException;
use App\Models\Otc\UserLegalOrder;
use App\Services\UserWalletService;
use Carbon\Carbon;
use Dcat\Admin\Grid\Filter\Where;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    use ModelTree;
    use Notifiable;

    protected $primaryKey = 'user_id';
    protected $table = 'users';
    protected $guarded = [];

    // Tree
    protected $titleColumn = 'username';
    protected $orderColumn = 'user_id';
    protected $parentColumn = 'pid';

    protected $appends = ['is_set_payword', 'status_text', 'user_auth_level_text', 'user_identity_text'];

    protected $hidden = [
        'password', 'payword', 'login_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $attributes = [
        'user_grade' => 1,
        'user_identity' => 1,
        'is_agency' => 0,
        'user_auth_level' => 0,
        'status' => 1,
    ];

    //用户状态
    const user_status_freeze = 0; //冻结
    const user_status_normal = 1; //正常
    public static $userStatusMap = [
        self::user_status_freeze => '冻结',
        self::user_status_normal => '正常',
    ];

    //用户支付状态
    const user_deal_zero = 0; //不可交易
    const user_deal_one = 1; //可交易
    public static $userStatusDeal = [
        self::user_deal_zero => '锁定',
        self::user_deal_one => '正常',
    ];

    //用户认证
    const user_auth_level_wait = 0;
    const user_auth_level_primary = 1;
    const user_auth_level_top = 2;
    public static $userAuthMap = [
        self::user_auth_level_wait => '未认证',
        self::user_auth_level_primary => '初级认证',
        self::user_auth_level_top => '高级认证',
    ];

    //用户认证
    const use_phone = 0;
    const use_email = 1;
    public static $userType = [
        self::use_phone => "手机",
        self::use_email => "邮箱"
    ];
    //用户身份
    const user_identity_common = 1;
    public static $userIdentityMap = [
        self::user_identity_common => '普通用户',
    ];

    public function getStatusTextAttribute()
    {
        return self::$userStatusMap[$this->status];
    }

    public function getUserAuthLevelTextAttribute()
    {
        return self::$userAuthMap[$this->user_auth_level];
    }

    public function getUserIdentityTextAttribute()
    {
        return self::$userIdentityMap[$this->user_identity];
    }

    public function scopeNotFreeze($query)
    {
        return $query->where('status', '!=', self::user_status_freeze);
    }

    public function getIsSetPaywordAttribute()
    {
        $user = $this;

        $isset = 0;
        if (!blank($user->payword)) $isset = 1;

        return $isset;
    }

    /**
     * Get avatar attribute.
     *
     * @return mixed|string
     */
    public function getAvatar()
    {
        $avatar = $this->avatar;

        if ($avatar) {
            if (!URL::isValidUrl($avatar)) {
                $avatar = Storage::disk(config('admin.upload.disk'))->url($avatar);
            }

            return $avatar;
        }

        return admin_asset(config('admin.default_avatar') ?: '@admin/images/default-avatar.jpg');
    }

    public function getUserByPhone($phone)
    {
        return $this->newQuery()->where(['phone' => $phone])->first();
    }

    public function getUserByEmail($email)
    {
        return $this->newQuery()->where(['email' => $email])->first();
    }

    public function user_wallet()
    {
        return $this->hasMany(UserWallet::class, 'user_id', 'user_id');
    }

    public function one_wallet()
    {
        return $this->hasOne(UserWallet::class, 'user_id', 'user_id');
    }

    public function user_wallet_log()
    {
        return $this->hasMany(UserWalletLog::class, 'user_id', 'user_id');
    }

    public function user_payments()
    {
        return $this->hasMany('App\Models\UserPayment', 'user_id', 'user_id');
    }

    public function parent_user()
    {
        return $this->belongsTo('App\Models\User', 'pid');
    }

    public function children()
    {
        return $this->hasMany('App\Models\User', 'pid');
    }

    public function contract_entrust()
    {
        return $this->hasMany(ContractEntrust::class, 'user_id', 'user_id');
    }

    public function direct_user_count()
    {
        return $this->children()->count();
    }
    public function otc_order()
    {
        return $this->hasMany(UserLegalOrder::class, 'user_id', 'user_id');
    }

    /**
     * 更新用户钱包 并记录日志
     *
     * @param integer $coin_id 币种ID
     * @param string $rich_type 资产类型
     * @param float $amount 金额
     * @param integer $account_type 钱包账号类型
     * @param string $log_type 流水类型
     * @param string $log_note 流水描述
     * @param int $logable_id
     * @param string $logable_type
     * @return int|void
     * @throws ApiException
     */
    public function update_wallet_and_log($coin_id, $rich_type, $amount, $account_type, $log_type, $log_note = '', $logable_id = 0, $logable_type = '')
    {
        //如果$amount为零，则不记录;
        if ($amount == 0) {
            return;
        }

        $account_class = array_first(UserWallet::$accountMap, function ($value, $key) use ($account_type) {
            return $value['id'] == $account_type;
        });
        $account = new $account_class['model']();
        if (blank($account)) {
            // TODO 钱包账户不存在 更新创建该钱包账户
            //            (new UserWalletService())->updateWallet($this);
        }

        $wallet = $account->where(['user_id' => $this->user_id, 'coin_id' => $coin_id])->first();
        if (blank($wallet)) throw new ApiException('钱包类型错误');
        $balance = $wallet->$rich_type;

        if ($amount < 0 && $balance < abs($amount)) {
            throw new ApiException($account_class['name'] . $account->getRichMap()[$rich_type] . '资产不足');
        }

        if ($amount > 0) {
            $res = $wallet->increment($rich_type, abs($amount));
        } else {
            $res = $wallet->decrement($rich_type, abs($amount));
        }

        $this->user_wallet_log()->create([
            'account_type' => $account_type,
            'coin_id' => $coin_id,
            'rich_type' => $rich_type,
            'amount' => $amount,
            'before_balance' => $balance,
            'after_balance' => $wallet->$rich_type,
            'log_type' => $log_type,
            'log_note' => $log_note,
            'logable_id' => $logable_id,
            'logable_type' => $logable_type,
        ]);

        return $res;
    }

    //根据用户取出无限级子用户
    public static function getSubChildren($user_id, $subIds = [])
    {
        $users = User::query()->where('pid', $user_id)->select(['user_id', 'pid'])->get();
        foreach ($users as $key => $value) {
            $subIds[] = $value['user_id'];
            $user = User::query()->where('pid', $value['user_id'])->select(['user_id', 'pid'])->get();
            if ($user) {
                $subIds = self::getSubChildren($value['user_id'], $subIds);
            }
        }
        return $subIds;
    }

    /**
     * @description: 获取用户无限极下级(单次查库)
     * @param  $user_id 用户ID
     * @param  $users    用户列表
     * @return  Array
     */
    public static function getChilds($user_id, $users = null)
    {
        if (blank($users)) {
            $users = self::all(['user_id', 'pid', 'is_agency', 'is_place']);
        };
        $childs = [];
        foreach ($users as $user) {
            if ($user['pid'] == $user_id) {
                $childs[] = $user;
                $childs = array_merge($childs, self::getChilds($user['user_id'], $users));
            }
        }
        return $childs;
    }

    public function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword($password, $pHash)
    {
        throw_if(blank($this->payword), new ApiException('交易密码未设置', 1034));

        return password_verify($password, $pHash);
    }

    public static function gen_invite_code($length = 8)
    {
        $pattern = '0123456789';
        $code = self::gen_comm($pattern, $length);
        $users = User::query()->where('invite_code', $code)->first();
        if ($users) {
            return self::gen_invite_code($length);
        } else {
            return $code;
        }
    }

    public static function gen_login_code($length = 10)
    {
        $pattern = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return self::gen_comm($pattern, $length);
    }

    public static function gen_username($length = 8)
    {
        $pattern = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $username = self::gen_comm($pattern, $length);
        $users = User::query()->where('username', $username)->first();
        if ($users) {
            return self::gen_username($length);
        } else {
            return $username;
        }
    }

    private static function gen_comm($content, $length)
    {
        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $content{
                mt_rand(0, strlen($content) - 1)};    //生成php随机数
        }

        return $key;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAvatarAttribute($value)
    {
        return getFullPath($value);
    }

    public static function getDirectChilds($user_id)
    {
        return self::query()
            ->where('pid', $user_id)
            ->pluck('user_id')
            ->toArray();
    }
    public static function getParentUsers(int $user_id, $users = null)
    {
        if (empty($users)) {
            $users = self::all(['user_id', 'username', 'is_agency', 'is_place', 'pid']);
        }
        $tree = [];
        $tmp_id = $users->find($user_id)->pid;
        while ($tmp_parent = $users
            ->where('user_id', $tmp_id)
            ->first()
        ) {
            $tree[] = $tmp_parent;
            $tmp_id = $tmp_parent->pid;
        }
        return collect($tree);
    }
}
