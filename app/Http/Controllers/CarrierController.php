<?php

namespace App\Http\Controllers;

use App\Models\Carrier;
use Illuminate\Http\Request;

class CarrierController extends Controller
{
    public function save($request, $edit_mode = false)
    {
        // Determine the carrier ID for unique validation
        $carrierId = $request->carrier_id;
    
        $rules = [
            'carrier_name' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'unique:carriers,carrier_name,' . $carrierId,
            ],
            'carrier_code' => [
                'required',
                'numeric',
                'unique:carriers,carrier_code,' . $carrierId,
            ],
        ];
    
        $validate = $request->validate($rules);
    
        $data = [
            'carrier_name' => $request->carrier_name,
            'carrier_code' => $request->carrier_code,
        ];
    
        if ($carrierId) {
            $carrier = Carrier::find($carrierId);
            $carrier->update($data);
        } else {
            $carrier = Carrier::create($data);
        }
    }
    

    public function store(Request $request)
    {
        $this->save($request);
        return redirect()->back()->with('success', 'Record created.');
    }

    public function update(Request $request)
    {
        $this->save($request, true);
        return redirect()->back()->with('success', 'Record updated.');
    }

    public function fetchCarrier($id)
    {
        $carrier = Carrier::find($id);

        $data = [
            'selected_carrier' => $carrier,
        ];

        return response()->json($data);
    }
}
