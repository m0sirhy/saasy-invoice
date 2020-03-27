<?php

namespace App\DataTables;

use App\Invoice;
use App\Subscription;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SubscriptionsDataTable extends DataTable
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
                $url = route('subscriptions.show', ['subscription' => $data->id]);
                return "<a href='$url' class='link'>" . $data->id . "</a>";
            })
            ->editColumn('client', function ($data) {
                $url = route('clients.show', ['client' => $data->client_id]);
                return "<a href='$url' class = 'link'>" . $data->client->name . "</a>";
            })
            ->editColumn('billing_type', function ($data) {
                $url = route('billings.show', ['billing' => $data->billing_type_id]);
                return "<a href='$url' class='link'>" . $data->billing_type_id . "</a>";
            })
            ->editColumn('last_invoice', function ($data) {
                $url = route('invoices.edit', ['invoice' => $data->last_invoice_id]);
                return "<a href='$url' class='link'>#" . $data->last_invoice_id . "</a>";
            })
            ->editColumn('total_billed', function ($data) {
                return '$' . number_format($data->total_billed, 2);
            })
            ->editColumn('total_payed', function ($data) {
                return '$' . number_format($data->total_payed, 2);
            })
            ->rawColumns([
                'id',
                'client',
                'billing_type',
                'last_invoice_id',
                'last_invoice',
            ]);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('subscriptions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bftiplrf')
                    ->orderBy(0, 'asc')
                    ->buttons(
                        Button::make('create'),
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
            Column::make('billing_type'),
            Column::make('last_invoice_date'),
            Column::make('last_invoice'),
            Column::make('next_invoice_date'),
            Column::make('total_invoices'),
            Column::make('total_billed'),
            Column::make('total_payed')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Invoices_' . date('YmdHis');
    }
}
