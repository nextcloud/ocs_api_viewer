/**
 * SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
 * SPDX-FileCopyrightText: 2023 Kate Döen <kate.doeen@nextcloud.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateFilePath } from '@nextcloud/router'

import Vue from 'vue'
import MainView from './MainView.vue'
import { useAppsStore, pinia } from './store.js'
import router from './router.js'
import 'swagger-ui/dist/swagger-ui.css'
import './swagger-theme-dark.scss'

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

Vue.mixin({ methods: { t, n } })

const store = useAppsStore()

export default new Vue({
	el: '#content',
	render: h => h(MainView),
	store,
	pinia,
	router,
})
