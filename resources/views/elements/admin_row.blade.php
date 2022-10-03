
<div class="toadmin">
	<div class="container flex aic">
		<a href="{{ route('admin.dashboard') }}" target="_blank">Панель управления</a>

		@isset($product->id)
			<a href="{{ route('admin.products.edit', $product->id) }}" target="_blank">Редактировать товар</a>
		@endisset
		@isset($post->id)
			<a href="{{ route('admin.posts.edit', $post->id) }}" target="_blank">Редактировать запись</a>
		@endisset
		@if(isset($page['slug']) && in_array($page['slug'], ['distributors' , 'franchisee']))
			<a href="{{ route('admin.partners.index') }}" target="_blank">Партнёры</a>
		@endif
		@if(isset($page['slug']) && $page['slug'] == 'category')
			<a href="{{ route('admin.categories.index', ['type' => 'products']) }}" target="_blank">Категории</a>
		@endif

		@isset($page['id'])
			<a href="{{ route('admin.pages.edit', $page->id) }}" target="_blank">Редактировать страницу</a>
		@endisset
	</div>
</div>

<style>
	.toadmin {
		background: #333;
		width: 100%;
		padding: 11px 20px;
	}
	.toadmin a {
		margin-left: 15px;
		color: #fff;
		font-size: 12px;
		font-weight: 600;
		text-align: right;
	}
	.toadmin a:first-child {
		margin-left: 0;
		margin-right: auto;
		padding-right: 15px;
		text-align: left;
	}
	.toadmin a:hover {
		text-decoration: underline;
	}
</style>
