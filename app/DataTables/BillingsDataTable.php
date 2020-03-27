<?php

namespace App\DataTables;

use App\Billing;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BillingsDataTable extends DataTable
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
                $url = route('billings.edit', ['billing' => $data->id]);
                return "<a href='$url' class='link'>" . $data->id . "</a>";
            })->editColumn('monthly_min', function ($data) {
                return number_format($data->monthly_min, 2);
            })->editColumn('monthly_fee', function ($data) {
                return number_format($data->monthly_fee, 2);
            })->rawColumns(['id']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Billing $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Billing $model)
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
            ->setTableId('billings-table')
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
            Column::make('name'),
            Column::make('monthly_fee'),
            Column::make('monthly_min')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Billings_' . date('YmdHis');
    }
}
