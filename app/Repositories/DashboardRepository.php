<?php

namespace App\Repositories;

use stdClass;
use App\Client;
use App\Invoice;
use App\Payment;
use App\UserActivityLog;

class DashboardRepository
{
    public function getRevenue()
    {
        return Payment::where('refunded', 0)
            ->where('payment_at', '>=', now()->subYear())
            ->sum('amount');
    }

    public function getMonthlyPayments()
    {
        $now = now()->startOfMonth();
        $months = ['11', '10', '9', '8', '7', '6' ,'5', '4', '3', '2', '1', '0'];

        foreach ($months as $month) {
            $paymentMonths[$month] = $now->format('F');
            $paymentByMonth[$month] = round(\App\Payment::where('refunded', 0)
                ->whereMonth('payment_at', $now->format('m'))
                ->whereYear('payment_at', $now->format('Y'))
                ->where('payment_type', '!=', 2)
                ->sum('amount'), 2);
                $now->subMonth('1');
        }

        $paymentData = new stdClass();
        $paymentData->months = $paymentMonths;
        $paymentData->payments = $paymentByMonth;
        return $paymentData;
    }

    public function getClientData()
    {
        $clients = Client::count();
        $newClients = Client::where('created_at', '>=', now()->subDay())->count();
        $clientData = new stdClass();
        $clientData->clients = $clients;
        $clientData->newClients = $newClients;
        return $clientData;
    }

    public function getRecentPayments()
    {
        $now = now();
        $recent = Payment::where('refunded', 0)
            ->where('payment_at', '>=', $now->subMonth())
            ->where('payment_type', '!=', 2)
            ->orderBy('payment_at', 'desc')
            ->get();
        return $recent;
    }

    public function getOverdueInvoices()
    {
        $overdues = Invoice::where('invoice_status_id', OVER_DUE)
            ->orderBy('id', 'desc')
            ->get();
        $overdueTotal = Invoice::where('invoice_status_id', OVER_DUE)->sum('balance');
        $overdueData = new stdClass();
        $overdueData->overdues = $overdues;
        $overdueData->overdueTotal = $overdueTotal;
        return $overdueData;
    }

    public function getUserActivity()
    {
        return UserActivityLog::with('User')
            ->limit(50)
            ->orderBy('id', 'desc')
            ->get();
    }
}
