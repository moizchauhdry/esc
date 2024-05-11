<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices
        ]);
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            // 'invoice_id' => 'required|string|min:5|max:50',
            // 'shipper_id' => 'required|string|min:5|max:50',
            'shipper_name' => 'required|string|min:5|max:50',
            'shipper_address' => 'required|string|min:5|max:50',
            // 'consignee_id' => 'required|string|min:5|max:50',
            'consignee_name' => 'required|string|min:5|max:50',
            'consignee_address' => 'required|string|min:5|max:50',
            'carrier' => 'required|string|min:5|max:50',
            'mawb_no' => 'required|string|min:5|max:50',
            'quantity' => 'required|string|min:5|max:50',
            'weight' => 'required|string|min:5|max:50',
            'commodity' => 'required|string|min:5|max:50',
            'afc_rate' => 'required|string|min:5|max:50',
            'sender' => 'required|string|min:5|max:50',
            'destination' => 'required|string|min:5|max:50',
            'consignment_no' => 'required|string|min:5|max:50',
            'departure_airport' => 'required|string|min:5|max:50',
            'issued_by' => 'required|string|min:5|max:50',
            // 'created_by' => 'required|string|min:5|max:50',
        ]);

        $data = [
            // 'invoice_id' => $request->invoice_id,
            'shipper_id' => 0,
            'shipper_name' => $request->shipper_name,
            'shipper_address' => $request->shipper_address,
            'consignee_id' => 0,
            'consignee_name' => $request->consignee_name,
            'consignee_address' => $request->consignee_address,
            'carrier' => $request->carrier,
            'mawb_no' => $request->mawb_no,
            'quantity' => $request->quantity,
            'weight' => $request->weight,
            'commodity' => $request->commodity,
            'afc_rate' => $request->afc_rate,
            'sender' => $request->sender,
            'destination' => $request->destination,
            'consignment_no' => $request->consignment_no,
            'departure_airport' => $request->departure_airport,
            'issued_by' => $request->issued_by,
            'created_by' => auth()->id(),
        ];

        $invoice = Invoice::create($data);
    }
}
