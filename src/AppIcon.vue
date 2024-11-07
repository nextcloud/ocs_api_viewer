<template>
	<svg width="24"
		height="24"
		viewBox="0 0 24 24">
		<image x="0"
			y="0"
			width="24"
			height="24"
			preserveAspectRatio="xMinYMin meet"
			:xlink:href="href"
			class="app-icon" />
	</svg>
</template>

<script>
export default {
	name: 'AppIcon',
	props: {
		href: { type: String, default: '' },
	},
}
</script>

<style>
.app-navigation-entry.active .app-icon {
	filter: unset;
}

.app-navigation-entry .app-icon {
	filter: invert(100%);
}

[data-themes*='dark'] {
	.app-navigation-entry.active .app-icon {
		filter: invert(100%);
	}

	.app-navigation-entry .app-icon {
		filter: unset;
	}
}

</style>
