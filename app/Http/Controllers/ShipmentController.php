<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class ShipmentController extends Controller
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
                'sender' => $invoice->sender,
                'destination' => $invoice->destination,
                'departure_at' => Carbon::parse($invoice->departure_at)->format('d-m-Y h:i A'),
                'landing_at' => Carbon::parse($invoice->landing_at)->format('d-m-Y h:i A'),
                'status_id' => $invoice->status_id,
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
            'page_type' => "shipment",
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
        ];

        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->update($data);
        } else {
            $invoice = Invoice::create($data);
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
            'page_type' => "shipment",
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request);
        return Redirect::route('shipment.index')->with('success', 'Shipment created.');
    }

    public function edit($id)
    {
        $invoice = Invoice::with(['items'])->find($id);

        // dd($invoice);

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
            'page_type' => "shipment",
        ]);
    }

    public function update(Request $request)
    {
        $this->save($request);
        return Redirect::route('shipment.index')->with('success', 'Shipment updated.');
    }
}
