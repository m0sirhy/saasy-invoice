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
                return "<a href='/subscriptions/show/$data->id' class='link'>" . $data->id . "</a>";
            })
            ->editColumn('client_id', function ($data) {
            	return "<a href='/$data->client_id' class = 'link'>" . $data->client_id . "</a>";
            })
            ->editColumn('billing_type_id', function ($data) {
            	return "<a href='/$data->billing_type_id' class='link'>" . $data->billing_type_id . "</a>";
            })
            ->editColumn('last_invoice_id', function ($data) {
                return "<a href='/invoices/view/$data->last_invoice_id' class='link'>" . $data->last_invoice_id . "</a>";
            })
            // ->editColumn('status', function ($data) {
            //     return 'Viewed';
            ->rawColumns([
                'id',
                'client_id',
                'billing_type_id',
                'last_invoice',
                'last_invoice_id',
                'next_invoice',
                'total_invoices',
                'total_billed',
                'total_payed'
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