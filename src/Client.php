<?php

namespace Shibanashiqc\NboPaymentGatewayPhp;

class Client
{
    private $url = 'https://unifiedpg.nbo.om/OLTPSTG/payment/hosted.htm';
    private $merchant_id, $password, $resource_key, $action;
    public function __construct($merchant_id, $password, $resource_key, $action = 1)
    {
        $this->merchant_id = $merchant_id;
        $this->password = $password;
        $this->resource_key = $resource_key;
        $this->action = $action;
    }

    /**
     * getURL
     *
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * setURL
     *
     * @param  mixed $url
     * @return void
     */
    public function setURL(string $url): void
    {
        $this->url = $url;
    }
        
    /**
     * getMerchantId
     *
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchant_id;
    }
        
    /**
     * setMerchantId
     *
     * @param  mixed $merchant_id
     * @return void
     */
    public function setMerchantId(string $merchant_id): void
    {
        $this->merchant_id = $merchant_id;
    }
             
    /**
     * getResourceKey
     *
     * @return string
     */
    public function getResourceKey(): string
    {
        return $this->resource_key;
    }
        
    /**
     * setResourceKey
     *
     * @param  mixed $resource_key
     * @return void
     */
    public function setResourceKey(string $resource_key): void
    {
        $this->resource_key = $resource_key;
    }
    
    /**
     * getAction
     *
     * @return int
     */
    
    public function getAction(): int
    {
        return $this->action;
    }
    
    /**
     * setAction
     *
     * @param  mixed $action
     * @return void
     */
    
    public function setAction(int $action): void
    {
        $this->action = $action;
    }
    
    /**
     * password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    
    /**
     * setPassword
     *
     * @param  mixed $password
     * @return void
     */
    
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
        
    /**
     * encryptAES
     *
     * @param  mixed $str
     * @param  mixed $key
     * @param  mixed $iv
     * @return string
     */
    public function encryptAES($str, $key, $iv = 'PGKEYENCDECIVSPC') : string
    {
        $ivlen = openssl_cipher_iv_length("aes-256-cbc");
        $str = $this->pkcs5Pad($str, $ivlen);
        $encrypted = openssl_encrypt($str, "aes-256-cbc", $key, OPENSSL_ZERO_PADDING, $iv);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }
    
    /**
     * pkcs5Pad
     *
     * @param  mixed $text
     * @param  mixed $blocksize
     * @return mixed
     */
    public function pkcs5Pad($text, $blocksize) : string
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    
    /**
     * byteArray2Hex
     *
     * @param  mixed $byte_array
     * @return mixed
     */
    public function byteArray2Hex($byte_array) : string
    {
        $chars = array_map("chr", $byte_array);
        $bin = join($chars);
        return bin2hex($bin);
    }
 
}
