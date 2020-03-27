<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Payment;

class ButtonHelper
{
    /**
     *
     * @param string $route
     * @param Array $options
     * @return void
     */
    public static function createExcel($route, $sortField, $sortAsc, $search)
    {
        switch ($route) {
            case 'clients':
                break;
            case 'invoices':
                // self::invoicesExcel();
                break;
            case 'subscriptions':
                break;
            case 'billing_types':
                break;
            case 'payments':
                self::paymentsExcel($sortField, $sortAsc, $search);
                break;
            case 'products':
                break;
            case 'commissions':
                break;
            case 'credits':
                break;
        }
    }

    public static function paymentsExcel($sortField, $sortAsc, $search)
    {
        $cols = ['id', 'invoice_id', 'auth_code', 'amount'];
        $payments = Payment::with('client')
            ->whereLike($cols, $search)
            ->orderBy($sortField, $sortAsc)
            ->get();
        $arrayData = [];
        $headers = [
            'id',
            'Client Name',
            'Invoice Number',
            'Amount',
            'Payment Date',
            'Type',
            'Refunded'
        ];
        $count = 0;
        foreach ($payments as $payment) {
            $arrayData[$count] = [
                $payment->id,
                $payment->client->name ?? 'Unknown',
                $payment->invoice_id ?? 0,
                money_format('$%i', $payment->amount),
                $payment->payment_at->format('m/d/Y'),
                $payment->payment_type ?? 'Unknown',
                $payment->refunded,
            ];
            $count++;
        }
        $spreadsheet = new SpreadSheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($arrayData, null, 'A2');
        $response = response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output', 'w');
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $filename = 'payments-' . now()->format('Y-m-d');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'.xlsx"');
        return $response->send();
    }
}
