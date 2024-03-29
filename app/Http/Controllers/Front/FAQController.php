<?php

namespace App\Http\Controllers\Front;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index(Request $request)
    {
        $faq = FAQ::getFrontList(locale());

        return view('pages.faq', [
            'faq' => $faq,
        ]);
    }
}
