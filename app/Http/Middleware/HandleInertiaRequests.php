<?php

namespace App\Http\Middleware;

use App\Models\Dropdown;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\UserResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        
 
        return array_merge(parent::share($request), [
            'auth' => (\Auth::check()) ? new UserResource(\Auth::user()) : '',
            'flash' => [
                'message' => session('message'),
                'data' => session('data'),
                'type' => session('type'),
                'color' => session('color')
            ],
            'dropdowns' => Dropdown::all()
        ]);
    }
}
