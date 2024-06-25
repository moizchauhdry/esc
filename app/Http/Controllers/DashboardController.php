<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $role_id = getRoleID($user);

        $shipments = Invoice::when($role_id == 2, function ($query) use ($user) {
            $query->where('company_id', $user->id);
        })->count();

        $revenue = Invoice::when($role_id == 2, function ($query) use ($user) {
            $query->where('company_id', $user->id);
        })->sum('total');
        
        $companies = User::role('company')->count();
        $users = User::count();

        $data = [
            'shipments' => $shipments,
            'revenue' => $revenue,
            'companies' => $companies,
            'users' => $users,
        ];

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }

    public function saveToken(Request $request)
    {
        $user = Auth::user();
        $user->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $SERVER_API_KEY = 'XXXXXX';
  
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);
  
        dd($response);
    }
}
