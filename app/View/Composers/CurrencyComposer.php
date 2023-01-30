<?php

namespace App\View\Composers;

use Illuminate\View\View;

class CurrencyComposer extends Composer
{
    public function compose(View $view)
    {
        $cy = config('app.currencies.' . $this->lang);

        $cySymb = $cy;

        if ($cy == 'rub')
            $cySymb = '₽';
        elseif ($cy == 'usd')
            $cySymb = '$';

        $view->with([
            'cy' => $cy,
            'cySymb' => $cySymb,
        ]);
    }
}
