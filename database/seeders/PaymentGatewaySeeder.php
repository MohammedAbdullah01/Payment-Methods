<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Paypal',
            'slug' => 'paypal',
            'description' => 'Paypal Is a Payment Gateway Service The Allows You to Send',
            'status' => 'active',
            'options' => [
                'client_id' => '',
                'client_secret' => ''
            ]
        ]);
    }
}
