<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->roles[0]->name ?? '-',
                'role_id' => $user->roles[0]->id ?? NULL,
                'created_at' => $user->created_at->format('d-m-Y h:i A'),
                'phone' => $user->phone,
                'address_1' => $user->address_1,
                'address_2' => $user->address_2,
                'city' => $user->city,
                'state' => $user->state,
                'country' => $user->country,
                'zipcode' => $user->zipcode,
            ]);

        $roles = Role::select('id', 'name')->get();

        return Inertia::render('User/Index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function save($request, $edit_mode = false)
    {
        $rules = [
            'name' => 'required|string|min:5|max:50',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'required|unique:users|max:50',
            'address_1' => 'required',
            'address_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zipcode' => 'required',
        ];

        if (!$edit_mode) {
            $rules += [
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required',
            ];
        }

        $validate = $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),

            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
        ];

        if ($request->user_id) {
            $user = User::find($request->user_id);
            $user->update($data);

            if (isset($validate['role'])) {
                $user->syncRoles($validate['role']);
            }
        } else {
            $user = user::create($data);
            if (isset($validate['role'])) {
                $user->assignRole($validate['role']);
            }
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

    public function fetchShipper($id)
    {
        $selected_shipper = User::find($id);

        $data = [
            'selected_shipper' => $selected_shipper
        ];

        return response()->json($data);
    }

    public function fetchConsignee($id)
    {
        $selected_consignee = User::find($id);

        $data = [
            'selected_consignee' => $selected_consignee
        ];

        return response()->json($data);
    }
}
