<?php

namespace App\Http\Controllers;

use App\Models\Mesa;

class DashboardController extends Controller
{
    public function mesas()
    {
        $mesas = Mesa::orderBy('numero')
            ->get();

        return view(
            'admin.mesas-dashboard',
            compact('mesas')
        );
    }
}
