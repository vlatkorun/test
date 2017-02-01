<?php

namespace App\Services\Payment\Processors;

use App\Services\Payment\Currency\CurrencyService;
use App\Models\Order;

class Adyen
{
    protected $currencyService;

    protected $hppParams = [
        'merchantReference',
        'paymentAmount',
        'currencyCode',
        'shipBeforeDate',
        'skinCode',
        'merchantAccount',
        'sessionValidity',
        'merchantReturnData',
        'shopperEmail',
        'shopperReference',
        'shopperLocale',
        'pspReference',
        'paymentMethod',
    ];

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function merchantSignature(array $params, $hmacKey)
    {
        $params = array_filter($params, function($param){
            return in_array($param, $this->hppParams);
        });

        ksort($params, SORT_STRING);

        $signData = implode(":", array_map(function ($value) {
            return str_replace(':', '\\:', str_replace('\\', '\\\\', $value));
        }, array_merge(array_keys($params), array_values($params))));

        return base64_encode(hash_hmac('sha256', $signData, pack("H*", $hmacKey), true));
    }

    public function checkMerchantSignature($signature, array $params, $hmacKey)
    {
        /*
         * @TODO  Make it more pretty - this method
         */
        $params = $this->fix($_SERVER['QUERY_STRING']);

        // Remove the merchantSig field for the signature calculation
        unset($params['merchantSig']);

        // Sort the array by key using SORT_STRING order
        ksort($params, SORT_STRING);

        // Generate the signing data string
        $signData = implode(":", array_map(
                function($value){
                    return str_replace(':','\\:',str_replace('\\','\\\\',$value));
                },
                array_merge(array_keys($params), array_values($params)))
        );

        // base64-encode the binary result of the HMAC computation
        $merchantSig = base64_encode(hash_hmac('sha256', $signData, pack("H*", $hmacKey), true));

        // Compare the calculated signature with the signature from the URL parameters
        return $signature === $merchantSig;
    }

    public function languages()
    {
        $languages = [];

        foreach(config('services.adyen.languages') as $languageCode => $params)
        {
            $languages[$languageCode] = $params['name'];
        }

        return $languages;
    }

    public function currencies()
    {
        $currencies = [];

        foreach(config('services.adyen.currency_codes') as $currencyCode => $params)
        {
            $currencies[$currencyCode] = $params['name'];
        }

        return $currencies;
    }

    // Function to preserve the original special character
    protected function fix($source) {
        $source = preg_replace_callback(
            '/(^|(?<=&))[^=[&]+/',
            function($key) {
                return bin2hex(urldecode($key[0]));
            },
            $source
        );
        parse_str($source, $post);
        return array_combine(array_map('hex2bin', array_keys($post)), $post);
    }

    public function hppParamsForOrder(Order $order, $layout = null, $currency = null, $language = null, $merchantReturnData = [])
    {
        $hmacKey = config('adyen.skins.default.hmac_key');
        $skinCode = config('adyen.skins.default.skin_code');

        if (!is_null($layout)) {
            foreach (config('adyen.skins') as $name => $params) {
                if ($name == $layout) {
                    $hmacKey = $params['hmac_key'];
                    $skinCode = $params['skin_code'];
                }
            }
        }

        if(is_null($currency))
        {
            $currency = config('adyen.default_currency');
        }

        if(is_null($language)) {
            $language = config('adyen.default_locale');
        }else {
            $language = config('adyen.languages')[$language]['adyen_code'];
        }

        $merchantReturnDataString = '';

        if(!empty($merchantReturnData))
        {
            foreach($merchantReturnData as $key => $value)
            {
                $merchantReturnDataString .= sprintf('%s:%s,', $key, $value);
            }
        }

        $data = [
            'skinCode' => $skinCode,
            'merchantReference' => $order->order_id,
            'currencyCode' => strtoupper($currency),
            'sessionValidity' => Carbon::now()->addDays(2)->format('c'),
            'shopperLocale' => $language,
            'shopperEmail' => $order->purchaser->email,
            'shopperReference' => $this->jwtAuth->fromUser($order->purchaser),
            'shipBeforeDate' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'merchantReturnData' => $merchantReturnDataString,
            'merchantAccount' => config('adyen.merchant_account')
        ];

        $paymentAmount = $order->package->price;

        if(strtoupper($currency) !== 'EUR')
        {
            $paymentAmount = round($this->currencyService->from('EUR', $order->package->price)
                ->to($currency)
                ->convert(), 2);
        }

        $exponent = config('adyen.currency_codes')[$data['currencyCode']]['exponent'];
        $data['paymentAmount'] = $paymentAmount * pow(10, $exponent);

        $data['merchantSig'] = $this->merchantSignature($data, $hmacKey);

        foreach ($data as $key => $value)
        {
            $data[htmlspecialchars($key, ENT_COMPAT | ENT_HTML401, 'UTF-8')] = htmlspecialchars($value, ENT_COMPAT | ENT_HTML401, 'UTF-8');
        }

        return $data;
    }
}