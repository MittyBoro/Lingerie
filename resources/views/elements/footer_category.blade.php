
@foreach ($footerCategories as $fCat)
    <div class="top-col">
        <div class="f-title mini-title secondary">{{ $fCat['title'] }}</div>
        <ul>
            @foreach ($fCat['children'] as $cat)
                <li><a href="{{ route('front.categories', $cat['slug']) }}">{{ $cat['title'] }}</a></li>
            @endforeach
        </ul>
    </div>
@endforeach
