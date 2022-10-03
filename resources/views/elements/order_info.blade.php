
<a href="{{ route('profile.order', $order->id) }}" class="order-row">
	<div class="order-name">
		<b>Заказ #{{ $order->id }}</b>
		<span>на сумму {{ format_price($order->amount) }}₽</span>
	</div>
	<div class="order-date">
		<div class="status {{ $order->status }}">@lang($order->status)</div>
		<span data-format-datetime="{{ $order->created_at }}">{{ format_datetime($order->created_at) }}</span>
	</div>
</a>
