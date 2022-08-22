<?php

namespace App\PaymentGateways;

use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Redirect;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class Paypal implements PaymentGatewayInterface
{
    protected $paymentMethod;
    protected $client;

    public function __construct()
    {
        $this->paymentMethod = PaymentMethod::where('slug', 'paypal')->first();
    }

    protected function client()
    {
        if (!$this->client) {

            $this->client  = new PayPalHttpClient(
                new SandboxEnvironment(
                    $this->paymentMethod->options['client_id'],
                    $this->paymentMethod->options['client_secret']
                )
            );
        }
        return $this->client;
    }

    /**
     * Create New Payment
     * @param \App\Models\Order $order
     * @param \App\Models\User  $user
     * @return string
     */

    public function create($order, $user): string
    {
        // Construct a request object and set desired parameters
        // Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => $order->currency_code
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('payment.cancel'),
                "return_url" => route('payment.return')
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $this->client()->execute($request);
            $payment = Payment::create([
                'payment_method_id' => $this->paymentMethod->id,
                'paymenttable_type' => get_class($order),
                'paymenttable_id'   => $order->id,
                'payer_type'        => get_class($user),
                'payer_id'          => $user->id,
                'amount'            => $order->total,
                'currency_code'     => $order->currency_code,
                'status'            => 'pending',
                'transaction_id'    => $response->result->id,
            ]);
            foreach ($response->result->links as $link) {
                if ($link->rel == 'approve') {
                    return Redirect::away($link->href);
                }
            }
        } catch (HttpException $ex) {
            // echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function verify($id): Payment
    {
        $request = new OrdersCaptureRequest($id);
        $request->prefer('return=representation');

        try {
            // Call API with your client and get a response for your call
            $response = $this->client()->execute($request);

            if ($response->result->status == 'COMPLETED') {
                $payment = Payment::where('transaction_id', $id)->where('payment_method_id',  $this->paymentMethod->id)->first();
                $payment->status = 'Completed';
                $payment->save();
            }
            return $payment;
        } catch (HttpException $ex) {
            print_r($ex->getMessage());
        }
    }

    public function formOptions(): array
    {
        return [
            'client_id' => [
                'type' => 'text',
                'lable' => 'Client ID',
                'placeholder' => 'Client Id',
                'required' => true,
                'validation' => 'required|string|max:255',
            ],
            'client_secret' => [
                'type' => 'text',
                'lable' => 'Client Secret',
                'placeholder' => 'Client Secret',
                'required' => true,
                'validation' => 'required|string|max:255',
            ]
        ];
    }
}
