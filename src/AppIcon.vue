<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<svg :width="size"
		:height="size"
		:viewBox="`0 0 ${size} ${size}`">
		<image x="0"
			y="0"
			:width="size"
			:height="size"
			:xlink:href="href"
			class="app-icon" />
	</svg>
</template>

<script>
export default {
	name: 'AppIcon',
	props: {
		href: { type: String, default: '' },
		size: { type: Number, default: 24 },
	},
}
</script>

<style lang="scss">
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
@media (prefers-color-scheme: dark)
{
	[data-themes='default'] {
		.app-navigation-entry.active .app-icon {
			filter: invert(100%);
		}

		.app-navigation-entry .app-icon {
			filter: unset;
		}
	}
}

</style>
