import Vue from 'vue'
import Router from 'vue-router'
import { generateUrl } from '@nextcloud/router'
import App from './App.vue'
import SwaggerUI from './SwaggerUI.vue'
import Welcome from './Welcome.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: generateUrl('/apps/ocs_api_viewer/'),
	linkActiveClass: 'active',
	routes: [
		{
			path: '/',
			component: resolve => resolve(App),
			children: [
				{
					path: '',
					component: Welcome,
				},
				{
					path: 'view/:appid',
					component: SwaggerUI,
				},
			],
		},
	],
})
