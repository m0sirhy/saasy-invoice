<?php

namespace App\Helpers;

use GuzzleHttp\Client as Guzzle;
use App\Setting;
use App\Client;
use App\Invoice;
use App\Payment;
use Auth;
use App\UserActivityLog;
use Omnipay\Common\CreditCard;
use Omnipay\Omnipay;
use Log;

class AuthNet
{
    protected $gateway;

    public static function setupGateway()
    {
        $gateway = Omnipay::create('AuthorizeNet_CIM');
        $gateway->setApiLoginId("6Ux8Sw4m");
        $gateway->setTransactionKey('2r5Xx43dB3Kc4N6K');
        $gateway->setDeveloperMode(false);
        return $gateway;
    }

    public static function createCustomer($params)
    {
        $gateway = self::setupGateway();
        $response = $gateway->createCard($params)->send();
        $data = $response->getData();
        self::checkErrors($data);
        return $data['paymentProfile']['customerProfileId'];
    }

    public static function getPayment($token)
    {
        $gateway = self::setupGateway();
        $data = $gateway->getCustomerProfile([
            'customerProfileId' => $token
        ])->send()
        ->getData();
        return $data['profile']['paymentProfiles']['customerPaymentProfileId'];
    }

    public static function getPaymentProfiles($token)
    {
        $gateway = self::setupGateway();
        $data = $gateway->getCustomerProfile([
            'customerProfileId' => $token
        ])->send()
        ->getData();
        return $data['profile']['paymentProfiles'];
    }

    public static function checkErrors($data)
    {
        if (isset($data['messages']['resultCode']) == 'Error') {
            if ($data['messages']['message']['code'] == 'E00115') {
                abort(419);
            }
        }
    }

    public static function chargeProfile($token, $profile, $amount, $invoice)
    {
        $data['customerProfileId'] = $token;
        $data['customerPaymentProfileId'] = $profile;
        $gateway = self::setupGateway();
        $params = [
            'cardReference' => json_encode($data),
            'amount' => $amount,
            'description' => 'Purchase',
            'invoiceNumber' => $invoice
        ];
        $request = $gateway->purchase($params)->send()->getData();
        
        return $response;
    }

    public static function refund($transactionId, $amount, $token)
    {
        $data['customerProfileId'] = $token;
        $data['customerPaymentProfileId'] = self::getPayment($token);
        $gateway = self::setupGateway();
        $transaction = [
            'cardReference' => json_encode($data),
            'transId' => $transactionId,
        ];
        $params = [
            'amount' => $amount,
            'transactionReference' => json_encode($transaction)
        ];
        $response = $gateway->void($params)->send();
        if ($response->isSuccessful()) {
            return $response;
        }
        $response = $gateway->refund($params)->send();
        return $response;
    }
}
