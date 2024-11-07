<template>
	<NcAppNavigationList :aria-labelledby="arialabel">
		<NcAppNavigationItem v-for="app in apps"
			:key="app.id"
			allow-collapse
			:name="app.name"
			:open="isSelectedChild($route.params.appid, app)"
			:to="{path: `/view/${app.id}`}">
			<template #icon>
				<AppIcon v-if="app.preview"
					:href="app.preview" />
				<ApiIcon v-else />
			</template>
			<NcAppNavigationItem v-for="child in childApis(app)"
				:key="child.id"
				:name="child.name"
				:to="{path: `/view/${child.id}`}" />
		</NcAppNavigationItem>
	</NcAppNavigationList>
</template>

<script>
import NcAppNavigationList from '@nextcloud/vue/dist/Components/NcAppNavigationList.js'
import NcAppNavigationItem from '@nextcloud/vue/dist/Components/NcAppNavigationItem.js'
import AppIcon from './AppIcon.vue'
import ApiIcon from 'vue-material-design-icons/Api.vue'
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
		standard: { type: Boolean, default: false },
		arialabel: { type: String, default: '' },
	},
	computed: {
		apps() {
			const apps = store.apps
				.filter(app => app.standard === this.standard)
				.sort(function(a, b) {
					// core nextcloud always first
					if (a.id === 'core') return -1
					if (b.id === 'core') return 1
					return OC.Util.naturalSortCompare(a.name, b.name)
				})
			return apps
		},
	},
	methods: {
		isSelectedChild(appId, app) {
			if (appId === app.id) {
				return false
			}
			return app.apis.indexOf(appId) >= 0
		},
		childApis(app) {
			if (app.apis === undefined || app.apis.length === 1) {
				return []
			}
			return app.apis.filter(id => id !== app.id)
				.map(cid => ({ id: cid, name: cid }))
		},
	},
}
</script>
