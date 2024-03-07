<?php

namespace Shibanashiqc\NboPaymentGatewayPhp;

use GuzzleHttp\Client as Http;
use Shibanashiqc\NboPaymentGatewayPhp\Client;

class Request
{
    public $client;
    public $responseURL, $errorURL, $udf1text, $udf2text, $udf3text, $udf4text, $udf5text;
    public $redirect_result;

    public function __construct($merchant_id, $password, $resource_key,  $action = 1)
    {
        $this->client = new Client($merchant_id, $password, $resource_key, $action);
    }

    /**
     * getResponseURL
     *
     * @return string
     */
    public function getResponseURL(): string
    {
        return $this->responseURL;
    }

    /**
     * setResponseURL
     *
     * @param  mixed $responseURL
     * @return void
     */
    public function setResponseURL(string $responseURL): void
    {
        $this->responseURL = $responseURL;
    }

    /**
     * getErrorURL
     *
     * @return string
     */
    public function getErrorURL(): string
    {
        return $this->errorURL;
    }

    /**
     * setErrorURL
     *
     * @param  mixed $errorURL
     * @return void
     */
    public function setErrorURL(string $errorURL): void
    {
        $this->errorURL = $errorURL;
    }

    /**
     * getUdf1text
     *
     * @return string
     */

    public function getUdf1text(): string
    {
        return $this->udf1text;
    }

    /**
     * setUdf1text
     *
     * @param  mixed $udf1text
     * @return void
     */

    public function setUdf1text(string $udf1text): void
    {
        $this->udf1text = $udf1text;
    }

    /**
     * getUdf2text
     *
     * @return string
     */

    public function getUdf2text(): string
    {
        return $this->udf2text;
    }

    /**
     * setUdf2text
     *
     * @param  mixed $udf2text
     * @return void
     */

    public function setUdf2text(string $udf2text): void
    {
        $this->udf2text = $udf2text;
    }

    /**
     * getUdf3text
     *
     * @return string
     */

    public function getUdf3text(): string
    {
        return $this->udf3text;
    }

    /**
     * setUdf3text
     *
     * @param  mixed $udf3text
     * @return void
     */

    public function setUdf3text(string $udf3text): void
    {
        $this->udf3text = $udf3text;
    }

    /**
     * getUdf4text
     *
     * @return string
     */

    public function getUdf4text(): string
    {
        return $this->udf4text;
    }

    /**
     * setUdf4text
     *
     * @param  mixed $udf4text
     * @return void
     */

    public function setUdf4text(string $udf4text): void
    {
        $this->udf4text = $udf4text;
    }

    /**
     * getUdf5text
     *
     * @return string
     */

    public function getUdf5text(): string
    {
        return $this->udf5text;
    }

    /**
     * setUdf5text
     *
     * @param  mixed $udf5text
     * @return void
     */

    public function setUdf5text(string $udf5text): void
    {
        $this->udf5text = $udf5text;
    }

    /**
     * getPaymentRequest
     *
     * @param  mixed $amount
     * @param  mixed $name
     * @param  mixed $phoneNumber
     * @param  mixed $email
     * @param  mixed $trackId
     * @param  mixed $currencycode
     * @return mixed
     */
    public function getPaymentRequest($amount, $name = 'User', $phoneNumber = '', $email, $trackId = '',  $currencycode = '512',)
    {
        try {

            $data = json_encode([[
                "amt" => $amount,
                "action" => $this->client->getAction(),
                "password" =>  $this->client->getPassword(),
                "id" => $this->client->getMerchantId(),
                "currencycode" => $currencycode,
                "trackId" => $trackId ?? strval(rand(100000, 999999)),
                "responseURL" => $this->responseURL,
                "errorURL" => $this->errorURL,
                "udf1" => $this->udf1text,
                "udf2" => $this->udf2text,
                "udf3" => $this->udf3text,
                "udf4" => $this->udf4text,
                "udf5" => $this->udf5text,
                "Token_Flag" => "1",
                "billingInfo" => [
                    "firstName" => $name,
                    "lastName" => "",
                    "country" => "Oman",
                    "phoneNumber" => $phoneNumber,
                    "address" => "NBO, Sultan Qaboos St",
                    "postalCode" => "113",
                    "locality" => "Muscat",
                    "administrativeArea" => "Muscat",
                    "email" => $email,
                ],

            ]]);

            $encrypted = $this->client->encryptAES($data, $this->client->getResourceKey());
            $client = new Http();

            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            $body = '[{
                "id": "' . $this->client->getMerchantId() . '",
                "trandata": "' . $encrypted . '",
                "responseURL": "' . $this->responseURL . '",
                "errorURL": "' . $this->responseURL . '"
            }]';

            $request = new \GuzzleHttp\Psr7\Request('POST', $this->client->getURL(), $headers, $body);
            $res = $client->sendAsync($request)->wait();
            $res = json_decode($res->getBody());
            if (isset($res[0]->result)) {
                $this->redirect_result = $res[0]->result;
            }
            return $this;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * redirectUrl
     *
     * @return string
     */

    public function redirectUrl(): string
    {
        try {
            if ($this->redirect_result) {
                $explod = explode(':', $this->redirect_result);
                return 'https:' . $explod[2] . '?PaymentID=' . $explod[0];
            }
            return '';
        } catch (\Exception $e) {
            return '';
        }
    }
}
