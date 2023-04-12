// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later
const webpackConfig = require('@nextcloud/webpack-vue-config')
const ESLintPlugin = require('eslint-webpack-plugin')
const StyleLintPlugin = require('stylelint-webpack-plugin')
const CopyPlugin = require('copy-webpack-plugin')
const path = require('path');

const buildMode = process.env.NODE_ENV
const isDev = buildMode === 'development'
webpackConfig.devtool = isDev ? 'cheap-source-map' : 'source-map'

webpackConfig.stats = {
	colors: true,
	modules: false,
}

const appId = 'ocs_api_viewer'
webpackConfig.entry = {
	main: { import: path.join(__dirname, 'src', 'main.js'), filename: appId + '-main.js' },
	'iframe-theme': { import: path.join(__dirname, 'src', 'iframe-theme.js'), filename: appId + '-iframe-theme.js' },
}

webpackConfig.plugins.push(
	new ESLintPlugin({
		extensions: ['js', 'vue'],
		files: 'src',
		failOnError: !isDev,
	})
)
webpackConfig.plugins.push(
	new StyleLintPlugin({
		files: 'src/**/*.{css,scss,vue}',
		failOnError: !isDev,
	}),
)
webpackConfig.plugins.push(
	new CopyPlugin({
		patterns: [
			{ from: 'node_modules/@stoplight/elements/web-components.min.js', to: 'stoplight-elements.js' },
			{ from: 'node_modules/@stoplight/elements/styles.min.css', to: 'stoplight-elements.css' },
		],
	}),
)

module.exports = webpackConfig
