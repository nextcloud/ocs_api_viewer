<template>
	<!--
	SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
	SPDX-License-Identifier: AGPL-3.0-or-later
	-->
	<NcContent app-name="ocs_api_viewer">
		<NcAppNavigation>
			<template #list>
				<NcAppNavigationItem v-for="appID in appIDs"
					:key="appID"
					:name="appID"
					:class="{active: currentAppID === appID}"
					@click="openApp(appID)" />
			</template>
		</NcAppNavigation>
		<NcAppContent>
			<div v-if="currentAppID" style="height: 100%">
				<SwaggerUI :key="currentAppID" :appid="currentAppID" :openapi="generateUrl(`/apps/ocs_api_viewer/apps/${currentAppID}`)" />
			</div>
			<div v-else>
				<NcEmptyContent :name="t('ocs_api_viewer', 'Select an app to get started')" />
			</div>
		</NcAppContent>
	</NcContent>
</template>

<script>
import NcAppContent from '@nextcloud/vue/dist/Components/NcAppContent.js'
import NcAppNavigation from '@nextcloud/vue/dist/Components/NcAppNavigation.js'
import NcAppNavigationItem from '@nextcloud/vue/dist/Components/NcAppNavigationItem.js'
import NcContent from '@nextcloud/vue/dist/Components/NcContent.js'
import NcEmptyContent from '@nextcloud/vue/dist/Components/NcEmptyContent.js'
import { generateUrl } from '@nextcloud/router'
import { showError } from '@nextcloud/dialogs'
import axios from '@nextcloud/axios'
import SwaggerUI from './SwaggerUI.vue'

export default {
	name: 'App',
	components: {
		NcAppContent,
		NcAppNavigation,
		NcAppNavigationItem,
		NcContent,
		NcEmptyContent,
		SwaggerUI,
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
