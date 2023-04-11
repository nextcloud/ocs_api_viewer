<template>
	<!--
	SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
	SPDX-License-Identifier: AGPL-3.0-or-later
	-->
	<div id="content" class="app-ocs_api_viewer">
		<AppNavigation>
			<template #list>
				<AppNavigationItem v-for="appID in appIDs"
					:key="appID"
					:title="appID"
					:class="{active: currentAppID === appID}"
					@click="openApp(appID)" />
			</template>
		</AppNavigation>
		<AppContent>
			<div v-if="currentAppID" style="height: 100%">
				<iframe height="100%" width="100%" :src="generateUrl(`/apps/ocs_api_viewer/view/${currentAppID}`)" />
			</div>
			<div v-if="!currentAppID">
				<EmptyContent>
					<p>{{ t('ocs_api_viewer', 'Select an app to get started') }}</p>
				</EmptyContent>
			</div>
		</AppContent>
	</div>
</template>

<script>
import AppContent from '@nextcloud/vue/dist/Components/AppContent.js'
import AppNavigation from '@nextcloud/vue/dist/Components/AppNavigation.js'
import AppNavigationItem from '@nextcloud/vue/dist/Components/AppNavigationItem.js'
import EmptyContent from '@nextcloud/vue/dist/Components/EmptyContent.js'
import '@nextcloud/dialogs/styles/toast.scss'
import { generateUrl } from '@nextcloud/router'
import { showError } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'

export default {
	name: 'App',
	components: {
		AppContent,
		AppNavigation,
		AppNavigationItem,
		EmptyContent,
	},
	data() {
		return {
			appIDs: [],
			currentAppID: null,
		}
	},
	async mounted() {
		try {
			const response = await axios.get(generateUrl('/apps/ocs_api_viewer/apps'))
			this.appIDs = response.data
		} catch (e) {
			console.error(e)
			showError(t('ocs_api_viewer', 'Could not fetch apps'))
		}
	},
	methods: {
		generateUrl,
		openApp(appID) {
			this.currentAppID = appID
		},
	},
}
</script>
