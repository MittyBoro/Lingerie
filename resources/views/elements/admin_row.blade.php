
<div class="toadmin">
    <div class="container">
        <a href="{{ route('admin.dashboard') }}" target="_blank">Панель управления</a>

        @isset($product['id'])
            <a href="{{ route('admin.products.edit', $product->id) }}" target="_blank">Редактировать товар</a>
        @endisset
        @if(isset($category_id))
            <a href="{{ route('admin.product_categories.edit', $category_id) }}" target="_blank">Редактировать категорию</a>
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
    .toadmin .container {
        display: flex;
        align-items: center;
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
