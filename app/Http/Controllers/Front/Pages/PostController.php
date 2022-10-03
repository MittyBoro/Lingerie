<?php

namespace App\Http\Controllers\Front\Pages;


use Illuminate\Http\Request;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

	public function index(Request $request)
	{
		$slug = $request->route('any2');

		$post = Post::with(['media', 'partner'])
						->whereSlug($slug)
						->first();

		if (!$post) {
			return redirect('/news');
		}

		$post = $post->append('photos', 'videos');

		$similar = Cache::remember('post_similar_' . $post->id, 60 * 60, function() use ($post) {
			return Post::with(['media'])
							->where('id', '!=', $post->id)
							->publicPosts()
							->inRandomOrder($post->id)
							->limit(4)->get();
		});

		$this->replacePageData($post);

		return view('pages.post', [
			'page' => $this->page,
			'post' => $post,
			'similar' => $similar,
		]);
	}


}
