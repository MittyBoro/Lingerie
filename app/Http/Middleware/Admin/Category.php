<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Category
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $request['model'] = $this->getModelClass($request);

        return $next($request);
    }

    public function getModelClass(Request $request)
    {
        $preffix = 'App\\Models\\';

        if ($request['type'] == 'products') {
            $preffix .= 'Product\\';
        }

        $model = $preffix.Str::of($request['type'])->singular()->studly();

        if (!is_subclass_of($model, Model::class))
            abort(404);

        return (new $model)::class;
    }
}
