<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $from = isset($request->date[0]) ? Carbon::parse($request->date[0])->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $to = isset($request->date[0]) ? Carbon::parse($request->date[1])->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        $company_name = NULL;
        if (!empty($request->company)) {
            $company = User::where('id', $request->company)->first();
            $company_name = $company->name;
        }

        $filter = [
            'company' => $request->company,
            'company_name' => $company_name,
            'date' => $request->date,
            'from' => $from,
            'to' => $to ,
        ];



        $query = Invoice::query();
        $query->when($filter['company'], function ($q) use ($filter) {
            $q->where('company_id', $filter['company']);
        });
        $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
            $q->whereDate('created_at', '>=', $filter['from']);
            $q->whereDate('created_at', '<=', $filter['to']);
        });

        $invoices = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id,
                'data' => $invoice,
            ]);

        $companies = User::get();

        return Inertia::render('Ledger/Index', [
            'invoices' => $invoices,
            'companies' => $companies,
            'filter' => $filter,
        ]);
    }


    public function print()
    {
        // $request->validate([
        // 'company_id' => 'required',
        // 'date' => 'required',
        // ]);

        // $from = Carbon::parse($request->date[0])->format('Y-m-d');
        // $to = Carbon::parse($request->date[1])->format('Y-m-d');

        $invoices = Invoice::query()
            // ->whereDate('created_at','>=',$from)
            // ->whereDate('created_at','<=',$to)
            ->get();

        view()->share([
            'invoices' => $invoices,
        ]);

        $pdf = PDF::loadView('prints.ledger');
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }
}
