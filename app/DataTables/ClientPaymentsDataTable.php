<?php

namespace App\DataTables;

use App\Payment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientPaymentsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('id', function ($data) {
                $url = route('payments.edit', ['payment' => $data->id]);
                return "<a href='$url' class='link'>" . $data->id . "</a>";
            })
            ->editColumn('refunded', function ($data) {
                if ($data->refunded == 1) {
                    return "Yes";
                }
                return "No";
            })
            ->editColumn('client', function ($data) {
                $url = route('clients.payments', ['client' => $data->client_id]);
                return "<a href='$url' class='link'>" . $data->client->name . "</a>";
            })
            ->editColumn('invoice', function ($data) {
                $url = route('invoices.edit', ['invoice' => $data->invoice_id]);
                return "<a href='$url' class='link'>#" . $data->invoice_id . "</a>";
            })
            ->editColumn('amount', function ($data) {
                return '$' . number_format($data->amount, 2);
            })

            ->rawColumns(['id', 'client', 'invoice']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Payment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
    {
        return $model->newQuery()->where('client_id', $this->client->id);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('payments-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bftiplrf')
                    ->orderBy(0, 'desc')
                    ->buttons(
                        Button::make('csv'),
                        Button::make('excel'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('client'),
            Column::make('invoice'),
            Column::make('amount'),
            Column::make('created_at'),
            Column::make('payment_at'),
            Column::make('refunded'),
            Column::make('payment_type')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->client->name . '_Payments_' . date('YmdHis');
    }
}
