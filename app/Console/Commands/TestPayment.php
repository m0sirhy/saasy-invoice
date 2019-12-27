<?php

namespace App\Console\Commands;

use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use Illuminate\Console\Command;

class TestPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $gateway = Omnipay::create('AuthorizeNet_CIM');
        $gateway->setApiLoginId("4pQKd386");
        $gateway->setTransactionKey('7WS3x54w53PR2Vfu');
        $gateway->setDeveloperMode(true);

        $formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
        $ccard = new CreditCard($formData);

        $response = $gateway->purchase(
            array('amount' => '10.00', 'currency' => 'USD', 'card' => $ccard)
        )->send();

        dd($response);
        dd($gateway);
    }
}
