<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

return [
	'routes' => [
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'apps#index', 'url' => '/apps', 'verb' => 'GET'],
		['name' => 'apps#load', 'url' => '/apps/{app}', 'verb' => 'GET'],
		['name' => 'page#view', 'url' => '/view/{app}', 'verb' => 'GET'], // handled by Vue router
	],
];
