<?php


namespace App\Services\CoinService;

use App\Exceptions\ApiException;
use App\Services\CoinService\Interfaces\CoinServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Tron;

class TronService implements CoinServiceInterface
{
    private $client;
    private $trongrid = 'https://api.trongrid.io';

    public function __construct()
    {
        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider(config('node.TRON_HOST'));
        $solidityNode = null;
        $eventServer = null;
        try {
            $this->client = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
        } catch (\IEXBase\TronAPI\Exception\TronException $e) {
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 获取TRX余额
     * @param $address
     * @return bool|float
     */
    public function getBalance($address)
    {
        try {
            return $this->client->getBalance($address, true);
        } catch (TronException $e) {
            return false;
        }
    }

    /**
     * 获取TRC20余额
     * @param string $address
     * @param string $contractAddress // 默认 USDT 智能合约地址：TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t
     * @param bool $fromTron
     * @return array|bool|int
     */
    public function getTokenBalance(string $address, string $contractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t', bool $fromTron = false)
    {
        try {
            $url = $this->trongrid . '/v1/accounts/' . $address . '?only_confirmed=true';
            $rsp = (new Client())->get($url);
            if (isset(\GuzzleHttp\json_decode($rsp->getBody())->error)) return 0;
            $account = json_decode($rsp->getBody()->getContents(), true);
            //        dd($rsp->getBody(),$account['trc20'],$account);
            if (isset($account['trc20']) and !empty($account['trc20'])) {
                $value = array_filter($account['trc20'], function ($v) use ($contractAddress) {
                    return key($v) == $contractAddress;
                });

                if (empty($value)) {
                    throw new TronException('Token id not found');
                }

                $first = array_shift($value);
                return ($fromTron == true ? $this->client->fromTron($first[$contractAddress]) : $first[$contractAddress]);
            }

            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * 获取TRC10余额
     * @param $tokenId
     * @param string $address
     * @param bool $fromTron
     * @return array|bool|int
     */
    public function getToken10Balance(int $tokenId, string $address, bool $fromTron = false)
    {
        try {
            return $this->client->getTokenBalance($tokenId, $address, true);
        } catch (TronException $e) {
            return false;
        }
    }

    public function listAccounts()
    {
        // TODO: Implement listAccounts() method.
    }

    public function getTransaction($transactionId)
    {
        try {
            return $this->client->getTransaction($transactionId);
        } catch (TronException $e) {
            return false;
        }
    }

    public function sendTransaction(string $from, string $to, float $amount, string $message = 'sendTransaction')
    {
        try {
            return $this->client->sendTransaction($to, $amount, $message, $from);
        } catch (TronException $e) {
            return false;
        }
    }

    public function sendTokenTransaction(string $from, string $to, float $amount, int $tokenID)
    {
        try {
            return $this->client->sendTokenTransaction($to, $amount, $tokenID, $from);
        } catch (TronException $e) {
            return false;
        }
    }

    public function newAccount()
    {
        try {
            return $this->client->createAccount();
        } catch (TronException $e) {
            return false;
        }
    }

    public function collectionUSDT($from, $to, $amount)
    {
        return false;
    }
}
