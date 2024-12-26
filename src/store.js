/**
 * SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { defineStore, PiniaVuePlugin, setActivePinia, createPinia } from 'pinia'
import axios from '@nextcloud/axios'
import { showError } from '@nextcloud/dialogs'
import { generateUrl } from '@nextcloud/router'
import Vue from 'vue'

const showApiError = () => showError(t('ocs_api_viewer', 'An error occurred during the request. Unable to proceed.'))

// use pinia
Vue.use(PiniaVuePlugin)
export const pinia = createPinia()
setActivePinia(pinia)

export const useAppsStore = defineStore('ocs-api-viewer-apps', {
	state: () => ({
		loading: true,
		apps: [],
		appOpened: [],
	}),

	actions: {

		async loadApps() {
			if (this.apps.length > 0) {
				return
			}

			try {
				this.loading = true
				const { data } = await axios.get(generateUrl('/apps/ocs_api_viewer/apps'))

				this.$patch({
					apps: data,
				})
			} catch (error) {
				showApiError()
			} finally {
				this.loading = false
			}
		},

		getAppById(appId) {
			return this.apps.find(({ id }) => id === appId) ?? null
		},
		isAppOpened(appId) {
			return this.appOpened[appId] ?? false
		},
		appOpen(appId, open) {
			this.appOpened[appId] = open
		},
	},
})
