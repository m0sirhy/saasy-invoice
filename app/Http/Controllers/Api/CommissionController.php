<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Commission;

class CommissionController extends Controller
{
    public function create(Request $request)
    {
        $commission = Commission::create($request->all());
        return response()->json($commission);
    }

    public function getAll(Request $request)
    {
        $commissions = Commission::limit(5)->get();
        return response()->json($commissions);
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();
        return response()->json('Commission deleted');
    }

    public function show(Commission $commission)
    {
        return response()->json($commission);
    }
}
