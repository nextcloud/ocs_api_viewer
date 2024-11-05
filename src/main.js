/**
 * SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateFilePath } from '@nextcloud/router'

import Vue from 'vue'
import App from './App.vue'
import 'swagger-ui/dist/swagger-ui.css'

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

Vue.mixin({ methods: { t, n } })

export default new Vue({
	el: '#content',
	render: h => h(App),
})
