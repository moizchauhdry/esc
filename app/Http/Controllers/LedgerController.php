<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use PDF;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        $from = $request->from_date;
        $to = $request->to_date;

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

        $query->when($role_id == 2, function ($q) use ($user) {
            $q->where('company_id', $user->id);
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


        $debit_total = $query->sum('debit_amount');
        $credit_total = $query->sum('credit_amount');
        $balance_total = $query->sum('debit_amount');

        $balance = [
            'debit_total' => $debit_total,
            'credit_total' => $credit_total,
            'balance_total' => $balance_total - $credit_total,
        ];

        $companies = User::when($role_id == 2, function ($q) use ($user) {
            $q->where('id', $user->id);
        })->role('company')->get();

        return Inertia::render('Ledger/Index', [
            'ledgers' => $ledgers,
            'companies' => $companies,
            'filter' => $filter,
            'balance' => $balance,
        ]);
    }


    public function print(Request $request)
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        $from = $request->from;
        $to = $request->to;
        $company = $request->company;

        $filter = [
            'company' => $company,
            'from' => $from,
            'to' => $to,
        ];

        $query = Ledger::query();

        $query->when($filter['company'], function ($q) use ($filter) {
            $q->where('company_id', $filter['company']);
        });

        $query->when($role_id == 2, function ($q) use ($user) {
            $q->where('company_id', $user->id);
        });

        $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
            $q->whereDate('created_at', '>=', $filter['from']);
            $q->whereDate('created_at', '<=', $filter['to']);
        });

        $ledgers = $query->orderBy('id', 'asc')->get();

        $debit_total = $ledgers->sum('debit_amount');
        $credit_total = $ledgers->sum('credit_amount');
        $balance_total = $ledgers->sum('debit_amount');

        $balance = [
            'debit_total' => $debit_total,
            'credit_total' => $credit_total,
            'balance_total' => $balance_total - $credit_total,
        ];

        view()->share([
            'ledgers' => $ledgers,
            'balance' => $balance,
            'filters' => $request->all(),
        ]);

        $pdf = PDF::loadView('prints.ledger');
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('invoice.pdf');
    }

    public function payment(Request $request)
    {
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
