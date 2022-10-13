<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'admin';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $request->merge(['is_inertia' => true]);

        return array_merge(parent::share($request), [
            'config' => fn () => config('admin'),
            'langs' => fn () => config('app.langs'),

            'auth' => [
                'user' => fn () => $request->user()
                        ? $request->user()->only('id', 'name', 'username', 'email', 'role', 'avatar')
                        : null,
            ],
        ]);
    }
}
