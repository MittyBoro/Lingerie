<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

use App\Models\Post;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $countPerPage = is_desktop() ? 8 : 6;

        $news = Post::with('media')->publicPosts()
                    ->setPerPage($countPerPage)
                    ->paginated();

        return view('pages.blog', [
            'page' => $this->page,
            'news' => $news,
        ]);
    }

}
