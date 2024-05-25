<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = auth()->user();

        $data = [];
        
        if ($user) {
            $data = [
                'auth' => [
                    'user' => $request->user(),
                ],
                'can' => [
                    'dashboard' => $user->can('dashboard'),

                    'role_list' => $user->can('role_list'),
                    'role_create' => $user->can('role_create'),
                    'role_update' => $user->can('role_update'),
                    
                    'user_list' => $user->can('user_list'),
                    'user_create' => $user->can('user_create'),
                    'user_update' => $user->can('user_update'),
                    'user_delete' => $user->can('user_delete'),
                    
                    'shipment_list' => $user->can('shipment_list'),
                    'shipment_create' => $user->can('shipment_create'),
                    'shipment_update' => $user->can('shipment_update'),
                    'shipment_delete' => $user->can('shipment_delete'),
                    
                    'dashboard' => $user->can('dashboard'),
                    'dashboard' => $user->can('dashboard'),
                    'dashboard' => $user->can('dashboard'),
                    'dashboard' => $user->can('dashboard'),
                    'dashboard' => $user->can('dashboard'),
                    'dashboard' => $user->can('dashboard'),
                ],
                'ziggy' => function () use ($request) {
                    return array_merge((new Ziggy)->toArray(), [
                        'location' => $request->url(),
                    ]);
                },
            ];
        }

        return array_merge(parent::share($request), $data);
    }
}
