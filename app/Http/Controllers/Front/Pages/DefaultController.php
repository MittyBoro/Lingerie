<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;

class DefaultController extends Controller
{

	public function index()
	{
		$viewName = view()->exists('pages.'.$this->page->route) ? 'pages.'.$this->page->route : 'pages.default';

		return view($viewName, [
			'page' => $this->page
		]);
	}

}
