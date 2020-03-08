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
        if (!isset($data['profile']['paymentProfiles']['customerPaymentProfileId'])) {
            return null;
        }
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
    public static function getCardData($token)
    {
        $gateway = self::setupGateway();
        $data = $gateway->getCustomerProfile([
            'customerProfileId' => $token
        ])->send()
        ->getData();
        if (!isset($data['profile']['paymentProfiles']['payment']['creditCard'])) {
            return null;
        }
        return $data['profile']['paymentProfiles']['payment']['creditCard'];
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
        
        return $request;
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

    public static function deleteAndUpdateCard($token, $profile, $params) {
        $data['customerProfileId'] = $token;
        $data['customerPaymentProfileId'] = $profile;
        $gateway = self::setupGateway();
        $params['customerProfileId'] = $token;
        $params['customerPaymentProfileId'] = $profile;
        $request = $gateway->updateCard($params)->send();
        $code = $request->getData()['messages']['resultCode'];
        if ($code == "Error") {
            return $code;
        }
        return $request;
    }

    public static function setParams($request, $invoice, $name) {
        $params = [
            'card' => [
                'billingFirstName' => $name[0],
                'billingLastName' => $name[1],
                'billingAddress1' => $invoice->Client->address,
                'billingCity' => $invoice->Client->city,
                'billingState' => $invoice->Client->state,
                'billingPostcode' => $invoice->Client->zipcode,
                'billingPhone' => '',
            ],
            'opaqueDataDescriptor' => $request->dataDescriptor,
            'opaqueDataValue' => $request->dataValue,
            'name' => $request->name,
            'email' => $invoice->Client->email,
            'customerType' => 'individual',
            'customerId' => $invoice->Client->crm_id,
            'description' => 'MEMBER ID ' . $invoice->client_id,
            'forceCardUpdate' => true
        ];
        return $params;
    }
}
