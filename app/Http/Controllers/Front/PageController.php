<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\Front\Pages\DefaultController;
use App\Http\Controllers\Front\Traits\PageTrait;

class PageController extends Controller
{
	use PageTrait;

	public function index(Request $request, $slug = 'home')
	{
		return $this->getController($slug)->index(...func_get_args());
	}


	private function getController($slug)
	{
		$page = $this->getPage($slug);

		$class = __NAMESPACE__.'\\Pages\\'.Str::studly($page->route) . 'Controller';

		if ($page->route && class_exists($class)) {
			return new $class($page);
		}
		else {
			return new DefaultController($page);
		}
	}


}
