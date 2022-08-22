<?php

namespace App\PaymentGateways;

use Illuminate\Support\Str;

class PaymentGatewayFactory
{
    /**
     * @param string $getPaymentGateway
     * @return App\PaymentGeteWays\PaymentGateWayinterface
     */


    public static function create($name): PaymentGateWayinterface
    {
        $class = "\App\PaymentGateways\\" . Str::studly($name);

        try {

            return new $class();

        } catch (\Exception $e) {

            throw new \Exception("Payment GateWay {$name} Not Found");
        }
    }
}
