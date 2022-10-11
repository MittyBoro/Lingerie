<template>
	<tbody>
		<tr v-for="(row, i) in items" :key="i">
			<TData
				v-for="head in headers"
				:key="head.key"
				:title="head.text">
				{{ row[head.key] }}
			</TData>
		</tr>
	</tbody>

</template>

<script>

	export default {

		props: ['headers', 'items'],

		computed:
		{
			newItems()
			{
				let rows = [];
				this.items.forEach(el =>
				{
					let row = [];
					Object.entries(el).forEach(([key, value]) =>
					{
						row.push({
							key: key,
							value: value,
						})
					});
					rows.push(row);
				});

				return rows;
			}
		}

	}
</script>
