<?php

namespace App\Http\Controllers\Api\V1;

class XRsa
{
    const RSA_ALGORITHM_SIGN = OPENSSL_ALGO_SHA256;
 
    protected $public_key;
    protected $private_key;
    protected $key_len;
 
    public function __construct($public_key, $private_key = null)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;

        $pub_id = openssl_pkey_get_public($this->public_key);
       
        $this->key_len = openssl_pkey_get_details($pub_id)['bits'];
    }
 
    /*
     * 公钥加密
     */
    public function publicEncrypt($data)
    {
        $encrypted = '';
        $part_len = $this->key_len / 8 - 11;
        $parts = str_split($data, $part_len);
 
        foreach ($parts as $part) {
            $encrypted_temp = '';
            openssl_public_encrypt($part, $encrypted_temp, $this->public_key);
            $encrypted .= $encrypted_temp;
        }
 
        return $this->urlSafeBase64Encode($encrypted);
    }
 
    /*
     * 私钥解密
     */
    public function privateDecrypt($encrypted)
    {
        $decrypted = '';
        $part_len = $this->key_len / 8;
        $base64_decoded = $this->urlSafeBase64Decode($encrypted);
        $parts = str_split($base64_decoded, $part_len);
 
        foreach ($parts as $part) {
            $decrypted_temp = '';
            openssl_private_decrypt($part, $decrypted_temp, $this->private_key);
            $decrypted .= $decrypted_temp;
        }

        return $decrypted;
    }
 
    /*
     * 私钥加密
     */
    public function privateEncrypt($data)
    {
        $encrypted = '';
        $part_len = $this->key_len / 8 - 11;
        $parts = str_split($data, $part_len);
 
        foreach ($parts as $part) {
            $encrypted_temp = '';
            openssl_private_encrypt($part, $encrypted_temp, $this->private_key);
            $encrypted .= $encrypted_temp;
        }
 
        return $this->urlSafeBase64Encode($encrypted);
    }
 
    /*
     * 公钥解密
     */
    public function publicDecrypt($encrypted)
    {
        $decrypted = '';
        $part_len = $this->key_len / 8;
        $base64_decoded = $this->urlSafeBase64Decode($encrypted);
        $parts = str_split($base64_decoded, $part_len);
 
        foreach ($parts as $part) {
            $decrypted_temp = '';
            openssl_public_decrypt($part, $decrypted_temp, $this->public_key);
            $decrypted .= $decrypted_temp;
        }

        return $decrypted;
    }
 
    /*
     * 数据加签
     */
    public function sign($data)
    {
        openssl_sign($data, $sign, $this->private_key, self::RSA_ALGORITHM_SIGN);

        return $this->urlSafeBase64Encode($sign);
    }
 
    /*
     * 数据签名验证
     */
    public function verify($data, $sign)
    {
        $pub_id = openssl_pkey_get_public($this->public_key);
        $res = openssl_verify($data, $this->urlSafeBase64Decode($sign), $pub_id, self::RSA_ALGORITHM_SIGN);
 
        return $res;
    }

    /*
     * Url Base64 安全加密
     */
    private function urlSafeBase64Encode($data)
    {
        $data = base64_encode($data);
        return str_replace(array('+','/','='),array('-','_',''),$data);
    }

    /*
     * Url Base64 安全解密
     */
    private function urlSafeBase64Decode($data)
    {
        $data = str_replace(array('-','_'),array('+','/'),$data);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
}
