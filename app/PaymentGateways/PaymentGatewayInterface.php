<?php

namespace App\PaymentGateways;

use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function create($order , $user) : string;
    public function verify($id) : Payment;
    public function formOptions() : array;
}

