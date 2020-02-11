<?php

namespace App\Helpers;

use GuzzleHttp\Client as Guzzle;
use App\Setting;
use App\Client;
use App\Invoice;
use App\Payment;
use Auth;
use App\UserActivityLog;
use GuzzleHttp\Psr7\Request;
use Log;

class WebHookHelper
{
	/**
	 *  
	 * @param string $route
	 * @param Array $options
	 * @return void
	 */
	public static function postRequest($route, $options)
	{
		$settings = Setting::find(1);
		$url = $settings->website;
		$url = filter_var($url, FILTER_SANITIZE_URL);
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			Log::error('You have an invalid website stored');
			return;
		}
		$client = new Guzzle([
			'base_uri' => $url, 
			'headers' => ['x-api-key' => $settings->api_token],
		]);
		$options = array([
			'json' => [
				$options[0],
			],
		]);
		$response = $client->request('POST', $route, $options[0]);
		return $response;
	}

	/**
	 *  
	 * @param Invoice $invoice
	 * @return void
	 */
	public static function postInvoiceOverdue(Invoice $invoice) {
		$invoice = Invoice::where('id', $invoice->id)
			->with('Client')
			->first();
		$options = array([
			"client_uuid" => $invoice->Client->uuid,
			"public_id" => $invoice->public_id,
			"invoice_status_id" => $invoice->invoice_status_id,
			"due_date" => $invoice->due_date,
			"invoice_date" => $invoice->invoice_date,
			"start_date" => $invoice->start_date,
			"end_date" => $invoice->end_date,
			"created_at" => $invoice->created_at,
			"updated_at" => $invoice->updated_at
		]);
		self::postRequest('/api/v1/invoice/overdue', $options);
	}

	public static function postInvoicePayment(Payment $payment) {
		$invoice = Invoice::where('id', $payment->invoice_id)
			->with('Client')
			->first();
		$options = array([
			"client_uuid" => $invoice->Client->uuid,
			"public_id" => $invoice->public_id,
			"payment_date" => $payment->payment_at,
			"amount" => $payment->amount,
			"payment_type" => $payment->payment_type
		]);
		self::postrequest('/api/v1/invoice/payment', $options);
	}
	/**
	 *  
	 * @param Invoice $invoice
	 * @return void
	 */
	public static function postInvoiceCreated(Invoice $invoice) {
		$invoice = Invoice::where('id', $invoice->id)
			->with('Client')
			->first();
		$options = array([
			"client_uuid" => $invoice->Client->uuid,
			"public_id" => $invoice->public_id,
			"invoice_status_id" => $invoice->invoice_status_id,
			"due_date" => $invoice->due_date,
			"invoice_date" => $invoice->invoice_date,
			"start_date" => $invoice->start_date,
			"end_date" => $invoice->end_date,
			"created_at" => $invoice->created_at,
			"updated_at" => $invoice->updated_at
		]);
		self::postrequest('/api/v1/invoice/created', $options);
	}

	/**
	 *  
	 * @param Invoice $invoice
	 * @return void
	 */
	public static function postInvoiceUpdated(Invoice $invoice) {
		$invoice = Invoice::where('id', $invoice->id)
			->with('Client')
			->first();
		$options = array([
			"client_uuid" => $invoice->Client->uuid,
			"public_id" => $invoice->public_id,
			"invoice_status_id" => $invoice->invoice_status_id,
			"due_date" => $invoice->due_date,
			"invoice_date" => $invoice->invoice_date,
			"start_date" => $invoice->start_date,
			"end_date" => $invoice->end_date,
			"created_at" => $invoice->created_at,
			"updated_at" => $invoice->updated_at
		]);
		self::postrequest('/api/v1/invoice/updated', $options);
	}

	/**
	 *  
	 * @param Invoice $invoice
	 * @return void
	 */
	public static function postInvoiceViewedUser(Invoice $invoice) {
		$authId = 9999999;
		if (Auth::check()) {
			$authId = Auth::id();
		}
		$invoice = Invoice::where('id', $invoice->id)
			->with('Client')
			->first();
		$options = array([
			"client_uuid" => $invoice->Client->uuid,
			"public_id" => $invoice->public_id,
			"invoice_status_id" => $invoice->invoice_status_id,
			"due_date" => $invoice->due_date,
			"invoice_date" => $invoice->invoice_date,
			"start_date" => $invoice->start_date,
			"end_date" => $invoice->end_date,
			"created_at" => $invoice->created_at,
			"updated_at" => $invoice->updated_at,
			"user_id" => $authId
		]);
		self::postrequest('/api/v1/invoice/userviewed', $options);
	}
}
