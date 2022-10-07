<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
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
        setlocale(LC_ALL, 'ru_RU.utf8');
        Carbon::setLocale(config('app.locale'));


        $this->registerBladeSVG();
    }

    private function registerBladeSVG()
    {
        Blade::directive('svg', function($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            $public_path = public_path('assets/' . $path);

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
}
