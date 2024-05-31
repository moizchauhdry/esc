<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use PDF;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $from = isset($request->date[0]) ? Carbon::parse($request->date[0])->addDay()->format('Y-m-d') : Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = isset($request->date[1]) ? Carbon::parse($request->date[1])->addDay()->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d');

        $company_name = NULL;
        if (!empty($request->company)) {
            $company = User::role('company')->where('id', $request->company)->first();
            $company_name = $company->name;
        }

        $filter = [
            'company' => $request->company,
            'company_name' => $company_name,
            'date' => $request->date,
            'from' => $from,
            'to' => $to,
        ];

        $query = Ledger::query();

        $query->when($filter['company'], function ($q) use ($filter) {
            $q->where('company_id', $filter['company']);
        });

        $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
            $q->whereDate('created_at', '>=', $filter['from']);
            $q->whereDate('created_at', '<=', $filter['to']);
        });

        $ledgers = $query->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($ledger) => [
                'id' => $ledger->id,
                'invoice_at' => $ledger->invoice_at,
                'debit' => $ledger->debit_amount,
                'credit' => $ledger->credit_amount,
                'balance' => $ledger->balance_amount,
                'invoice' => $ledger->invoice,
            ]);

        $companies = User::role('company')->get();

        $debit_total = $query->sum('debit_amount');
        $credit_total = $query->sum('credit_amount');
        $balance_total = $query->sum('debit_amount');

        $balance = [
            'debit_total' => $debit_total,
            'credit_total' => $credit_total,
            'balance_total' => $balance_total - $credit_total,
        ];

        return Inertia::render('Ledger/Index', [
            'ledgers' => $ledgers,
            'companies' => $companies,
            'filter' => $filter,
            'balance' => $balance,
        ]);
    }


    public function print(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $company = $request->company;

        $query = Invoice::query();

        $query->when($company, function ($q) use ($company) {
            $q->where('company_id', $company);
        });

        $query->when($from && $to, function ($q) use ($from, $to) {
            $q->whereDate('created_at', '>=', $from);
            $q->whereDate('created_at', '<=', $to);
        });

        $invoices = $query->orderBy('id', 'desc')->get();

        view()->share([
            'invoices' => $invoices,
            'filters' => $request->all(),
        ]);

        $pdf = PDF::loadView('prints.ledger');
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }

    public function payment(Request $request)
    {
        // dd($request->all());

        $rules = [
            'company_id' => 'required',
            'balance_total' => 'required',
            'credit' => 'required',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        $ledger = Ledger::create([
            'company_id' => $request->company_id,
            'debit_amount' => 0,
            'credit_amount' => $request->credit,
            'balance_amount' => $request->balance_total - $request->credit
        ]);
    }
}
