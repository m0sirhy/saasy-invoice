<?php

namespace App\DataTables;

use App\Credit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientCreditsDataTable extends DataTable
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
                $url = route('credits.edit', ['credit' => $data->id]);
                return "<a href='$url' class='link'>" . $data->id . "</a>";
            })
            ->editColumn('client', function ($data) {
                $url = route('clients.credits', ['client' => $data->client_id]);
                return "<a href='$url' class='link'>" . $data->client->name . "</a>";
            })
            ->editColumn('created_by', function ($data) {
                return $data->user->name;
            })
            ->editColumn('amount', function ($data) {
                return '$' . number_format($data->amount, 2);
            })
            ->editColumn('balance', function ($data) {
                return '$' . number_format($data->balance, 2);
            })
            ->editColumn('completed', function ($data) {
                if ($data->completed == 1) {
                    return "Yes";
                }
                return "No";
            })
            ->rawColumns(['id', 'client', 'invoice']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Credit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Credit $model)
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
            Column::make('created_by'),
            Column::make('amount'),
            Column::make('balance'),
            Column::make('completed')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->client->name . '_Credits_' . date('YmdHis');
    }
}
