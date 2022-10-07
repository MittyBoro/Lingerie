# CryptoTime

## First
Install
```
composer require barryvdh/laravel-debugbar --dev
composer require barryvdh/laravel-ide-helper --dev
composer require "spatie/laravel-medialibrary"
composer require inertiajs/inertia-laravel
composer require tightenco/ziggy
```

Next
```
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
php artisan inertia:middleware
```

Add
```
app/helpers.php
```

`composer.json`
```
"autoload": {
*****
"files": [
    "app/helpers.php"
]
},
```

`App\Http\Kernel`
```
'web' => [
// ...
\App\Http\Middleware\HandleInertiaRequests::class,
],
```

## The Admin

Boro Files for admin:
```
app/Http/Middleware/Admin.php
app/Http/Controllers/
app/Http/Requests/
app/Models/BaseModel.php
app/Models/User.php
app/Services/
app/Providers/RouteServiceProvider.php

config/theadmin.php

database/migrations/2014_10_12_000000_create_users_table.php

lang/ru/

routes/admin.php
routes/auth.php

resources/admin/

tailwind.config.js
webpack.mix.js
```

`App\Http\Kernel`
```
protected $routeMiddleware = [
'admin' => \App\Http\Middleware\Admin::class,
// ...
];
```

`App\Http\Middleware\HandleInertiaRequests`
```
public function share(Request $request)
{
return array_merge(parent::share($request), [
    'config' => fn () => config('theadmin'),
    'currentRouteName' => fn () => $request->route()->getName(),
    'user' => fn () => $request->user()
        ? $request->user()->only('id', 'name', 'login', 'email', 'avatar')
        : null,
]);
}
```

### Config

`app.php`
```
// ...
'locale' => 'ru',
// ...
'faker_locale' => 'ru_RU',
// ...
```

Copy paste `media-library.php`

`view.php`
```
'paths' => [
resource_path('views'),
resource_path('admin/views'),
],
```

