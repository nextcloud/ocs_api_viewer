/**
 * SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

import { generateUrl } from '@nextcloud/router'
import { createRouter, createWebHistory } from 'vue-router'
import App from './App.vue'
import SwaggerUI from './SwaggerUI.vue'
import WelcomeScreen from './WelcomeScreen.vue'

export default createRouter({
	history: createWebHistory(generateUrl('/apps/ocs_api_viewer/')),
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
			component: App,
			children: [
				{
					path: '',
					component: WelcomeScreen,
				},
				{
					path: 'view/:appid',
					component: SwaggerUI,
				},
			],
		},
	],
})
