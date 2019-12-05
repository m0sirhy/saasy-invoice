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
            ->editColumn('client_id', function ($data) {
                $url = route('clients.view', ['client' => $data->client_id]);
                return "<a href='$url' class = 'link'>" . $data->client_id . "</a>";
            })
            ->editColumn('billing_type_id', function ($data) {
                $url = route('billings.show', ['billing' => $data->billing_type_id]);
                return "<a href='$url' class='link'>" . $data->billing_type_id . "</a>";
            })
            // ->editColumn('last_invoice_id', function ($data) {
            //     $url = route('invoices.view', 'invoice' => $data->last_invoice_id);
            //     return "<a href='$url' class='link'>" . $data->last_invoice_id . "</a>";
            // })
            ->rawColumns([
                'id',
                'client_id',
                'billing_type_id',
                'last_invoice_id',
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
                    ->dom('ftiplrf')
                    ->orderBy(0, 'asc');
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
            Column::make('client_id'),
            Column::make('billing_type_id'),
            Column::make('last_invoice_date'),
            Column::make('last_invoice_id'),
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