<!--
  - SPDX-FileCopyrightText: 2024 Sebastien Marinier <seb@smarinier.net>
  - SPDX-License-Identifier: AGPL-3.0-or-later
-->
<template>
	<div id="swagger-ui" />
</template>
<script>
import JSSwaggerUI from 'swagger-ui'

const DisableAuthorizePlugin = function() {
	return {
		wrapComponents: {
			authorizeBtn: () => () => null,
		},
	}
}
export default {
	name: 'SwaggerUI',
	props: {
		appid: { type: String, default: '' },
		openapi: { type: String, default: '' },
	},
	mounted() {
		JSSwaggerUI({
			url: this.openapi,
			dom_id: '#swagger-ui',
			presets: [
				JSSwaggerUI.presets.apis,
			],
			plugins: [
				DisableAuthorizePlugin,
			],
			layout: 'BaseLayout',
		})
	},
}
</script>
