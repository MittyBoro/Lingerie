<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // setlocale(LC_ALL, 'ru_RU.utf8');
        // Carbon::setLocale(config('app.locale'));

        $this->registerBladeSVG();
        $this->registerBladeViteAssets();
    }

    private function registerBladeViteAssets()
    {
        Blade::directive('vite_asset', function($str) {

            $arguments = $this->strToArgs($str, true);

            $path = 'resources/' . (isset($arguments[1]) ? $arguments[1] : 'front');
            $totalPath = $path .'/'. $arguments[0];

            return Vite::asset($totalPath);
        });
    }

    private function registerBladeSVG()
    {
        Blade::directive('svg', function($str) {
            list($path, $class) = array_pad($this->strToArgs($str), 2, '');

            $public_path = resource_path('front/' . $path);

            // Create the dom document as per the other answers
            $svg = new \DOMDocument();
            $svg->load($public_path);
            if ($class)
                $svg->documentElement->setAttribute("class", $class);
            $svg->documentElement->removeAttribute("style");
            $svg->documentElement->removeAttribute("id");

            $style = $svg->documentElement->getElementsByTagName('style')->item(0);
            if ($style)
                $style->parentNode->removeChild($style);

            $output = $svg->saveXML($svg->documentElement);

            return $output;
        });
    }

    private function strToArgs($str)
    {
        $args = explode(',', trim($str, "() "));

        foreach ($args as $key => $val) {
            $args[$key] = trim($val, "' ");
        }

        return $args;
    }
}
