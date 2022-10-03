<div id="item-{{$item->id}}" class="franchisee-item" :class="{ invisible: !showCity('{{ $item->city }}') }">
	<div class="left-col">
		<div class="h3">{{ $item->company_name }}</div>
		<div class="frd-name">Директор: {{ $item->person_name }}</div>
		<div class="frd-city" v-show="city" v-html="highlight('{{ $item->city }}')"></div>
		@if ($item->address)
			<div class="fr-address">Адрес: {{ $item->address }}</div>
		@endif
		@includeWhen($item->information, 'elements.partner_icons', ['information' => $item->information])
	</div>
	<div @click="intoMapView({{$item->id}})" class="to_map">
		@svg('images/svg/location.svg')
	</div>
</div>
