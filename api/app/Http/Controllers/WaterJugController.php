<?php

namespace App\Http\Controllers;

use App\Services\WaterJugSolver;
use Illuminate\Http\Request;

class WaterJugController extends Controller
{
    public function index(Request $request, WaterJugSolver $waterJugSolver)
    {
        $xCapacity = $request->input('x_capacity');
        $yCapacity = $request->input('y_capacity');
        $target = $request->input('z_amount_wanted');

        $request->validate([
            'x_capacity' => 'required|integer|min:1',
            'y_capacity' => 'required|integer|min:1',
            'z_amount_wanted' => 'required|integer|min:0',
        ]);

        $result = $waterJugSolver->solve($xCapacity, $yCapacity, $target);

        return response()->json($result);
    }
}
