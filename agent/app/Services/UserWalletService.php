<?php

namespace App\Services;

use App\Models\ListingApplication;
use App\Models\UserCoinName;
use App\Models\SustainableAccount;
use App\Models\Recharge;
use App\Exceptions\ApiException;
use App\Models\Coins;
use App\Models\User;
use App\Models\UserSubscribe;
use App\Models\UserSubscribeRecord;
use App\Models\Withdraw;
use App\Models\UserWallet;
use App\Models\TransferRecord;
use App\Models\WithdrawalManagement;
use App\Services\HuobiService\HuobiapiService;
use App\Services\HuobiService\lib\HuobiLibService;
use http\Env\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\RegularExpressionTest;


class UserWalletService
{
    public function createWallet($user)
    {
        $coins = Coins::query()->where('status', 1)->get();
        $wallet_data = [];
        foreach ($coins as $coin) {
            $CoinName = UserCoinName::query()->where('coin_id', $coin['coin_id'])->first();
            if (blank($CoinName)) $CoinName = UserCoinName::query()->where('coin_id', 2)->first();
            if ($coin['USDT']) {
                $erc_address = UserCoinName::query()->where('coin_name', "ERC")->firstOrFail();
                $rand = mt_rand(1, 10);
                $wallet_data[] = [
                    'coin_id' => $coin['coin_id'],
                    'coin_name' => $coin['coin_name'],
                    'wallet_address' => $CoinName["address$rand"],
                    'erc_wallet_address' => $erc_address["address$rand"]
                ];
            } else {
                $rand = mt_rand(1, 10);
                $wallet_data[] = [
                    'coin_id' => $coin['coin_id'],
                    'coin_name' => $coin['coin_name'],
                    'wallet_address' => $CoinName["address$rand"]
                ];
            }

            #永续合约账户
            $result = SustainableAccount::query()->insert([
                'user_id' => $user['user_id'],
                'coin_id' => $coin['coin_id'],
                'coin_name' => $coin['coin_name'],
            ]);

        }

        return $user->user_wallet()->createMany($wallet_data);
    }

    public function updateWallet($user)
    {

    }

    public function recharge($user_id, $coin_id, $address, $amount)
    {
        global $wallet_data;

        if (preg_match('/^[_0-9a-z]{30,50}$/i', $address)) {
            $userWallet = UserWallet::query()->where(['user_id' => $user_id])->firstOrFail();
            $user = User::query()->where(['user_id' => $user_id])->firstOrFail();
            $coin = Coins::query()->where(['coin_id' => $coin_id])->firstOrFail();
            $collection = UserWallet::query()->where(['user_id' => "$user_id", 'coin_id' => "$coin_id"])->firstOrFail();
            $collection_wallet = $collection['wallet_address'];
            $time = time();
            $result = Recharge::query()->insert([
                'user_id' => $userWallet['user_id'],
                'username' => $user['username'],
                'coin_id' => $coin_id,
                'coin_name' => $coin['coin_name'],
                'collection_wallet' => $collection_wallet,
                'datetime' => $time,
                'address' => "$address",
                'amount' => $amount,
            ]);
            if (!$result) {
                return api_response()->error(100, "提交失败");
            } else {
                return api_response()->successString('SUCCESS', true);
            }
        } else {
            return api_response()->error(100, "请填写正确的钱包地址");
        }


    }

    #充值处理
    public function rechargeDispose($user_id, $status, $coin_id)
    {
        if ($status == 1) {
            $money = Recharge::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'status' => 0])->firstOrFail();
            Recharge::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'id' => $money['id']])->update([
                'status' => $status
            ]);
            $user = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->firstOrFail();
            $usable_balance = $user['usable_balance'] + $money['amount'];
            UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->update([
                'usable_balance' => $usable_balance
            ]);
            return api_response()->success('SUCCESS', "充值成功");
        } elseif ($status == 2) {
            $first = Recharge::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'status' => 0])->firstOrFail();
            Recharge::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'id' => $first['id']])->update([
                'status' => $status
            ]);
            return api_response()->error(100, "充值失败");
        } else {
            return api_response()->error(100, "等待处理");
        }


    }

    #提币处理
    public function withdrawDispose($user_id, $status, $coin_id)
    {
        if ($status == 1) {
            $money = Withdraw::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'status' => 0])->firstOrFail();
            Withdraw::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'id' => $money['id']])->update([
                'status' => $status
            ]);
            return api_response()->success('SUCCESS', "提币成功");

        } elseif ($status == 2) {

            $money = Withdraw::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'status' => 0])->firstOrFail();
            Withdraw::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'id' => $money['id']])->update([
                'status' => $status
            ]);
            $user = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->firstOrFail();
            $coin = Coins::query()->where(['coin_id' => $coin_id])->firstOrFail();
            $usable_balance = $user['usable_balance'] + $money['amount'] + $coin['withdrawal_fee'];
            UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->update([
                'usable_balance' => $usable_balance
            ]);
            return api_response()->error(100, "提币失败,币种已返还");

        } else {
            return api_response()->error(100, "等待处理");
        }
    }

    #充币记录
    public function depositHistory($user_id)
    {
        $result = Recharge::query()->where(['user_id' => $user_id])->orderBy("id", 'desc')->paginate();
        return api_response()->success('SUCCESS', $result);

    }

    #提币
    public function withdraw($user_id, $coin_id, $address, $amount, $address_note)
    {
        if (preg_match('/^[_0-9a-z]{30,50}$/i', $address)) {
            DB::beginTransaction();
            try {
                $user = User::query()->where(['user_id' => $user_id])->firstOrFail();;
                $coin = Coins::query()->where(['coin_id' => $coin_id])->firstOrFail();
                $userWallet = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->firstOrFail();

//        $agentName = $user['agent_name'];
//        $agentLevel　= $user['agent_level'];
                $money = $userWallet['usable_balance'];

                if ($amount <= 0) {
                    return api_response()->error(100, "提币数量不能小于0");

                }
                if (($amount + $coin['withdrawal_fee']) > $money) {
                    return api_response()->error(100, "提币数量超过范围");
                }
                if ($address == null) {
                    return api_response()->error(100, "提币地址不能为空");

                }
                $datetime = time();
                $result = Withdraw::query()->insert([
                    'user_id' => $user_id,
                    'coin_id' => $coin_id,
                    'username' => $user['username'],
                    'amount' => $amount,
                    'coin_name' => $coin['coin_name'],
                    'address' => $address,
                    'datetime' => $datetime
                ]);
                $usable_balance = $money - ($amount + $coin['withdrawal_fee']);
                $result2 = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id])->update([
                    'usable_balance' => $usable_balance
                ]);
                $withdrawal_management = WithdrawalManagement::query()->where(['address' => $address])->first();
                $datetime = time();
                if ($withdrawal_management['address'] != $address) {
                    WithdrawalManagement::query()->insert([
                        'user_id' => $user_id,
                        'address' => $address,
                        'address_note' => $address_note,
                        'coin_name' => $coin['coin_name'],
                        'datetime' => $datetime,
                    ]);
                }

                if ($result && $result2) {
                    DB::commit();
                    return api_response()->successString('SUCCESS', true);
                } else {
                    return api_response()->error(100, "提交失败");
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return api_response()->error(100, "提交失败");
//            return $this->error(0,$e->getMessage(),$e);
            }
        } else {
            return api_response()->error(100, "请填写正确的钱包地址");
        }

    }

#提币记录
    public function withdrawalRecord($user_id)
    {
        $result = Withdraw::query()->where(['user_id' => $user_id])->orderBy("id", 'desc')->paginate();
        return api_response()->success('SUCCESS', $result);
    }

    public function walletImage($coin_id, $user_id, $address_type)
    {
        if ($address_type == "2") {
            #钱包二维码
            $user = userWallet::query()->where(['user_id' => $user_id])->firstOrFail();
            $coin = Coins::query()->where(['coin_id' => $coin_id])->firstOrFail();

            $user_id = $user['user_id'];
            $coin_id = $coin['coin_id'];
            $user_wallet = UserWallet::query()->where(['user_id' => "$user_id", 'coin_id' => "$coin_id"])->firstOrFail();
            $wallet['address'] = $user_wallet['erc_wallet_address'];
        } else {
            #钱包二维码
            $user = userWallet::query()->where(['user_id' => $user_id])->firstOrFail();
            $coin = Coins::query()->where(['coin_id' => $coin_id])->firstOrFail();
            $user_id = $user['user_id'];
            $coin_id = $coin['coin_id'];
            $user_wallet = UserWallet::query()->where(['user_id' => "$user_id", 'coin_id' => "$coin_id"])->firstOrFail();
            $wallet['address'] = $user_wallet['wallet_address'];
        }
        return api_response()->success('SUCCESS', $wallet);

    }

    #账户钱包资金划转
    #账户钱包资金划转
    public function fundsTransfer($user_id, $coin_name, $coin_id, $amount, $first_account, $last_account)
    {
        #UserWallet CoinAccount   SustainableAccount OptionAccount
//        global $result1,$result2,$result3,$first,$last,$time,$direction;

        global $draw_out_direction, $into_direction;
        DB::beginTransaction();
        try {
            #资金划转期权账户开始#
            if ($first_account != null && $last_account != null) {

                switch ($first_account) {
                    case "UserWallet":
                        $first = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->firstOrFail();
                        break;

                    case "ContractAccount":
                        $first = SustainableAccount::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->firstOrFail();
                        break;
                    case "LeverageAccount":

                        break;
                    case "FinancialAccount":

                        break;


                }
                switch ($last_account) {
                    case "UserWallet":
                        $last = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->firstOrFail();
                        break;

                    case "ContractAccount":
                        $last = SustainableAccount::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->firstOrFail();
                        break;
                    case "LeverageAccount":

                        break;
                    case "FinancialAccount":

                        break;
                }

                #可用余额
                $usable_balance = $first['usable_balance'];
                if ($amount > $usable_balance) {
                    return api_response()->error(100, "超出可划转余额,请重新输入");
                }
                $first['usable_balance'] = $first['usable_balance'] - $amount;
                $last['usable_balance'] = $last['usable_balance'] + $amount;
                switch ($first_account) {
                    case "UserWallet":
                        $result1 = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->update([
                            'usable_balance' => $first['usable_balance']]);
                        break;

                    case "ContractAccount":
                        $result1 = SustainableAccount::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->update([
                            'usable_balance' => $first['usable_balance']]);
                        break;
                    case "LeverageAccount":

                        break;
                    case "FinancialAccount":

                        break;
                }
                switch ($last_account) {
                    case "UserWallet":
                        $result2 = UserWallet::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->update([
                            'usable_balance' => $last['usable_balance'],
                        ]);
                        break;

                    case "ContractAccount":
                        $result2 = SustainableAccount::query()->where(['user_id' => $user_id, 'coin_id' => $coin_id, 'coin_name' => $coin_name])->update([
                            'usable_balance' => $last['usable_balance'],
                        ]);
                        break;
                    case "LeverageAccount":

                        break;
                    case "FinancialAccount":

                        break;

                }


            }
            switch ($first_account) {
                case "UserWallet":
                    $draw_out_direction = "资金账户";
                    break;
                case "ContractAccount":
                    $draw_out_direction = "合约账户";
                    break;
                case "LeverageAccount":

                    break;
                case "FinancialAccount":

                    break;
            }
            #期权划转资金账户结束#
            switch ($last_account) {
                case "UserWallet":
                    $into_direction = "资金账户";
                    break;
                case "ContractAccount":
                    $into_direction = "合约账户";
                    break;
                case "LeverageAccount":

                    break;
                case "FinancialAccount":

                    break;
            }


            $time = time();
            $result3 = TransferRecord::query()->insert([
                'user_id' => $user_id,
                'coin_id' => $coin_id,
                'coin_name' => $coin_name,
                'amount' => $amount,
                'draw_out_direction' => $draw_out_direction,
                'into_direction' => $into_direction,
                'datetime' => $time,
                'status' => 1,
            ]);
            if ($result1 && $result2 && $result3) {

                DB::commit();
                return api_response()->successString('SUCCESS', true);

            }


        } catch (\Exception $e) {
            DB::rollBack();

            return api_response()->error(100, "该币种不可划转");
        }


    }


    #钱包划转记录
    public function transferRecord($user_id)
    {
        $result = TransferRecord::query()->where(['user_id' => $user_id])->orderBy("id", 'desc')->paginate();

        return api_response()->success('SUCCESS', $result);
    }

    #合约账户
    public function sustainableAccount($user_id)
    {
        global $price;
        $btc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
        $eth_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'ethusdt' . '_detail')['close'];
        $eos_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'eosusdt' . '_detail')['close'];
        $etc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'etcusdt' . '_detail')['close'];
        $wallet_data = [];
        $result = SustainableAccount::query()->where(['user_id' => $user_id])->paginate();
        foreach ($result as $data) {
            switch ($data['coin_name']) {
                case "BTC":
                    $price = $btc_tickers;
                    $minDeposite = 0.0001;
                    $maxWithdraw = 10;
                    break;
                case "ETH":
                    $price = $eth_tickers;
                    $minDeposite = 0.01;
                    $maxWithdraw = 1000;
                    break;
                case "EOS":
                    $price = $eos_tickers;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;
                case "ETC":
                    $price = $etc_tickers;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;
                default;
                    $price = 1;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;


            }
            $logo = coins::query()->where(['coin_name' => $data['coin_name']])->firstOrFail();
            $wallet_data['list'][] = [
                'usable_balance' => $data['usable_balance'],
                'freeze_balance' => $data['freeze_balance'],
                'valuation' => $data['usable_balance'] + $data['freeze_balance'],
                'coin_name' => $data['coin_name'],
                'image' => getFullPath($logo['coin_icon']),
                'full_name' => $logo['full_name'],
                'usd_estimate' => number_format(($data['usable_balance'] + $data['freeze_balance']) * $price, 2),
                'qtyDecimals' => $logo['qty_decimals'],
                'priceDecimals' => $logo['price_decimals'],
                'minDeposite' => $minDeposite,
                'maxWithdraw' => $maxWithdraw,
            ];
        }
        return api_response()->success('SUCCESS', $wallet_data);
    }

    #资金账户
    public function fundAccount($user_id)
    {
        global $price, $minDeposite, $maxWithdraw, $symbol;
        $symbol = [];
        $btc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
        $eth_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'ethusdt' . '_detail')['close'];
        $eos_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'eosusdt' . '_detail')['close'];
        $etc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'etcusdt' . '_detail')['close'];
        $wallet_data = [];
        $result = UserWallet::query()->where(['user_id' => $user_id])->paginate();

        foreach ($result as $data) {
            switch ($data['coin_name']) {
                case "BTC":
                    $price = $btc_tickers;
                    $minDeposite = 0.0001;
                    $maxWithdraw = 10;
                    break;
                case "ETH":
                    $price = $eth_tickers;
                    $minDeposite = 0.01;
                    $maxWithdraw = 1000;
                    break;
                case "EOS":
                    $price = $eos_tickers;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;
                case "ETC":
                    $price = $etc_tickers;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;
                default;
                    $price = 1;
                    $minDeposite = 1;
                    $maxWithdraw = 10000;
                    break;


            }
            $logo = coins::query()->where(['coin_name' => $data['coin_name']])->firstOrFail();
            $data_name = $data['coin_name'];
            if ($data['coin_name'] == "USDT") {
                $symbol[$data_name][] = ['coin_name' => strtolower("BTC" . "/" . "USDt"), 'coin_id' => $data['coin_id']];
                $symbol[$data_name][] = ['coin_name' => strtolower("ETH" . "/" . "USDt"), 'coin_id' => $data['coin_id']];
            } else if ($data['coin_name'] == "BTC") {
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "USDt"), 'coin_id' => $data['coin_id']];
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "ETH"), 'coin_id' => $data['coin_id']];
            } else if ($data['coin_name'] == "ETH") {
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "USDt"), 'coin_id' => $data['coin_id']];
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "BTC"), 'coin_id' => $data['coin_id']];
            } else {
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "USDt"), 'coin_id' => $data['coin_id']];
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "BTC"), 'coin_id' => $data['coin_id']];
                $symbol[$data_name][] = ['coin_name' => strtolower($data['coin_name'] . "/" . "ETH"), 'coin_id' => $data['coin_id']];
            }

            $wallet_data['list'][] = [
                'usable_balance' => $data['usable_balance'],
                'freeze_balance' => $data['freeze_balance'],
                'valuation' => $data['usable_balance'] + $data['freeze_balance'],
                'coin_name' => $data['coin_name'],
                'coin_id' => $data['coin_id'],
                'image' => getFullPath($logo['coin_icon']),
                'full_name' => $logo['full_name'],
                'usd_estimate' => number_format(($data['usable_balance'] + $data['freeze_balance']) * $price, 2),
                'symbol' => $symbol[$data['coin_name']],
                'qtyDecimals' => $logo['qty_decimals'],
                'priceDecimals' => $logo['price_decimals'],
                'minDeposite' => $minDeposite,
                'maxWithdraw' => $maxWithdraw,

            ];
        }
        return api_response()->success('SUCCESS', $wallet_data);
    }


    public function personalAssets($user_id)
    {
        $btc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
        $eth_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'ethusdt' . '_detail')['close'];
        $eos_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'eosusdt' . '_detail')['close'];
        $etc_tickers = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'etcusdt' . '_detail')['close'];

//        约总资产等于多少BTC
//        约总资产等于多少USD

//        合约账户 等于多少BTC  等于多少USD
//        资金账户 等于多少BTC  等于多少USD
//        $total_assets_btc
//        $total_assets_usd
//        global $user_coin_name;
//        $tickers = (new HuobiapiService())->get_market_tickers();
//        $btc_tickers = (new HuobiapiService())->getDetailMerged('btcusdt');
//        $eth_tickers = (new HuobiapiService())->getDetailMerged('ethusdt');
//        $eos_tickers = (new HuobiapiService())->getDetailMerged('eosusdt');
//        $etc_tickers = (new HuobiapiService())->getDetailMerged('etcusdt');
        global $price, $totalUsd, $totalBtc, $fundsUsd, $fundsBtc, $total_assets_btc, $total_assets_usd;


//
//            return api_response()->success('SUCCESS',$btc_tickers);
//         return $btc_tickers['tick']['close'].$eth_tickers['tick']['close'].$eos_tickers['tick']['close'].$etc_tickers['tick']['close'];
//
//
        $totalUsd = 0;
        $totalBtc = 0;
        $fundsUsd = 0;
        $fundsBtc = 0;
        $wallet_data = [];
        $user_wallet = UserWallet::query()->where(['user_id' => $user_id])->get();

        foreach ($user_wallet as $users) {
            switch ($users['coin_name']) {
                case "BTC":
                    $price = $btc_tickers;
                    break;
                case "ETH":
                    $price = $eth_tickers;
                    break;
                case "EOS":
                    $price = $eos_tickers;
                    break;
                case "ETC":
                    $price = $etc_tickers;
                    break;
                default;
                    $price = 1;
                    break;


            }


            $fundsUsd += ($users['usable_balance'] + $users['freeze_balance']) * $price;


        }
        $sustaiable_wallet = SustainableAccount::query()->where(['user_id' => $user_id])->get();

        foreach ($sustaiable_wallet as $users) {
            switch ($users['coin_name']) {
                case "BTC":
                    $price = $btc_tickers;
                    break;
                case "ETH":
                    $price = $eth_tickers;
                    break;
                case "EOS":
                    $price = $eos_tickers;
                    break;
                case "ETC":
                    $price = $etc_tickers;
                    break;
                default;
                    $price = 1;
                    break;


            }


            $totalUsd += ($users['usable_balance'] + $users['freeze_balance']) * $price;


        }

        $total_assets_usd = $totalUsd + $fundsUsd;
        $total_assets_btc = $total_assets_usd / $btc_tickers;
        $assets_btc = $fundsUsd / $btc_tickers;
        $contract_btc = $totalUsd / $btc_tickers;

        $wallet_data['funds_account_usd'] = number_format($fundsUsd, 4); #资金账户USD
        $wallet_data['funds_account_btc'] = number_format($assets_btc, 4);  #资金账户BTC
        $wallet_data['contract_account_usd'] = number_format($totalUsd, 4); #合约账户USD
        $wallet_data['contract_account_btc'] = number_format($contract_btc, 4);  #合约账户BTC
        $wallet_data['total_assets_usd'] = number_format($total_assets_usd, 4);  #总资产USD
        $wallet_data['total_assets_btc'] = number_format($total_assets_btc, 4); #总资产BTC


        return api_response()->success('SUCCESS', $wallet_data);


    }

    public function tokenList($user_id, $first_account)
    {
        global $minQty;
        $wallet_data = [];
        switch ($first_account) {
            case "UserWallet":
                #查询当前字段中coin_name中BTC和USDT
                $first = UserWallet::query()->where(['user_id' => $user_id])->whereRaw('coin_name in ("BTC","USDT")')->get();
                foreach ($first as $result) {
                    $logo = Coins::query()->where(['coin_name' => $result['coin_name']])->first();
                    switch ($logo['coin_name']) {
                        case "BTC":
                            $minQty = '0.000001';
                            break;
                        case "ETH":
                            $minQty = '0.0001';
                            break;
                        case "EOS":
                            $minQty = '0.01';
                            break;
                        case "ETC":
                            $minQty = '0.001';
                            break;
                        case "EET":
                            $minQty = '1';
                            break;
                        case "USDT":
                            $minQty = '1';
                            break;
                    }
                    $wallet_data['list'][] = [
                        'coin_id' => $result['coin_id'],
                        'usable_balance' => $result['usable_balance'],
                        'full_name' => $logo['full_name'],
                        'image' => getFullPath($logo['coin_icon']),
                        'coin_name' => $logo['coin_name'],
                        'qtyDecimals' => $logo['qty_decimals'],
                        'priceDecimals' => $logo['price_decimals'],
                        'minQty' => "$minQty",
                    ];
                }

                break;
            case "ContractAccount":
                $first = SustainableAccount::query()->where(['user_id' => $user_id])->whereRaw('coin_name in ("BTC","USDT")')->get();
                foreach ($first as $result) {
                    $logo = Coins::query()->where(['coin_name' => $result['coin_name']])->first();
                    switch ($logo['coin_name']) {
                        case "BTC":
                            $minQty = '0.000001';
                            break;
                        case "ETH":
                            $minQty = '0.0001';
                            break;
                        case "EOS":
                            $minQty = '0.01';
                            break;
                        case "ETC":
                            $minQty = '0.001';
                            break;
                        case "EET":
                            $minQty = '1';
                            break;
                        case "USDT":
                            $minQty = '1';
                            break;
                    }
                    $wallet_data['list'][] = [
                        'coin_id' => $result['coin_id'],
                        'usable_balance' => $result['usable_balance'],
                        'full_name' => $logo['full_name'],
                        'img' => getFullPath($logo['coin_icon']),
                        'coin_name' => $logo['coin_name'],
                        'qtyDecimals' => $logo['qty_decimals'],
                        'priceDecimals' => $logo['price_decimals'],
                        'minQty' => "$minQty",
                    ];
                }
                break;
            case "LeverageAccount":

                break;
            case "FinancialAccount":

                break;
        }
        return api_response()->success('SUCCESS', $wallet_data);
    }

    public function withdrawalBalance($user_id, $coin_name)
    {
        global $withdrawal_min, $withdrawal_max;
        $wallet_data = [];
        $user_wallet = UserWallet::query()->where(['user_id' => $user_id, 'coin_name' => $coin_name])->firstOrFail();
        $coins = Coins::query()->where(['coin_name' => $user_wallet['coin_name']])->firstOrFail();
        switch ($user_wallet['coin_name']) {
            case "BTC";
                $withdrawal_fee = number_format($coins['withdrawal_fee'], 4);
                $withdrawal_min = 0.001;
                $withdrawal_max = 100;
                break;
            case "ETH";
                $withdrawal_fee = number_format($coins['withdrawal_fee'], 3);
                $withdrawal_min = 0.01;
                $withdrawal_max = 1000;
                break;
            case "ETC";
                $withdrawal_fee = number_format($coins['withdrawal_fee'], 3);
                $withdrawal_min = 0.1;
                $withdrawal_max = 10000;
                break;
            case "EOS";
                $withdrawal_fee = number_format($coins['withdrawal_fee'], 1);
                $withdrawal_min = 1;
                $withdrawal_max = 10000;
                break;
            case "USDT";
                $withdrawal_fee = number_format($coins['withdrawal_fee'], 0);
                $withdrawal_min = 10;
                $withdrawal_max = 10000;
                break;
            default :
                $withdrawal_fee = 10;
                $withdrawal_min = 10;
                $withdrawal_max = 10000;
                break;
        }
        $wallet_data['usable_balance'] = $user_wallet['usable_balance'];
        $wallet_data['withdrawal_fee'] = $withdrawal_fee;
        $wallet_data['withdrawal_min'] = $withdrawal_min;
        $wallet_data['withdrawal_max'] = $withdrawal_max;

        return api_response()->success('SUCCESS', $wallet_data);

    }


    public function withdrawalAddressManagement($user_id)
    {
        $wallet_data=[];
        $ii=0;
        $data = WithdrawalManagement::query()->where(['user_id' => $user_id])->orderBy("id", 'desc')->get()->groupBy('coin_name');
        if (blank($data)) {
            $coin = Coins::query()->whereRaw('coin_name in ("BTC","USDT")')->get();
            foreach ($coin as $con)
            {
                $wallet_data[$ii]['coin_name'] = $con['coin_name'];
                $wallet_data[$ii]['coin_id'] = $con['coin_id'];
                $wallet_data[$ii]['full_name'] = $con['full_name'];
                $wallet_data[$ii]['coin_icon'] = $con['coin_icon'];
                $wallet_data[$ii]['withdrawal_fee'] = $con['withdrawal_fee'];
                $return_data[$ii]['total_address'] = 0;
                $ii++;
            }

            return api_response()->success('SUCCESS', $wallet_data);
        } else {
            $data = $data->toArray();
        }
        $return_data = [];
        $kk = 0;
        foreach ($data as $coin_name => $results) {
            $coin = Coins::query()->where(['coin_name' => $coin_name])->first();
            if (blank($coin)) {
                return api_response()->success('SUCCESS', []);
            } else {
                $coin = $coin->toArray();
            }
            if ($coin['coin_name'] == "BTC" || $coin['coin_name'] == "USDT") {
                $return_data[$kk]['coin_name'] = $coin['coin_name'];
                $return_data[$kk]['coin_id'] = $coin['coin_id'];
                $return_data[$kk]['full_name'] = $coin['full_name'];
                $return_data[$kk]['coin_icon'] = $coin['coin_icon'];
                $return_data[$kk]['withdrawal_fee'] = $coin['withdrawal_fee'];
                $return_data[$kk]['total_address'] = count($results);
                foreach ($results as $key => $item) {
                    $return_data[$kk]['list'][$key] = $item;
                }
                $kk++;
            }

        }


        return api_response()->success('SUCCESS', $return_data);
    }

    public function withdrawalAddressDeleted($user_id, $id)
    {

        $result = WithdrawalManagement::query()->where(['user_id' => $user_id, 'id' => $id])->delete();
        if ($result) {
            return api_response()->successString('SUCCESS', true);
        } else {
            return api_response()->successString('SUCCESS', false);
        }

    }

    public function withdrawalAddressAdd($user_id, $address, $coin_name, $address_note)
    {
        if ($coin_name != "BTC" && $coin_name != "USDT") {
            return api_response()->error("100", "占时只支持添加BTC和USDT");
        }
        if (preg_match('/^[_0-9a-z]{30,50}$/i', $address)) {
            $withdrawal_management = WithdrawalManagement::query()->where(['address' => $address])->first();
            if ($withdrawal_management['address'] == $address) {
                return api_response()->error(100, "地址已存在请勿重新添加");
            }
            $result = WithdrawalManagement::query()->insert([
                'user_id' => $user_id,
                'address' => $address,
                'coin_name' => $coin_name,
                'address_note' => $address_note,
                'datetime' => time(),
            ]);
            if ($result) return api_response()->successString('SUCCESS', true);
        } else {
            return api_response()->error(100, "请填写正确的钱包地址");
        }

    }

    public function withdrawalAddressModify($user_id, $id, $address, $address_note)
    {
        if (preg_match('/^[_0-9a-z]{30,50}$/i', $address)) {
            $result = WithdrawalManagement::query()->where(['user_id' => $user_id, 'id' => $id])->update([
                'address' => $address,
                'address_note' => $address_note
            ]);
            if ($result) {
                return api_response()->successString('SUCCESS', true);

            } else {
                return api_response()->error(100, false);
            }

        } else {
            return api_response()->error(100, "请填写正确的钱包地址");
        }


    }

    public function withdrawalSelectAddress($user_id)
    {
        $data = UserWallet::query()->where(['user_id' => $user_id])->get();

        $wallet_data = [];
        foreach ($data as $result) {
            $logo = Coins::query()->where(['coin_name' => $result['coin_name']])->first();
            $wallet_data['list'][] = [
                'coin_name' => $result['coin_name'],
                'full_name' => $logo['full_name'],
                'coin_id' => $result['coin_id'],
                'image' => getFullPath($logo['coin_icon']),
            ];
        }

        return api_response()->success('SUCCESS', $wallet_data);

    }

    #申购
    public function subscribe($user_id)
    {

        $result = UserSubscribe::query()->where(['id' => 1])->firstOrFail();
        if (time() > $result['start_subscription_time'] && $result['end_subscription_time'] > time()) {
            $status = 2;
        } else if (time() > $result['end_subscription_time']) {
            $status = 3;
        } else if (time() > $result['announce_time']) {
            $status = 4;
        } else {
            $status = 1;
        }
        $result = UserSubscribe::query()->where(['id' => 1])->firstOrFail();
        $return_data = [
            'id' => $result['id'],
            'coin_name' => $result['coin_name'],
            'issue_price' => $result['issue_price'],
            'subscribe_currency' => $result['subscribe_currency'],
            'expected_time_online' => $result['expected_time_online'],
            'start_subscription_time' => $result['expected_time_online'],
            'end_subscription_time' => $result['end_subscription_time'],
            'announce_time' => $result['announce_time'],
            'status' => $status,
            'project_details' => $result['project_details'],
        ];
        return api_response()->success('SUCCESS', $return_data);
    }

    public function subscribeTokenList($user_id, $amount)
    {

        $btc_price = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
        $eth_price = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'ethusdt' . '_detail')['close'];
        $return_data = [];
        $first = UserWallet::query()->where(['user_id' => $user_id])->whereRaw('coin_name in ("BTC","USDT","ETH")')->get();
        foreach ($first as $key => $result) {
            $userSubscribe = UserSubscribe::query()->where(['id' => 1])->firstOrFail();
            $currency_price = $userSubscribe['issue_price'];
            if ($result['coin_name'] == "BTC") {
                $currency_amount = $btc_price * $amount / $currency_price;
            } else if ($result['coin_name'] == "ETH") {
                $currency_amount = $eth_price * $amount / $currency_price;
            } else {
                $currency_amount = 1 * $amount / $currency_price;
            }

            $return_data[$key] = [
                'coin_name' => $result['coin_name'],
                'proportion_amount' => number_format($currency_amount, 2),
                'subscribe_coin_name' => $userSubscribe['coin_name'],
            ];

        }

        return api_response()->success('SUCCESS', $return_data);
    }

    #申购
    public function subscribeNow($user_id, $amount, $coin_name)
    {
        $btc_price = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'btcusdt' . '_detail')['close'];
        $eth_price = Cache::store('redis')->tags('market_detail_usdt')->get('market:' . 'ethusdt' . '_detail')['close'];
        $user_wallet = UserWallet::query()->where(['user_id' => $user_id, 'coin_name' => $coin_name])->firstOrFail();
        $usable_balance = $user_wallet['usable_balance'];
        if ($amount > $usable_balance) {
            return api_response()->error(100, "资金账户币种余额不足");
        }
        DB::beginTransaction();
        try {
            $result = UserSubscribe::query()->where(['id' => 1])->firstOrFail();
            if (time() > $result['start_subscription_time'] && $result['end_subscription_time'] > time()) {
                $money = $usable_balance - $amount;
                $result1 = UserWallet::query()->where(['user_id' => $user_id, 'coin_name' => $coin_name])->update([
                    'usable_balance' => $money,
                ]);
                $userSubscribe = UserSubscribe::query()->where(['id' => 1])->firstOrFail();
                $currency_price = $userSubscribe['issue_price'];
                $subscription_currency_name=$userSubscribe['coin_name'];
                if ($coin_name == "BTC") {
                    $currency_amount = $btc_price * $amount / $currency_price;
                } else if ($coin_name == "ETH") {
                    $currency_amount = $eth_price * $amount / $currency_price;
                } else {
                    $currency_amount = 1 * $amount / $currency_price;
                }
                $result2 = UserSubscribeRecord::query()->insert([
                    'user_id' => $user_id,
                    'payment_amount' => $amount,
                    'payment_currency' => $coin_name,
                    'subscription_time' => time(),
                    'subscription_currency_name' => $subscription_currency_name,
                    'subscription_currency_amount' => $currency_amount,
                ]);
                if ($result1 && $result2) {
                    DB::commit();
                    return api_response()->success('SUCCESS', true);
                }
            } else if (time() > $result['end_subscription_time']) {
                    return api_response()->error(100, "申购已经结束,等待公布结果！！！");
            } else {
                    return api_response()->error(100, "申购预热中！！！");
            }


        } catch (\Exception $e) {
            DB::rollBack();

            return api_response()->error(100, false);
        }

    }

    public function subscribeAnnounceResults()
    {
        $return_data=[];
        $result=UserSubscribeRecord::query()->orderBy('subscription_currency_amount','desc')->paginate();
        User::query()->where([])->first();
        foreach ($result as $key=>$res)
        {
            $return_data[$key] = [
                'subscription_currency_amount' => $res['subscription_currency_amount'],
                'subscription_time' => $res['subscription_time'],
                'subscription_currency_name' => $res['subscription_currency_name'],
            ];
        }
        return api_response()->success('SUCCESS',$return_data);
    }
    #上币申请
    public function applicationForListing($user_id,$params)
    {
        return $params;
//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `coin_name` varchar(30) DEFAULT '0' COMMENT '币种英文名',
//  `coin_chinese_name` varchar(50) DEFAULT '0' COMMENT '币种中文名',
//  `contact_position` varchar(60) DEFAULT NULL COMMENT '联系人及职位',
//  `contact_phone` int(11) unsigned DEFAULT '0' COMMENT '联系人电话',
//  `coin_market_price` decimal(25,4) DEFAULT '0.0000' COMMENT 'Token市价',
//  `contact_email` varchar(20) DEFAULT NULL COMMENT '联系人邮箱',
//  `cotes_const` varchar(50) DEFAULT NULL COMMENT '项目注册地',
//  `agency_personnel` varchar(50) DEFAULT NULL COMMENT '项目投资机构/个人',
//  `currency_code` varchar(50) DEFAULT NULL COMMENT '币种代码(符号)',
//  `currency_identification` varchar(50) DEFAULT NULL COMMENT '币种标识(22px*22px)',
//  `placement` varchar(50) DEFAULT NULL COMMENT '募资日期',
//  `official_website` varchar(50) DEFAULT NULL COMMENT '官方网站',
//  `white_paper_link` varchar(50) DEFAULT NULL COMMENT '白皮书链接(若无链接上传附件)',
//  `currency_circulation` int(11) DEFAULT '0' COMMENT '币种总发行量',
//  `coin_turnover` int(11) unsigned DEFAULT '0' COMMENT '币种流通量',
//  `coin_allocation_proportion` varchar(30) DEFAULT NULL COMMENT '币种分配比例',
//  `cash_people_counting` int(11) DEFAULT NULL COMMENT '持币人数',
//  `online_bourse` varchar(50) DEFAULT NULL COMMENT '已上线交易平台',
//  `private_cemetery_price` decimal(25,4) unsigned NOT NULL COMMENT '私募/公墓价格',
//  `block_network_type` varchar(50) DEFAULT NULL COMMENT '币种区块网络类型(ETH,EOS)',
//  `currency_issue_date` varchar(50) DEFAULT NULL COMMENT '币种发行日期',
//  `blockchain_browser` varchar(50) DEFAULT NULL COMMENT '区块浏览器',
//  `official_wallet_address` varchar(100) DEFAULT NULL COMMENT '官方钱包地址',
//  `contract_address` varchar(200) DEFAULT NULL COMMENT '合约地址',
//  `twitter_link` varchar(50) DEFAULT NULL COMMENT 'Twitter链接',
//  `telegram_link` varchar(50) DEFAULT NULL COMMENT 'Telegram链接',
//  `facebook_link` varchar(50) DEFAULT NULL COMMENT 'Facebook链接',
//  `listing_fee_budget` decimal(25,4) DEFAULT '0.0000' COMMENT '上币费预算(BTC为单位)',
//  `market_currency_quantity` int(11) DEFAULT '0' COMMENT '上币后市场活动项目代币数量',
//  `currency_chinese_introduction` varchar(200) DEFAULT NULL COMMENT '币种中文介绍',
//  `currency_english_introduction` varchar(200) DEFAULT NULL COMMENT '币种英文介绍',
//  `Remarks` varchar(100) DEFAULT NULL COMMENT '备注',
//  `white_paper` varchar(50) DEFAULT NULL COMMENT '上传白皮书',
//  `referrer_mechanism_code` varchar(60) DEFAULT NULL COMMENT '推荐人姓名机构及推荐码(选填)',

          ListingApplication::query()->insert([

        ]);

    }

}
