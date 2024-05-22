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
                'data' => $user,
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
            'role' => 'required',
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
            $user->syncRoles($validate['role']);
        } else {
            $user = user::create($data);
            $user->assignRole($validate['role']);
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

    public function fetch(Request $request)
    {
        $contact = User::find($request->id);

        return back()->with([
            'contact' => $contact
        ]);
    }
}
