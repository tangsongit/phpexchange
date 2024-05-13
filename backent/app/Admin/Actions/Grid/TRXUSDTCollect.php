<?php

namespace App\Admin\Actions\Grid;

use App\Jobs\CoinCollection;
use App\Models\UserWallet;
use App\Models\WalletCollection;
use App\Services\CoinService\GethService;
use App\Services\CoinService\GethTokenService;
use App\Services\CoinService\TronService;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use phpseclib\Math\BigInteger as BigNumber;
use Web3\Utils;

class TRXUSDTCollect extends RowAction
{
    /**
     * @return string
     */
    protected $title = '归集';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $id = $this->getKey();
        if (blank($id)) {
            return $this->response()->error('Processed fail.');
        }
        $wallet_address = UserWallet::query()->where('wallet_id', $id)->value('wallet_address');
        if (blank($wallet_address)) return $this->response()->error('地址为空');

        $min_amount = config('coin.collect_min_amount.usdt');
        $to = \App\Models\CenterWallet::query()->where('center_wallet_account', 'trx_collection_account')->value('center_wallet_address');
        $balance = (new TronService())->getTokenBalance(1, $wallet_address);

        // TODO 判断用户地址有没有可用的手续费
        return $this->response()->warning('......');
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        return ['Confirm?', '确认？'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    protected function parameters()
    {
        return [];
    }
}
