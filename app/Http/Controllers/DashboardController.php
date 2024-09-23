<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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


        $monthly_revenue = DB::table('invoices')
            ->select(DB::raw('SUM(total) as total'), DB::raw('MONTH(invoice_at) as month'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $revenue_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue_data[] = $monthly_revenue[$i] ?? 0;
        }

        // Query for the number of pre-shipments per month
        $pre_shipments = DB::table('invoices')
            ->select(DB::raw('COUNT(*) as total'), DB::raw('MONTH(created_at) as month'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Query for the number of invoices per month
        $invoices = DB::table('invoices')
            ->select(DB::raw('COUNT(*) as total'), DB::raw('MONTH(invoice_at) as month'))
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Ensure that you have data for all months (initialize missing months with 0)
        $pre_shipments_data = [];
        $invoices_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $pre_shipments_data[] = $pre_shipments[$i] ?? 0;
            $invoices_data[] = $invoices[$i] ?? 0;
        }

        // Get the last 7 days
        $shipments_last_week = DB::table('invoices')
            ->select(
                DB::raw('DAYOFWEEK(created_at) as day_of_week'), // Get the day of the week (1 = Sunday, 7 = Saturday)
                DB::raw('COUNT(*) as total_shipments')
            )
            ->whereBetween('created_at', [Carbon::now()->subDays(6)->startOfDay(), Carbon::now()->endOfDay()])
            ->groupBy('day_of_week')
            ->orderBy('day_of_week', 'asc')
            ->get();

        // Prepare data for Chart.js
        $labels = $shipments_last_week->pluck('day_of_week')->map(function ($day) {
            return $day; // Keep it as a numeric value (Monday = 2, Tuesday = 3, etc.)
        });

        $last_week_shipments = $shipments_last_week->pluck('total_shipments');


        $companies_invoices = DB::table('invoices')
            ->join('users', 'invoices.company_id', '=', 'users.id')
            ->select('users.name', DB::raw('SUM(invoices.total) as total_revenue'))
            ->groupBy('users.name')
            ->orderBy('total_revenue', 'desc')
            ->take(5)
            ->get();

        // Prepare data for Chart.js
        $companies_labels = $companies_invoices->pluck('name');
        $companies_invoices_data = $companies_invoices->pluck('total_revenue');


        $compnay_shipments = DB::table('invoices')
            ->join('users', 'invoices.company_id', '=', 'users.id')
            ->select('users.name', DB::raw('COUNT(invoices.id) as total_shipments'))
            ->groupBy('users.name')
            ->orderBy('total_shipments', 'desc')
            ->take(5)
            ->get();

        // Prepare data for Chart.js
        $compnay_shipments_labels = $compnay_shipments->pluck('name');
        $compnay_shipments_data = $compnay_shipments->pluck('total_shipments');

        $data = [
            'shipments' => $shipments,
            'revenue' => $revenue,
            'companies' => $companies,
            'users' => $users,
            'revenue_data' => $revenue_data,
            'pre_shipments_data' => $pre_shipments_data,
            'invoices_data' => $invoices_data,
            'last_week_shipments' => $last_week_shipments,
            'companies_data' => [
                'companies_labels' => $companies_labels,
                'companies_invoices_data' => $companies_invoices_data,
                'compnay_shipments_data' => $compnay_shipments_data,
            ],
        ];

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }
}
