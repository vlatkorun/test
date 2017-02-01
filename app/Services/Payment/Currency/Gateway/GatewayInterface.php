<?php

namespace App\Services\Payment\Currency\Gateway;

interface GatewayInterface
{
    public function convert();
    public function from($currency);
    public function to($currency);
}