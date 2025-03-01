<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NoSpacePassword;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = [
            'search_key' => $request->search_key,
            'search_value' => $request->search_value,
        ];

        $users = User::orderBy('users.name', 'asc')
            ->when($filter['search_key'] && $filter['search_value'], function ($q) use ($filter) {
                if ($filter['search_key'] == 1) {
                    $q->where('id', $filter['search_value']);
                }

                if ($filter['search_key'] == 2) {
                    $q->where('name', 'LIKE', '%' . $filter['search_value'] . '%');
                }

                if ($filter['search_key'] == 3) {
                    $q->where('email', $filter['search_value']);
                }

                if ($filter['search_key'] == 4) {
                    $q->whereHas('roles', function ($qry) use ($filter) {
                        $qry->where('id', $filter['search_value']);
                    });
                }
            })
            ->paginate(10)
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
        // dd($request->all());

        $rules = [
            'name' => 'required|string|min:3|max:50',
            'phone' => 'nullable|max:25',
            'address_1' => 'nullable',
            'address_2' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zipcode' => 'nullable',
        ];

        if (!in_array($request->role, [3, 4])) {
            $rules += [
                'email' => 'required|max:50|unique:users,email,' . ($edit_mode ? $request->user_id : NULL) . ',id',
            ];
        }

        if (!$edit_mode) {
            $rules += [
                'role' => 'required',
            ];

            if (!in_array($request->role, [3, 4])) {
                $rules += [
                    'password' => ['string', 'min:8', 'confirmed', 'required',  new NoSpacePassword],
                ];
            }
        }

        $validate = $request->validate($rules);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
        ];

        if (in_array($request->role, [3, 4])) {
            $data += [
                'email' => Hash::make(123),
            ];
        } else {
            $data += [
                'email' => $request->email,
            ];
        }

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
        $user = User::find($id);

        $data = [
            'selected_shipper' => $user,
            'role' => $user->roles[0]->id,
        ];

        return response()->json($data);
    }

    public function fetchConsignee($id)
    {
        $user = User::find($id);

        $data = [
            'selected_consignee' => $user,
            'role' => $user->roles[0]->id,
        ];

        return response()->json($data);
    }

    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $rules = [
            'user_id' => ['required'],
            'password' => ['string', 'min:8', 'confirmed', 'required', new NoSpacePassword],
        ];

        $request->validate($rules);

        $data = [
            'password' => Hash::make($request->password)
        ];

        $user->update($data);


        return redirect()->back()->with('success', 'Password updated.');
    }
}
