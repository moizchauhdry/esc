<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use PDF;
use Spatie\Permission\Models\Role;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['shipper', 'consignee', 'company'])
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id,
                'data' => $invoice,
                'items' => $invoice->items,
                'created_at' => $invoice->created_at->format('F d, Y'),
                'company_name' => $invoice->company->name,
                'shipper_name' => $invoice->shipper->name,
                'consignee_name' => $invoice->consignee->name,
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices
        ]);
    }

    public function save($request)
    {
        $request->validate([
            'company_id' => 'required',
            'shipper_id' => 'required',
            'consignee_id' => 'required',
            'carrier' => 'required|string|max:50',
            'mawb_no' => 'required|string|max:50',
            'quantity' => 'required|numeric',
            'weight' => 'required|numeric',
            'commodity' => 'required|string|max:50',
            'sender' => 'required|string|max:50',
            'destination' => 'required|string|max:50',
            'items' => 'required|array',
            'items.*.particular' => 'required|max:150',
            'items.*.amount' => 'required|numeric|gte:0',
            'items.*.qty' => 'required|numeric|gte:1',
        ]);

        $data = [
            'company_id' => $request->company_id,
            'shipper_id' => $request->shipper_id,
            'consignee_id' => $request->consignee_id,
            'carrier' => $request->carrier,
            'mawb_no' => $request->mawb_no,
            'quantity' => $request->quantity,
            'weight' => $request->weight,
            'commodity' => $request->commodity,
            'sender' => $request->sender,
            'destination' => $request->destination,
            'created_by' => auth()->id(),
        ];

        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->update($data);
        } else {
            $invoice = Invoice::create($data);
        }

        InvoiceItem::where('invoice_id', $invoice->id)->delete();
        foreach ($request->items as $key => $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'particular' => $item['particular'],
                'amount' => $item['amount'],
                'qty' => $item['qty'],
                'total' =>  $item['amount'] * $item['qty'],
            ]);
        }

        $invoice_total = InvoiceItem::where('invoice_id', $invoice->id)->sum('total');
        $invoice->update([
            'subtotal' => $invoice_total,
            'total' => $invoice_total,
        ]);
    }

    public function create()
    {
        $shippers = User::role('shipper')->get();
        $consignees = User::role('consignee')->get();
        $companies = User::role('company')->get();
        $roles = Role::select('id', 'name')->whereIn('id', [3, 4])->get();

        return Inertia::render('Invoice/CreateInvoice', [
            'shippers' => $shippers,
            'consignees' => $consignees,
            'companies' => $companies,
            'roles' => $roles,
            'selected_shipper' => session('selected_shipper'),
            'selected_consignee' => session('selected_consignee'),
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request);
        return Redirect::route('invoice.index')->with('success', 'Invoice created.');
    }

    public function edit($id)
    {
        $invoice = Invoice::with(['items'])->find($id);

        $shippers = User::role('shipper')->get();
        $consignees = User::role('consignee')->get();
        $companies = User::role('company')->get();
        $roles = Role::select('id', 'name')->whereIn('id', [3, 4])->get();

        return Inertia::render('Invoice/CreateInvoice', [
            'invoice' => $invoice,
            'shippers' => $shippers,
            'consignees' => $consignees,
            'companies' => $companies,
            'roles' => $roles,
            'selected_shipper' => session('selected_shipper'),
            'selected_consignee' => session('selected_consignee'),
            'edit_mode' => true,
        ]);
    }

    public function update(Request $request)
    {
        $this->save($request);
        return Redirect::route('invoice.index')->with('success', 'Invoice updated.');
    }

    public function print($id)
    {
        $invoice = Invoice::find($id);
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();

        $shipper = User::where('id', $invoice->shipper_id)->first();
        $consignee = User::where('id', $invoice->consignee_id)->first();

        view()->share([
            'invoice' => $invoice,
            'shipper' => $shipper,
            'consignee' => $consignee,
            'items' => $items,
        ]);

        $pdf = PDF::loadView('prints.invoice');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
