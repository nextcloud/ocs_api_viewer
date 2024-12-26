<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<div class="ocs_api-welcome">
		<AppIcon class="ocs_api-icon" :href="imagePath('ocs_api_viewer', 'app.svg')" />
		<div class="ocs_api-intro">
			{{ text.intro }}
		</div>
		<div class="ocs_api-descriptions">
			{{ text.description }}
		</div>
		<div class="ocs_api-help">
			{{ text.help }}
			<NcActions>
				<NcActionLink :href="url.help" target="_blank">
					<template #icon>
						<OpenInNew :size="20" />
					</template>
					Nextcloud openapi-extractor
				</NcActionLink>
			</NcActions>
		</div>
	</div>
</template>

<script>
import NcActionLink from '@nextcloud/vue/dist/Components/NcActionLink.js'
import NcActions from '@nextcloud/vue/dist/Components/NcActions.js'
import OpenInNew from 'vue-material-design-icons/OpenInNew.vue'
import { imagePath } from '@nextcloud/router'
import AppIcon from './AppIcon.vue'

export default {
	name: 'Welcome',

	components: {
		NcActions,
		NcActionLink,
		OpenInNew,
		AppIcon,
	},
	computed: {

		text() {
			return {
				intro: t('ocs_api_viewer', 'Select an app to get started'),
				description: t('ocs_api_viewer', 'Try out and execute API calls. APIs are only available according to your user rights. API calls are authorized according to your user rights.'),
				help: t('ocs_api_viewer', 'If you want your application to be listed here, you can just create an openapi.json file following the Nextcloud documentation.'),
			}
		},
		url() {
			return {
				help: 'https://github.com/nextcloud/openapi-extractor',
			}
		},
	},
	methods: {
		imagePath,
	},
}
</script>

<style scoped lang="scss">

.ocs_api {
	&-welcome {
		height: 100%;
		padding: calc(var(--default-grid-baseline) * 4);
		display: flex;
		align-items: center;
		flex-direction: column;
		justify-content: center;
	}

	&-icon {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 64px;
		height: 64px;
		margin: 0 auto 15px;
		opacity: 0.4;
		background-repeat: no-repeat;
		background-position: center;
		background-size: 64px;
	}

	&-intro {
		margin-bottom: 10px;
		text-align: center;
		font-weight: bold;
		font-size: 20px;
		line-height: 30px;
	}

	&-description {
		color: var(--color-text-maxcontrast);
	}

	&-help {
		font-style: italic;
		margin-top: 20px;
		font-size: 14px;
		display: inline-flex;
		line-height: 34px;
	}

	&-help a.button-vue {
		display: inline-flex;
	}
}
</style>
