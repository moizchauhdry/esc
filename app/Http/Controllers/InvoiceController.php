<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id,
                'data' => $invoice,
                'items' => $invoice->items,
                'created_at' => $invoice->created_at->format('F d, Y'),
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices
        ]);
    }

    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            // 'invoice_id' => 'required|string|min:3|max:50',

            // 'shipper_id' => 'required|string|min:3|max:50',
            'shipper_account' => 'required|numeric',
            'shipper_address' => 'required|string|min:3|max:50',

            // 'consignee_id' => 'required|string|min:3|max:50',
            'consignee_account' => 'required|numeric',
            'consignee_address' => 'required|string|min:3|max:50',
            'carrier' => 'required|string|min:3|max:50',
            'mawb_no' => 'required|string|min:3|max:50',
            'quantity' => 'required|string|min:3|max:50',
            'weight' => 'required|string|min:3|max:50',
            'commodity' => 'required|string|min:3|max:50',
            'afc_rate' => 'required|string|min:3|max:50',
            'sender' => 'required|string|min:3|max:50',
            'destination' => 'required|string|min:3|max:50',
            'consignment_no' => 'required|string|min:3|max:50',
            'departure_airport' => 'required|string|min:3|max:50',
            'issued_by' => 'required|string|min:3|max:50',
            // 'created_by' => 'required|string|min:3|max:50',

            'items' => 'required|array',
            'items.*.particular' => 'required|min:3|max:150',
            'items.*.amount' => 'required|numeric|gte:0',
        ]);

        // dd('s');

        try {
            $data = [
                // 'invoice_id' => $request->invoice_id,
                'shipper_id' => 0,
                'shipper_account' => $request->shipper_account,
                'shipper_address' => $request->shipper_address,

                'consignee_id' => 0,
                'consignee_account' => $request->consignee_account,
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

            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            foreach ($request->items as $key => $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'particular' => $item['particular'],
                    'amount' => $item['amount']
                ]);
            }

            $invoice_total = InvoiceItem::where('invoice_id', $invoice->id)->sum('amount');
            $invoice->update([
                'subtotal' => $invoice_total,
                'total' => $invoice_total,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'invoice_id' => 'required',

            // 'shipper_id' => 'required|string|min:3|max:50',
            'shipper_account' => 'required|numeric',
            'shipper_address' => 'required|string|min:3|max:50',

            // 'consignee_id' => 'required|string|min:3|max:50',
            'consignee_account' => 'required|numeric',
            'consignee_address' => 'required|string|min:3|max:50',
            'carrier' => 'required|string|min:3|max:50',
            'mawb_no' => 'required|string|min:3|max:50',
            'quantity' => 'required|string|min:3|max:50',
            'weight' => 'required|string|min:3|max:50',
            'commodity' => 'required|string|min:3|max:50',
            'afc_rate' => 'required|string|min:3|max:50',
            'sender' => 'required|string|min:3|max:50',
            'destination' => 'required|string|min:3|max:50',
            'consignment_no' => 'required|string|min:3|max:50',
            'departure_airport' => 'required|string|min:3|max:50',
            'issued_by' => 'required|string|min:3|max:50',
            // 'created_by' => 'required|string|min:3|max:50',

            'items' => 'required|array',
            'items.*.particular' => 'required|min:3|max:150',
            'items.*.amount' => 'required|numeric|gte:0',
        ]);

        // dd('s');

        try {
            $data = [
                'shipper_id' => 0,
                'shipper_account' => $request->shipper_account,
                'shipper_address' => $request->shipper_address,

                'consignee_id' => 0,
                'consignee_account' => $request->consignee_account,
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

            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            foreach ($request->items as $key => $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'particular' => $item['particular'],
                    'amount' => $item['amount']
                ]);
            }

            $invoice_total = InvoiceItem::where('invoice_id', $invoice->id)->sum('amount');
            $invoice->update([
                'subtotal' => $invoice_total,
                'total' => $invoice_total,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
