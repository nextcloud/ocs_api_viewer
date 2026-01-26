<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\OCSAPIViewer\Controller;

use OCA\OCSAPIViewer\AppInfo\Application;
use OCA\OCSAPIViewer\Service\AppsService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataDisplayResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;

class AppsController extends Controller {
	private AppsService $service;

	public function __construct(
		IRequest $request,
		AppsService $service,
	) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
	}

	/**
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findSupported());
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function load(string $app): DataDisplayResponse {
		return new DataDisplayResponse($this->service->getSpec($app));
	}
}
