<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use PDF;

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
            'invoices' => $invoices,
            'address' => session('address'),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            // 'shipper_id' => 'required|string|max:50',
            'shipper_account' => 'required|numeric',
            'shipper_address' => 'required|string|max:50',

            // 'consignee_id' => 'required|string|max:50',
            'consignee_account' => 'required|numeric',
            'consignee_address' => 'required|string|max:50',
            'carrier' => 'required|string|max:50',
            'mawb_no' => 'required|string|max:50',
            'quantity' => 'required|numeric',
            'weight' => 'required|numeric',
            'commodity' => 'required|string|max:50',
            'afc_rate' => 'required|string|max:50',
            'sender' => 'required|string|max:50',
            'destination' => 'required|string|max:50',
            'consignment_no' => 'required|string|max:50',
            'departure_airport' => 'required|string|max:50',
            'issued_by' => 'required|string|max:50',
            // 'created_by' => 'required|string|max:50',

            'items' => 'required|array',
            'items.*.particular' => 'required|max:150',
            'items.*.amount' => 'required|numeric|gte:0',
        ]);

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

            return Redirect::route('invoice.index')->with('success', 'Organization created.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $invoice = Invoice::find($request->invoice_id);

        $request->validate([
            'invoice_id' => 'required',

            // 'shipper_id' => 'required|string|max:50',
            'shipper_account' => 'required|numeric',
            'shipper_address' => 'required|string|max:50',

            // 'consignee_id' => 'required|string|max:50',
            'consignee_account' => 'required|numeric',
            'consignee_address' => 'required|string|max:50',
            'carrier' => 'required|string|max:50',
            'mawb_no' => 'required|string|max:50',
            'quantity' => 'required|numeric',
            'weight' => 'required|numeric',
            'commodity' => 'required|string|max:50',
            'afc_rate' => 'required|string|max:50',
            'sender' => 'required|string|max:50',
            'destination' => 'required|string|max:50',
            'consignment_no' => 'required|string|max:50',
            'departure_airport' => 'required|string|max:50',
            'issued_by' => 'required|string|max:50',
            // 'created_by' => 'required|string|max:50',

            'items' => 'required|array',
            'items.*.particular' => 'required|max:150',
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

            $invoice->update($data);

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

            return back()->with('address', 'hellow orld');

            // return Redirect::route('invoice.index')->with('success', 'Organization created.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function print($id)
    {
        $invoice = Invoice::find($id);

        view()->share([
            'invoice' => $invoice,
        ]);

        $pdf = PDF::loadView('prints.invoice');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
