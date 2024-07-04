<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        $shipments = Invoice::when($role_id == 2, function ($query) use ($user) {
            $query->where('company_id', $user->id);
        })->count();

        $revenue = Invoice::when($role_id == 2, function ($query) use ($user) {
            $query->where('company_id', $user->id);
        })->sum('total');
        
        $companies = User::role('company')->count();
        $users = User::count();

        $data = [
            'shipments' => $shipments,
            'revenue' => $revenue,
            'companies' => $companies,
            'users' => $users,
        ];

        $data2= [
            'user_id' => 2,
            'message' => "hello world",
        ];

        event(new MessageEvent($data2));
    

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }
}
