<?php

namespace App\Http\Controllers;

use App\Exports\SaleReportExport;
use App\Models\Carrier;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function saleReport(Request $request)
    {
        $carrier_name = $carrier_code = NULL;
        if (!empty($request->carrier_id)) {
            $carrier = Carrier::where('id', $request->carrier_id)->first();
            if ($carrier) {
                $carrier_name = $carrier->carrier_name;
                $carrier_code = $carrier->carrier_code;
            }
        }

        $filter = [
            'company_id' => $request->company_id,
            'carrier_id' => $request->carrier_id,
            'carrier_name' => $carrier_name,
            'carrier_code' => $carrier_code,
            'from' => !empty($request->from_date) ? Carbon::parse($request->from_date)->format('Y-m-d') : Carbon::now()->startOfMonth()->format('Y-m-d'),
            'to' => !empty($request->to_date) ? Carbon::parse($request->to_date)->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d'),
        ];

        session(['filter' => $filter]);

        $query = Invoice::select('*');
        $query->selectRaw('(total - net_payable) as net_total');

        $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
            $q->whereDate('invoice_at', '>=', $filter['from']);
            $q->whereDate('invoice_at', '<=', $filter['to']);
        });

        $query->when($filter['carrier_id'], function ($q) use ($filter) {
            $q->where('carrier_id', $filter['carrier_id']);
        });

        $query->when($filter['company_id'], function ($q) use ($filter) {
            $q->where('company_id', $filter['company_id']);
        });

        $invoices = $query
            ->orderBy('id', 'desc')
            ->paginate(10000)
            ->withQueryString()
            ->through(fn($invoice) => [
                'id' => $invoice->id,
                'mawb_no' => $invoice->mawb_no,
                'invoice_at' => dateFormat($invoice->invoice_at),
                'invoice' => $invoice,
                'company_name' => $invoice->company->name,
            ]);

        $expense_sum = Expense::whereDate('expense_at', '>=', $filter['from'])->whereDate('expense_at', '<=', $filter['to'])->sum('total_amount');
        $gross_profit_sum = $query->sum('total') - $query->sum('net_payable');

        $grand_total = [
            'invoice_amount_sum' => $query->sum('total'),
            'due_carrier_sum' => $query->sum('due_carrier'),
            'net_rate_sum' => $query->sum('net_rate'),
            'net_payable_sum' => $query->sum('net_payable'),
            'gross_profit_sum' => $gross_profit_sum,
            'expense_sum' => $expense_sum,
            'net_profit_sum' => $gross_profit_sum - $expense_sum,
        ];

        $carriers = Carrier::select('id as value', DB::raw("CONCAT(carrier_name, '-', carrier_code) as label"))->get();
        $companies = User::role('company')->get();

        return Inertia::render('Report/SaleReport', [
            'invoices' => $invoices,
            'carriers' => $carriers,
            'companies' => $companies,
            'filter' => $filter,
            'grand_total' => $grand_total,
        ]);
    }

    public function updateSaleReport(Request $request)
    {
        $invoice_id = $request->invoice_id;

        $rules = [
            'due_carrier' => [
                'required',
                'numeric',
            ],
            'net_rate' => [
                'required',
                'numeric',
            ],
        ];

        $validate = $request->validate($rules);

        $data = [
            'due_carrier' => $request->due_carrier ?? 0,
            'net_rate' => $request->net_rate ?? 0,
            'net_payable' => $request->due_carrier + $request->net_rate,
        ];

        $invoice = Invoice::find($invoice_id);
        $invoice->update($data);

        return redirect()->back()->with('success', 'Record updated.');
    }

    public function exportSaleReport()
    {
        $filter = session('filter', []);
        return Excel::download(new SaleReportExport($filter), 'data.xlsx');
    }
}
