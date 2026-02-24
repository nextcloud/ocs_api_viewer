<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcAppNavigation>
		<NcAppNavigationCaption heading-id="nextcloud-api-heading"
			:is-heading="true"
			:name="t('ocs_api_viewer', 'Nextcloud APIs')" />
		<ApiNavigationList arialabel="nextcloud-api-heading"
			always-enabled />
		<NcAppNavigationCaption heading-id="installed-api-heading"
			:is-heading="true"
			:name="t('ocs_api_viewer', 'Application APIs')" />
		<ApiNavigationList arialabel="installed-api-heading"
			:always-enabled="false" />
	</NcAppNavigation>
</template>

<script>
import NcAppNavigation from '@nextcloud/vue/dist/Components/NcAppNavigation.js'
import NcAppNavigationCaption from '@nextcloud/vue/dist/Components/NcAppNavigationCaption.js'
import ApiNavigationList from './ApiNavigationList.vue'

export default {
	name: 'LeftSidebar',
	components: {
		NcAppNavigation,
		NcAppNavigationCaption,
		ApiNavigationList,
	},
}
</script>
