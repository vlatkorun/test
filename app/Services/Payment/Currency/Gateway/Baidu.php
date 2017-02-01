<?php

namespace App\Services\Payment\Currency\Gateway;

use GuzzleHttp\Client;
use App\Services\Payment\Currency\Gateway\Exception\GatewayResponseErrorException;

class Baidu implements GatewayInterface
{
    protected $fromCurrency;
    protected $toCurrency;
    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function convert()
    {
        $url = sprintf('http://apis.baidu.com/apistore/currencyservice/currency?fromCurrency=%s&toCurrency=%s', $this->fromCurrency, $this->toCurrency);
        $response = $this->httpClient->request('GET', $url, ['headers' => ['apikey' => config('services.baidu.exchange_rate_apikey')]]);

        if($response->getStatusCode() !== 200)
        {
            throw new GatewayResponseErrorException('Error response from: http://apis.baidu.com. HTTP Status: ' . $response->getStatusCode());
        }

        $body = json_decode($response->getBody());

        if(!$body instanceof \stdClass || empty($body->retData->currency))
        {
            throw new GatewayResponseErrorException('Missing currency param in response body from: http://apis.baidu.com');
        }

        return $body->retData->currency;
    }

    public function from($currency)
    {
        $this->fromCurrency = $currency;
        return $this;
    }

    public function to($currency)
    {
        $this->toCurrency = $currency;
        return $this;
    }
}
