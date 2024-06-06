<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceUpload;
use App\Models\Ledger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use PDF;
use Spatie\Permission\Models\Role;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $user_role_id = NULL;
        if ($user && isset($user->roles[0])) {
            $user_role_id = $user->roles[0]->id;
        }

        $filter = [
            'invoice_id' => $request->invoice_id,
            'mawb_no' => $request->mawb_no,
        ];


        $query = Invoice::with(['shipper', 'consignee', 'company']);

        $query->when($user_role_id == 2, function ($qry) use ($user) {
            $qry->where('company_id', $user->id);
        });

        $query->when($filter['invoice_id'], function ($q) use ($filter) {
            $q->where('id', $filter['invoice_id']);
        });

        $query->when($filter['mawb_no'], function ($q) use ($filter) {
            $q->where('mawb_no', 'LIKE', '%' . $filter['mawb_no'] . '%');
        });

        $invoices = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($invoice) => [
                'id' => $invoice->id,
                'mawb_no' => $invoice->mawb_no,
                'company_name' => $invoice->company->name,
                'shipper_id' => $invoice->shipper->id,
                'shipper_name' => $invoice->shipper->name,
                'consignee_id' => $invoice->consignee->id,
                'consignee_name' => $invoice->consignee->name,
                'total' => $invoice->total,
                'invoice_at' => Carbon::parse($invoice->invoice_at)->format('d-m-Y h:i A'),
                'status_id' => $invoice->status_id,
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
            'page_type' => "invoice",
        ]);
    }

    public function save($request)
    {
        $rules = [
            'invoice_at' => 'nullable',
            'company_id' => 'required',
            'shipper_id' => 'required',
            'consignee_id' => 'required',

            'carrier' => 'required|string|max:50',
            'mawb_no' => 'required|string|max:20',
            'quantity' => 'required|numeric',
            'weight' => 'required|numeric',
            'afc_rate' => 'nullable|numeric',
            'commodity' => 'required|string|max:250',

            'departure_at' => 'required',
            'landing_at' => 'required',
            'sender' => 'required|string|max:50',
            'destination' => 'required|string|max:50',

            'items' => 'required|array',
            'items.*.particular' => 'required|max:250',
            'items.*.amount' => 'required|numeric|gte:0',
            'items.*.qty' => 'required|numeric|gte:1',

            'status_id' => 'required',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        $data = [
            'invoice_at' => $request->invoice_at,
            'company_id' => $request->company_id,
            'shipper_id' => $request->shipper_id,
            'consignee_id' => $request->consignee_id,

            'carrier' => $request->carrier,
            'mawb_no' => $request->mawb_no,
            'commodity' => $request->commodity,
            'quantity' => $request->quantity,
            'weight' => $request->weight,
            'afc_rate' => $request->afc_rate,

            'departure_at' => $request->departure_at,
            'landing_at' => $request->landing_at,
            'sender' => $request->sender,
            'destination' => $request->destination,
            'created_by' => auth()->id(),

            'status_id' => $request->status_id,
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
                'total' =>  (float) $item['amount'] * (float) $item['qty'],
            ]);
        }

        $invoice_total = InvoiceItem::where('invoice_id', $invoice->id)->sum('total');
        $invoice->update([
            'subtotal' => $invoice_total,
            'total' => $invoice_total,
        ]);


        if ($invoice->status_id == 2) {
            Ledger::updateOrCreate(['invoice_id' => $invoice->id], [
                'company_id' => $invoice->company_id,
                'invoice_id' => $invoice->id,
                'invoice_at' => $invoice->invoice_at,
                'debit_amount' => $invoice->total,
                'credit_amount' => 0,
                'balance_amount' => $invoice->total,
            ]);
        }

        if ($invoice->status_id == 3) {
            Ledger::where('invoice_id', $invoice->id)->delete();
        }
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
            'page_type' => "invoice",
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
            'page_type' => "invoice",
        ]);
    }

    public function update(Request $request)
    {
        $this->save($request);
        return Redirect::route('invoice.index')->with('success', 'Invoice updated.');
    }

    public function detail($id)
    {
        $invoice = Invoice::with(['company', 'shipper', 'consignee', 'uploads'])->find($id);

        return Inertia::render('Invoice/Detail', [
            'invoice' => $invoice,
        ]);
    }

    public function print($id)
    {
        $invoice = Invoice::find($id);
        $items = InvoiceItem::where('invoice_id', $invoice->id)->get();

        $shipper = User::where('id', $invoice->shipper_id)->first();
        $consignee = User::where('id', $invoice->consignee_id)->first();


        $user = Auth::user();
        if ($user->roles[0]->id == 2 && $user->id != $invoice->company_id) {
            abort(403);
        }

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

    public function upload(Request $request)
    {
        $rules = [
            'invoice_id' => 'required',
            'file' => 'required',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        $url = $request->file('file')->store('invoice-files', 'public');
        InvoiceUpload::create([
            'invoice_id' => $request->invoice_id,
            'url' => $url
        ]);

        return Redirect::route('invoice.detail', $request->invoice_id)->with('success', 'File uploaded.');
    }
}
