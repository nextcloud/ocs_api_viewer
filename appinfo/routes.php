<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

return [
	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'apps#index', 'url' => '/apps', 'verb' => 'GET'],
		['name' => 'apps#load', 'url' => '/apps/{app}', 'verb' => 'GET'],
		// The following route is there to prevent redirection to NC's general homepage
		// when reloading a page in the application (If we don't add it all pages that
		// don't have a route registered here redirect to NC's general homepage upon refresh)
		[
			'name' => 'page#index',
			'url' => '/{path}',
			'verb' => 'GET',
			'requirements' => ['path' => '.*'],
			'defaults' => ['path' => 'dummy'],
			'postfix' => 'catchall',
		]
	],
];
