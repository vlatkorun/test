<?php

namespace App\Services\Payment\Currency;

use App\Services\Payment\Currency\Gateway\GatewayInterface;
use App\Services\Payment\Currency\Exception\InvalidCurrencyException;
use Cache;

class CurrencyService
{
    protected $gateway;
    protected $fromCurrency;
    protected $toCurrency;
    protected $fromAmount;
    protected $rate;
    protected $supportedCurrencies = [
        'EUR',
        'USD'
    ];

    public function __construct(GatewayInterface $gateway)
    {
        $this->gateway = $gateway;
    }

    public function from($currency, $amount = 1)
    {
        if(!in_array($currency, $this->supportedCurrencies))
        {
            throw new InvalidCurrencyException('Currency is not supported: ' . $currency);
        }

        $this->fromCurrency = $currency;
        $this->fromAmount = $amount;
        return $this;
    }

    public function to($currency)
    {
        if(!in_array($currency, $this->supportedCurrencies))
        {
            throw new InvalidCurrencyException('Currency is not supported: ' . $currency);
        }

        $this->toCurrency = $currency;
        return $this;
    }

    public function convert($useCache = false)
    {
        if($this->fromCurrency == $this->toCurrency)
        {
            return $this->fromAmount;
        }

        $cacheKey = $this->fromCurrency . '_' . $this->toCurrency;

        if($useCache)
        {
            $this->rate = Cache::get($cacheKey);

            if(!is_null($this->rate))
            {
                return $this->fromAmount * $this->rate;
            }
        }

        $this->rate = $this->gateway->from($this->fromCurrency)->to($this->toCurrency)->convert();

        if($useCache)
        {
            Cache::put($cacheKey, $this->rate, 10); // cache for 10 minutes
        }

        return $this->fromAmount * $this->rate;
    }
}