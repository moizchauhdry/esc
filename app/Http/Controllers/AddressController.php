<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function fetch(Request $request)
    {        
        $address = Address::find($request->id);

        return back()->with([
            'address' => $address
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'type' => 'required|in:shipper,consignee',
            'name' => 'required|string|max:50',
            'address_1' => 'required|string|max:50',
            'address_2' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'country' => 'required|string|max:50',
            'zipcode' => 'required|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:50',
        ]);

        $data = [
            'type' => $request->type,
            'name' => $request->name,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
            'phone' => $request->phone,
            'email' => $request->email
        ];

        $address = Address::create($data);

        return back()->with([
            'address' => $address,
            'success' => 'Account created.'
        ]);
    }
}
