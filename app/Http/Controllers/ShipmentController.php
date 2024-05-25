<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShipmentController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['shipper', 'consignee', 'company'])
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
                'departure_at' => $invoice->departure_at,
                'destination' => $invoice->destination,
                'landing_at' => $invoice->landing_at,
            ]);

        return Inertia::render('Invoice/Index', [
            'invoices' => $invoices,
            'page_type' => "shipment",
        ]);
    }
}
