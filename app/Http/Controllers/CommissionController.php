<?php

namespace App\Http\Controllers;

use App\Commission;
use Illuminate\Http\Request;
use App\DataTables\CommissionsDataTable;
use App\DataTables\CommissionsOwedDataTable;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommissionsDataTable $dataTable)
    {
        return $dataTable->render('commissions.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function owed(CommissionsOwedDataTable $dataTable)
    {
        return $dataTable->render('commissions.owed');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('commissions.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        return view('commissions.edit')
            ->with('commission', $commission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('commissions');
    }
}
