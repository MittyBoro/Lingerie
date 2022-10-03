<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PostRequest;
use App\Models\Partner;
use Illuminate\Http\Request;

use App\Models\Post;

use Inertia\Inertia;
use PhpParser\Builder\Param;

class PostController extends Controller
{

	public function index()
	{
		$post = Post::with('media')->paginated();

		return Inertia::render('Posts/Index', [
			'list' => $post,
		]);
	}

	public function create()
	{
		return Inertia::render('Posts/Form', [
			...$this->editorData(),
		]);
	}

	public function store(PostRequest $request)
	{
		$data = $request->validated();

		$data['user_id'] = $request->user()->id;

		$post = Post::create($data);
		$post->saveRelations($data);

		return redirect(route('admin.posts.edit', $post->id));
	}

	public function edit(Post $post)
	{
		$post->editing = true;

		$post->setAppends(['preview', 'photos', 'videos']);

		return Inertia::render('Posts/Form', [
			'item' => $post,

			...$this->editorData(),
		]);
	}

	public function update(PostRequest $request, Post $post)
	{
		$data = $request->validated();

		$post->update($data);
		$post->saveRelations($data);

		return back();
	}

	public function destroy(Post $post)
	{
		if ( $post->is_published )
		{
			return back()->withErrors(['Запрещено удалять опубликованное']);
		}

		$post->delete();

		return back();
	}

	private function editorData() : array
	{
		return [
			'partners' => Partner::ordered()->franchisee()->get(),
		];
	}
}
