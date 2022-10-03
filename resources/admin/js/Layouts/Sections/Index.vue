<template>
	<div class="bg-white shadow-lg rounded-xl sm:rounded-2xl pb-10 border-gray-200">

		<div v-if="$slots.title || $slots.buttons" class="px-6 md:px-10 pt-10 mb-10 md:flex">
			<div v-if="$slots.title" class="mb-4 md:mb-0">
				<div class="font-semibold text-2xl">
					<slot name="title"></slot>
				</div>
				<div v-if="$slots.subtitle" class="mt-4 grid gap-1">
					<slot name="subtitle"></slot>
				</div>
			</div>
			<div v-if="$slots.buttons" class="ml-auto md:pl-4 self-start flex flex-col">
				<slot name="buttons"></slot>
			</div>
		</div>

		<slot name="content"></slot>

	</div>
</template>
