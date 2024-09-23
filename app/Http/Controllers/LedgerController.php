<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceUpload;
use App\Models\Ledger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PDF;

class LedgerController extends Controller
{
    private function fetchLedgerData($request)
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        $date = Carbon::parse($request->ledger_at);
        $year = $date->year;
        $month = $date->format('m');

        $filter = [
            'company' => $request->company_id,
            'year' => $year,
            'month' => $month,
        ];

        $query = Ledger::query();
        if ($request->company != null && $request->company != 0) {
            $query->when($request->company, function ($q) use ($request) {
                $q->where('company_id', $request->company);
            });
        } else {
            $query->when($filter['company'], function ($q) use ($filter) {
                $q->where('company_id', $filter['company']);
            });
        }

        $query->when($role_id == 2, function ($q) use ($user) {
            $q->where('company_id', $user->id);
        });

        $query->whereYear('ledger_at', $filter['year']);
        $query->whereMonth('ledger_at', $filter['month']);

        // $query->when($filter['ledger_at'], function ($q) use ($filter) {
        //     $q->where('ledger_at', '>=', $filter['ledger_at']);
        //     $q->where('ledger_at', '<=', $filter['ledger_at']);
        // });

        $ledgers = $query->orderBy('id', 'asc')->get();

        $debit_total = $ledgers->sum('debit_amount');
        $credit_total = $ledgers->sum('credit_amount');

        $data = [
            'debit_total' => $debit_total,
            'credit_total' => $credit_total,
            'balance_total' => $debit_total - $credit_total,
        ];

        return $data;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        // $from = $request->from_date ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        // $to = $request->to_date ?? Carbon::now()->endOfMonth()->format('Y-m-d');

        $current_month = $request->month ?? Carbon::now()->format('m');
        $current_year = $request->year ?? Carbon::now()->format('Y');

        $company_name = NULL;
        if (!empty($request->company)) {
            $company = User::role('company')->where('id', $request->company)->first();
            $company_name = $company->name;
        }

        $filter = [
            'company' => $request->company,
            'company_name' => $company_name,
            'month' => $current_month,
            'month_name' => getMonthName($current_month),
            'year' => $current_year,
        ];

        $query = Ledger::query();

        $ledger_company_id = 0;

        if ($request->company != null && $request->company != 0) {
            $query->when($request->company, function ($q) use ($request) {
                $q->where('company_id', $request->company);
            });
            $ledger_company_id = (int)$request->company;
        } else {
            $query->when($filter['company'], function ($q) use ($filter) {
                $q->where('company_id', $filter['company']);
            });
        }

        if (empty($request->company)) {
            $query->where('amount_type', '!=', 3);
        }

        $query->when($role_id == 2, function ($q) use ($user) {
            $q->where('company_id', $user->id);
        });

        // $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
        //     $q->whereDate('ledger_at', '>=', $filter['from']);
        //     $q->whereDate('ledger_at', '<=', $filter['to']);
        // });

        $query->whereYear('ledger_at', $filter['year']);
        $query->whereMonth('ledger_at', $filter['month']);

        $ledgers = $query->orderBy('ledger_at', 'asc')
            ->paginate(1000)
            ->withQueryString()
            ->through(fn($ledger) => [
                'id' => $ledger->id,
                'ledger_at' => Carbon::parse($ledger->ledger_at)->format('d-m-Y'),
                'debit' => $ledger->debit_amount,
                'credit' => $ledger->credit_amount,
                'balance' => $ledger->balance_amount,
                'invoice' => $ledger->invoice,
                'comments' => $ledger->comments,
                'company_id' => $ledger->company_id,
                'company_name' => $ledger->company->name,
                'amount_type' => $ledger->amount_type,
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
            'ledger_company_id' => $ledger_company_id,
        ]);
    }

    public function print(Request $request)
    {
        // dd($request->all());

        $user = Auth::user();
        $role_id = getRoleID($user);

        $filter = [
            'company' => $request->company,
            'company_name' => $request->company_name,
            'month' => $request->month,
            'month_name' => $request->month_name,
            'year' => $request->year,
        ];

        $query = Ledger::query();

        if ($request->company != null && $request->company != 0) {
            $query->when($request->company, function ($q) use ($request) {
                $q->where('company_id', $request->company);
            });
        } else {
            $query->when($filter['company'], function ($q) use ($filter) {
                $q->where('company_id', $filter['company']);
            });
        }

        $query->when($role_id == 2, function ($q) use ($user) {
            $q->where('company_id', $user->id);
        });

        $query->whereYear('ledger_at', $filter['year']);
        $query->whereMonth('ledger_at', $filter['month']);

        $ledgers = $query->orderBy('ledger_at', 'asc')->get();

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
            'ledger_at' => 'required',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        Ledger::create([
            'company_id' => $request->company_id,
            'debit_amount' => 0,
            'credit_amount' => $request->credit,
            'balance_amount' => $request->balance_total - $request->credit,
            'ledger_at' => date('Y-m-d H:i:s', strtotime($request->ledger_at)),
            'comments' => $request->comments,
            'amount_type' => 2,
        ]);

        return Redirect::back()->with('success', 'Payment added.');
    }

    public function company()
    {
        $companies = User::role('company')->get();

        return Inertia::render('Ledger/Company', [
            'companies' => $companies,
        ]);
    }

    public function deleteLedger(Request $request)
    {
        $ledger = Ledger::find($request->ledger_id);
        $ledger->delete();

        return Redirect::back()->with('success', 'Ledger deleted.');
    }

    public function updateLedger(Request $request)
    {
        $rules = [
            'company_id' => 'required',
            'credit' => 'required',
            'ledger_at' => 'required',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        $ledger = Ledger::find($request->id);
        $data = [
            'company_id' => $request->company_id,
            'debit_amount' => 0,
            'credit_amount' => $request->credit,
            'ledger_at' => date('Y-m-d H:i:s', strtotime($request->ledger_at)),
            'comments' => $request->comments,
        ];

        $ledger->update($data);

        $fetch_ledger_data = $this->fetchLedgerData($request);

        $ledger->update([
            'balance_amount' => $fetch_ledger_data['balance_total'],
        ]);

        return Redirect::back()->with('success', 'Ledger updated.');
    }

    public function fetchBalance(Request $request)
    {
        $fetch_ledger_data = $this->fetchLedgerData($request);
        return response()->json($fetch_ledger_data);
    }

    public function openingBalance(Request $request)
    {
        $rules = [
            'company_id' => 'required',
            'opening_balance' => 'required',
            'ledger_at' => 'required|date_format:Y-m-d',
            'comments' => 'nullable',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        Ledger::create([
            'company_id' => $request->company_id,
            'ledger_at' => $request->ledger_at,
            'debit_amount' => $request->opening_balance,
            'credit_amount' => 0,
            'balance_amount' => $request->opening_balance,
            'comments' => $request->comments,
            'amount_type' => 3, // OB
        ]);

        return Redirect::back()->with('success', 'Opening Balance added.');
    }

    public function fetchLedgerInvoice(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();

        $invoice_uploads = InvoiceUpload::query()
            ->where('invoice_id', $invoice->id)
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString()
            ->through(fn($upload) => [
                'id' => $upload->id,
                'invoice_id' => $upload->invoice_id,
                'url' => $upload->url,
            ]);

        $data['invoice'] = $invoice;
        $data['invoice_uploads'] = $invoice_uploads;

        return response()->json($data);
    }
}
