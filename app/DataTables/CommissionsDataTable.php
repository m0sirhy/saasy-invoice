<?php

namespace App\DataTables;

use App\Commission;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CommissionsDataTable extends DataTable
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
                $url = route('commissions.edit', ['commission' => $data->id]);
                return "<a href='$url' class='link'>" . $data->id . "</a>";
            })
            ->editColumn('invoice', function ($data) {
                $url = route('invoices.edit', ['invoice' => $data->invoice_id]);
                return "<a href='$url' class='link'>" . $data->invoice_id . "</a>";
            })
            ->editColumn('user', function ($data) {
                $url = route('user.show', ['user' => $data->user_id]);
                return "<a href='$url' class='link'>" . $data->user->name . "</a>";
            })
            ->editColumn('amount', function ($data) {
                return '$' . money_format('%i', $data->amount);
            })
            ->editColumn('paid', function ($data) {
                if ($data->paid == 1) {
                    return "Yes";
                }
                return "No";
            })
            ->rawColumns(['id', 'invoice', 'user']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Commission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Commission $model)
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
                    ->setTableId('commissions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bftiplrf')
                    ->orderBy(0, 'desc')
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
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
            Column::make('invoice'),
            Column::make('user'),
            Column::make('amount'),
            Column::make('paid'),
            Column::make('paid_date'),
            Column::make('notes')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Commissions_' . date('YmdHis');
    }
}
