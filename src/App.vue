<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-FileCopyrightText: 2023 Kate Döen <kate.doeen@nextcloud.com>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<!--
	SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
	SPDX-License-Identifier: AGPL-3.0-or-later
	-->
	<NcContent app-name="ocs_api_viewer">
		<LeftSidebar />
		<NcAppContent>
			<SwaggerUI v-if="currentAppID"
				:key="currentAppID"
				:openapi="generateUrl(`/apps/ocs_api_viewer/apps/${currentAppID}`)" />
			<WelcomeScreen v-else />
		</NcAppContent>
	</NcContent>
</template>

<script>
import { generateUrl } from '@nextcloud/router'
import { NcAppContent, NcContent } from '@nextcloud/vue'
import LeftSidebar from './LeftSidebar.vue'
import SwaggerUI from './SwaggerUI.vue'
import WelcomeScreen from './WelcomeScreen.vue'
import { useAppsStore } from './store.js'

const store = useAppsStore()

export default {
	name: 'App',
	components: {
		NcAppContent,
		NcContent,
		SwaggerUI,
		LeftSidebar,
		WelcomeScreen,
	},

	computed: {
		// The title to display at the top of the page
		currentAppID() {
			return this.$route.params.appid
		},
	},

	beforeMount() {
		store.loadApps()
	},

	methods: {
		generateUrl,
	},
}
</script>
