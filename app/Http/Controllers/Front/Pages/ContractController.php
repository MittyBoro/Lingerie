<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;
use App\Services\Cities;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $leftMenu = $this->getLeftMenu();
        $cities = Cities::list()->sortBy('name');

        return view('pages.contract', [
            'page' => $this->page,
            'left_menu' => $leftMenu,
            'cities' => $cities,
        ]);
    }

    private function getLeftMenu()
    {
        $leftMenu = [];

        foreach($this->page->props['left_menu'] as $v) {
            if (empty($v))
                continue;

            $vArray = explode(':', $v);
            $title = ltrim($vArray[0], '-');

            $leftMenu[] = (object) [
                'depth' => $title === $vArray[0] ? 0 : 1,
                'title' => trim($title),
                'url' => trim($vArray[1]) ?? '/',
            ];
        }

        return $leftMenu;
    }

}
