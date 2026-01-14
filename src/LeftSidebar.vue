<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<NcAppNavigation :aria-label="t('ocs_api_viewer', 'Apis')">
		<NcAppNavigationCaption heading-id="nextcloud-api-heading"
			:is-heading="true"
			:name="t('ocs_api_viewer', 'Nextcloud Apis')" />
		<ApiNavigationList arialabel="nextcloud-api-heading"
			always-enabled />
		<NcAppNavigationCaption heading-id="installed-api-heading"
			:is-heading="true"
			:name="t('ocs_api_viewer', 'Application Apis')" />
		<ApiNavigationList arialabel="installed-api-heading"
			:always-enabled="false" />
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
