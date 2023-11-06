<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{


    public function __invoke()
    {
        // return Inertia::render('Dashboard', []);

        if(auth()->user()->type == User::SYSTEM_ADMIN){
            return redirect()->route('companies.index');
        }

        return redirect()->route('products.index');
    }
}
