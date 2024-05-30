<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $shipments = Invoice::count();
        $revenue = Invoice::sum('total');
        $companies = User::role('company')->count();
        $users = User::count();

        $data = [
            'shipments' => $shipments,
            'revenue' => $revenue,
            'companies' => $companies,
            'users' => $users,
        ];

        // dd($data);

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }
}
