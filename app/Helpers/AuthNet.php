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

    /**
     * Make Gateway
     *
     * @param string $type
     * @return Ominpay\Omnipay
     */
    public static function makeGateway($type)
    {
        $gateway = Omnipay::create($type);
        $gateway->setApiLoginId(env('AUTH_API'));
        $gateway->setTransactionKey(env('AUTH_TOKEN'));
        $gateway->setDeveloperMode(false);
        return $gateway;
    }

    /**
     * Setup CIM Gateway
     *
     * @return Omnipay\Omnipay
     */
    public static function setupGateway()
    {
        return self::makeGateway('AuthorizeNet_CIM');
    }

    /**
     * Setup AIM Gateway
     *
     * @return Omnipay\Omnipay
     */
    public static function setupGatewayAIM()
    {
        return self::makeGateway('AuthorizeNet_AIM');
    }

    /**
     * Create a customer
     *
     * @param array $params
     * @return int
     */
    public static function createCustomer($params)
    {
        $gateway = self::setupGateway();
        $response = $gateway->createCard($params)->send();
        $data = $response->getData();
        self::checkErrors($data);
        return $data['paymentProfile']['customerProfileId'];
    }

    /**
     * Get customer payment ID
     *
     * @param int $token
     * @return int
     */
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

    /**
     * Get a customers payment profiles
     *
     * @param int $token
     * @return array
     */
    public static function getPaymentProfiles($token)
    {
        $gateway = self::setupGateway();
        $data = $gateway->getCustomerProfile([
            'customerProfileId' => $token
        ])->send()
        ->getData();
        return $data['profile']['paymentProfiles'];
    }

    /**
     * Get a customers credit card information
     *
     * @param int $token
     * @return array
     */
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

    /**
     * Check for errors
     *
     * @param array $data
     * @return void
     */
    public static function checkErrors($data)
    {
        if (isset($data['messages']['resultCode']) == 'Error') {
            if ($data['messages']['message']['code'] == 'E00115') {
                abort(419);
            }
        }
    }

    /**
     * Charge a customers profile
     *
     * @param int $token
     * @param int $profile
     * @param float $amount
     * @param int $invoice
     * @return Omnipay
     */
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

    /**
     * Refund a transaction
     *
     * @param int $transactionId
     * @param float $amount
     * @param int $token
     * @return Omnipay
     */
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

    /**
     * Deleted and update a clients card
     *
     * @param int $token
     * @param int $profile
     * @param array $params
     * @return Omnipay
     */
    public static function deleteAndUpdateCard($token, $profile, $params)
    {
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

    /**
     * Set the billing params
     *
     * @param \Request $request
     * @param \App\Invoice $invoice
     * @param array $name
     * @return void
     */
    public static function setParams($request, $invoice, $name)
    {
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

    /**
     * Charge a card without a profile
     *
     * @param array $params
     * @return Omnipay
     */
    public static function chargeCard($params)
    {
        $gateway = self::setupGatewayAIM();
        $response = $gateway->purchase($params)->send();
        return $response;
    }

    /**
     * Set Params for a Single Charge
     *
     * @param \Request $request
     * @param array $name
     * @return void
     */
    public static function setParamsSingle($request, $name)
    {
        $params = [
            'card' => [
                'billingFirstName' => $name[0],
                'billingLastName' => $name[1],
                'billingAddress1' => $request->address,
                'billingCity' => $request->city,
                'billingState' => $request->state,
                'billingPostcode' => $request->zip,
                'billingPhone' => '',
            ],
            'transactionRequest' => [
                'transactionType' => "authCaptureTransaction",
                'payment' => [
                    'dataDescriptor' => $request->dataDescriptor,
                    'dataValue' => $request->dataValue,
                ],
            ],
            'amount' => $request->amount,
            'opaqueDataDescriptor' => $request->dataDescriptor,
            'opaqueDataValue' => $request->dataValue,
            'name' => $request->name,
            'email' => $request->email,
            'customerType' => 'individual',
            'customerId' => 01,
            'description' => 'MEMBER ID SINGLE',
            'forceCardUpdate' => true
        ];
        return $params;
    }
}
