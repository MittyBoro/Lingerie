<?php

namespace App\Http\Middleware;

use Cookie;
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
    protected $rootView = 'layouts.admin';

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

            'langs' => fn () => $this->langsList(),
            'currencies' => config('app.currencies'),
            'admin_lang' => fn () => admin_lang(),

            'auth' => [
                'user' => fn () => $request->user()
                        ? $request->user()->only('id', 'name', 'username', 'email', 'role', 'avatar')
                        : null,
            ],
        ]);
    }

    private function langsList()
    {
        $list = [];
        foreach (config('app.langs') as $lang) {
            $list[$lang] = strtoupper($lang);
        }

        return $list;
    }
}
