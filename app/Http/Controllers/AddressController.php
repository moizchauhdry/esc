<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'type' => 'required|in:shipper,consignee',
            'address_1' => 'required|string|max:50',
            'address_2' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'state' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'zipcode' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|string|max:50',
        ]);

        $data = [
            'type' => $request->type,
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

        return Redirect::route('invoice.index')->with('address', $address->id);

    }
}
