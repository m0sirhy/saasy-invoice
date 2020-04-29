<?php

namespace App\WireTables;

use Illuminate\Database\Query\Builder;

class WireTable
{

    public $table;

    public $where;

    public function render()
    {
        
        return view('wiretable.table')
            ->with('wiretable', $this);
    }

    public function where($column, $value)
    {
        $this->where[] = [$column => $value];
        return $this;
    }
}
