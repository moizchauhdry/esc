<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceUpload;
use App\Models\Ledger;
use App\Models\Template;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'search_key' => $request->search_key,
            'search_value' => $request->search_value,
        ];

        $query = Invoice::with(['shipper', 'consignee', 'company']);

        $query->when($user_role_id == 2, function ($qry) use ($user) {
            $qry->where('company_id', $user->id);
        });

        $query->when($filter['search_key'] && $filter['search_value'], function ($q) use ($filter) {

            if ($filter['search_key'] == 1) {
                // $q->where('mawb_no', 'LIKE', '%' . $filter['search_value'] . '%');
                $q->where('mawb_no', $filter['search_value']);
            }

            if ($filter['search_key'] == 2) {
                $q->where('id', $filter['search_value']);
            }

            if ($filter['search_key'] == 3) {
                $q->where('company_id', $filter['search_value']);
            }

            if ($filter['search_key'] == 4) {
                $q->where('shipper_id', $filter['search_value']);
            }

            if ($filter['search_key'] == 5) {
                $q->where('consignee_id', $filter['search_value']);
            }
        });

        $invoices = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString()
            ->through(fn($invoice) => [
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

        $companies = User::select('id as value', 'name as label')->role('company')->get();
        $shippers = User::select('id as value', 'name as label')->role('shipper')->get();
        $consignees = User::select('id as value', 'name as label')->role('consignee')->get();

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
            'page_type' => "invoice",
            'companies' => $companies,
            'shippers' => $shippers,
            'consignees' => $consignees,
            'filter' => $filter,
        ]);
    }

    public function save($request)
    {
        $rules = [
            'invoice_at' => 'required',
            'company_id' => 'required',
            'shipper_id' => 'required',
            'consignee_id' => 'required',

            'carrier' => 'required|integer',

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

        $carrier = Carrier::where('id', $request->carrier)->first();

        $data = [
            'invoice_at' => $request->invoice_at,
            'company_id' => $request->company_id,
            'shipper_id' => $request->shipper_id,
            'consignee_id' => $request->consignee_id,

            'carrier' => $carrier->carrier_name,
            'carrier_id' => $request->carrier,

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
                'invoice_at' => $request->invoice_at,
                'ledger_at' => $request->invoice_at,
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
        $shippers = User::role('shipper')->select('id as value', 'name as label')->orderBy('name', 'asc')->get();
        $consignees = User::role('consignee')->select('id as value', 'name as label')->orderBy('name', 'asc')->get();
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

        $shippers = User::role('shipper')->select('id as value', 'name as label')->orderBy('name', 'asc')->get();
        $consignees = User::role('consignee')->select('id as value', 'name as label')->orderBy('name', 'asc')->get();
        $companies = User::role('company')->get();
        $roles = Role::select('id', 'name')->whereIn('id', [3, 4])->get();
        $templates = Template::get();
        $carriers = Carrier::select('id as value', DB::raw("CONCAT(carrier_name, '-', carrier_code) as label"))->get();

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
            'templates' => $templates,
            'carriers' => $carriers,
        ]);
    }

    public function update(Request $request)
    {
        $this->save($request);
        return Redirect::route('invoice.index')->with('success', 'Invoice updated.');
    }

    public function detail($id)
    {
        $invoice = Invoice::with(['company', 'shipper', 'consignee'])->find($id);

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


        return Inertia::render('Invoice/Detail', [
            'invoice' => $invoice,
            'invoice_uploads' => $invoice_uploads,
        ]);
    }

    public function print($id)
    {
        $invoice = Invoice::with('getCarrier')->find($id);
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
        // return $pdf->download('invoice.pdf');
    }

    public function upload(Request $request)
    {
        $rules = [
            'invoice_id' => 'required',
            'file' => 'required|file|mimes:pdf,jpg,png|max:51200',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        try {
            $request->validate($rules, $messages);

            $url = $request->file('file')->store('invoice-files', 'public');
            InvoiceUpload::create([
                'invoice_id' => $request->invoice_id,
                'url' => $url
            ]);
            return Redirect::route('invoice.detail', $request->invoice_id)->with('success', 'File uploaded.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return Redirect::route('invoice.detail', $request->invoice_id)->withErrors($e->validator)->withInput()->with('error', 'Validation failed. Please check the inputs.');
        }
    }

    public function uploadDestroy(Request $request)
    {
        InvoiceUpload::find($request->upload_id)->delete();
        return Redirect::back()->with('success', 'File deleted.');
    }
}
