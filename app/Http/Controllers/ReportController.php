<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function saleReport()
    {
        $query = Invoice::query();

        $invoices = $query
        ->orderBy('id', 'desc')
        ->paginate(10)
        ->withQueryString()
        ->through(fn($invoice) => [
            'id' => $invoice->id,
            'mawb_no' => $invoice->mawb_no,
            'invoice' => $invoice,
        ]);

        return Inertia::render('Report/SaleReport', [
            'invoices' => $invoices,
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
