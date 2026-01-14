/**
 * SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
 * SPDX-FileCopyrightText: 2023 Kate Döen <kate.doeen@nextcloud.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateFilePath } from '@nextcloud/router'
import { createApp } from 'vue'
import MainView from './MainView.vue'
import router from './router.js'
import { pinia } from './store.js'

import 'swagger-ui/dist/swagger-ui.css'
import './swagger-theme-dark.scss'

// eslint-disable-next-line
__webpack_public_path__ = generateFilePath(appName, '', 'js/')

const app = createApp(MainView)
app.use(pinia)
app.use(router)
app.mount('#content')

export default app
