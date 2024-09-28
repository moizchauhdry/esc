<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function saleReport(Request $request)
    {
        $filter = [
            'carrier_id' => $request->carrier_id,
            'from' => isset($request->invoice_at[0]) ? Carbon::parse($request->invoice_at[0])->format('Y-m-d') : Carbon::now()->startOfMonth()->format('Y-m-d'),
            'to' => isset($request->invoice_at[1]) ? Carbon::parse($request->invoice_at[1])->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d'),
        ];

        $query = Invoice::query();

        $query->when($filter['from'] && $filter['to'], function ($q) use ($filter) {
            $q->whereDate('invoice_at', '>=', $filter['from']);
            $q->whereDate('invoice_at', '<=', $filter['to']);
        });

        $query->when($filter['carrier_id'], function ($q) use ($filter) {
            $q->where('carrier_id', '>=', $filter['carrier_id']);
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
            ]);


        $carriers = Carrier::select('id as value', DB::raw("CONCAT(carrier_name, '-', carrier_code) as label"))->get();

        return Inertia::render('Report/SaleReport', [
            'invoices' => $invoices,
            'carriers' => $carriers,
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
            'due_carrier' => $request->due_carrier,
            'net_rate' => $request->net_rate,
            'net_payable' => $request->due_carrier * $request->net_rate,
        ];

        $invoice = Invoice::find($invoice_id);
        $invoice->update($data);

        return redirect()->back()->with('success', 'Record updated.');
    }
}
