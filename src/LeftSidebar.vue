<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcAppNavigation :aria-label="t('ocs_api_viewer', 'Apis')">
		<NcAppNavigationCaption headingId="nextcloud-api-heading"
			:isHeading="true"
			:name="t('ocs_api_viewer', 'Nextcloud APIs')" />
		<ApiNavigationList arialabel="nextcloud-api-heading"
			alwaysEnabled />
		<NcAppNavigationCaption headingId="installed-api-heading"
			:isHeading="true"
			:name="t('ocs_api_viewer', 'Application APIs')" />
		<ApiNavigationList arialabel="installed-api-heading"
			:alwaysEnabled="false" />
	</NcAppNavigation>
</template>

<script>
import { t } from '@nextcloud/l10n'
import { NcAppNavigation, NcAppNavigationCaption } from '@nextcloud/vue'
import ApiNavigationList from './ApiNavigationList.vue'

export default {
	name: 'LeftSidebar',
	components: {
		NcAppNavigation,
		NcAppNavigationCaption,
		ApiNavigationList,
	},

	methods: { t },
}
</script>
