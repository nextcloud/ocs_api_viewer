/**
 * SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import axios from '@nextcloud/axios'
import { showError } from '@nextcloud/dialogs'
import { getLoggerBuilder } from '@nextcloud/logger'
import { generateUrl } from '@nextcloud/router'
import { createPinia, defineStore, setActivePinia } from 'pinia'

const logger = getLoggerBuilder()
	.setApp('ocs_api_viewer')
	.detectUser()
	.build()

export const pinia = createPinia()
setActivePinia(pinia)

export const useAppsStore = defineStore('ocs-api-viewer-apps', {
	state: () => ({
		apps: [],
		appOpened: [],
	}),
	actions: {
		async loadApps() {
			if (this.apps.length > 0) {
				return
			}

			try {
				const { data } = await axios.get(generateUrl('/apps/ocs_api_viewer/apps'))

				this.$patch({
					apps: data,
				})
			} catch (error) {
				logger.error(error)
				showError(t('ocs_api_viewer', 'An error occurred during the request. Unable to proceed.'))
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
