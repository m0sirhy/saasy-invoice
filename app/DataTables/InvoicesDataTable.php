<?php

namespace App\DataTables;

use App\Invoice;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoicesDataTable extends DataTable
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
                $url = route('invoices.edit', ['invoice' => $data->id]);
                return "<a href='$url' class='link'>#" . $data->id . "</a>";
            })
            ->editColumn('client', function ($data) {
                $url = route('clients.show', ['client' => $data->client_id]);
                return "<a href='$url' class='link'>" . $data->client->name . "</a>";
            })
            ->editColumn('status', function ($data) {
                return "<span>" . $data->invoiceStatus->status . "</span>";
            })->editColumn('amount', function ($data) {
                return number_format($data->amount, 2);
            })->editColumn('balance', function ($data) {
                return number_format($data->balance, 2);
            })->editColumn('due_date', function ($data) {
                return $this->formatDate($data->due_date);
            })->editColumn('invoice_date', function ($data) {
                return $this->formatDate($data->invoice_date);
            })->editColumn('start_date', function ($data) {
                return $this->formatDate($data->start_date);
            })->editColumn('end_date', function ($data) {
                return $this->formatDate($data->end_date);
            })->rawColumns(['id', 'status', 'client']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Invoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Invoice $model)
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
                    ->setTableId('invoices-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bftiplrf')
                    ->orderBy(0, 'desc')
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
            Column::make('status'),
            Column::make('balance'),
            Column::make('amount'),
            Column::make('due_date'),
            Column::make('invoice_date'),
            Column::make('start_date'),
            Column::make('end_date')
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

    public function formatDate($date)
    {
        $date = date_create($date);
        return date_format($date, "m/d/y");
    }
}
