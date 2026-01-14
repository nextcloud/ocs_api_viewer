<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcAppNavigationList :aria-labelledby="arialabel">
		<NcAppNavigationItem v-for="app in apps"
			:key="app.id"
			allow-collapse
			:name="app.name"
			:open="isSelectedChild($route.params.appid, app) || isManuallyOpened(app.id)"
			:to="{ path: `/view/${app.id}` }"
			@update:open="(open) => onOpen(app.id, open)">
			<template #icon>
				<AppIcon v-if="app.icon_url"
					:href="app.icon_url" />
				<ApiIcon v-else />
			</template>
			<NcAppNavigationItem v-for="child in childApis(app)"
				:key="child.id"
				:name="child.name"
				:to="{ path: `/view/${child.id}` }">
				<template #icon>
					<AppIcon v-if="app.icon_url"
						:size="16"
						:href="app.icon_url" />
					<ApiIcon v-else
						:size="16" />
				</template>
			</NcAppNavigationItem>
		</NcAppNavigationItem>
	</NcAppNavigationList>
</template>

<script>
import { NcAppNavigationItem, NcAppNavigationList } from '@nextcloud/vue'
import ApiIcon from 'vue-material-design-icons/Api.vue'
import AppIcon from './AppIcon.vue'
import { useAppsStore } from './store.js'

const store = useAppsStore()

export default {
	name: 'ApiNavigationList',
	components: {
		NcAppNavigationList,
		NcAppNavigationItem,
		AppIcon,
		ApiIcon,
	},

	props: {
		alwaysEnabled: { type: Boolean, default: false },
		arialabel: { type: String, default: '' },
	},

	computed: {
		apps() {
			return store.apps
				.filter((app) => app.always_enabled === this.alwaysEnabled)
				.sort(function(a, b) {
					// core nextcloud always first
					if (a.id === 'core') {
						return -1
					}
					if (b.id === 'core') {
						return 1
					}
					return OC.Util.naturalSortCompare(a.name, b.name)
				})
		},
	},

	methods: {
		isSelectedChild(appId, app) {
			if (appId === app.id) {
				return false
			}
			return app.specs.indexOf(appId) >= 0
		},

		childApis(app) {
			if (app.specs === undefined || app.specs.length === 1) {
				return []
			}
			return app.specs
				.filter((id) => id !== app.id)
				.map((cid) => ({ id: cid, name: cid }))
		},

		isManuallyOpened(appId) {
			return store.isAppOpened(appId)
		},

		onOpen(appId, open) {
			store.appOpen(appId, open)
		},
	},
}
</script>
