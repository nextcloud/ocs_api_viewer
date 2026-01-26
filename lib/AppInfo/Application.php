<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\OCSAPIViewer\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'ocs_api_viewer';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
