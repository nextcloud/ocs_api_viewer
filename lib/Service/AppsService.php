<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\OCSAPIViewer\Service;

use OC;
use OCP\App\AppPathNotFoundException;
use OCP\App\IAppManager;

class AppsService {

	public function __construct(private IAppManager $appManager) {
	}

	/**
	 * @return string[]
	 */
	public function findSupported(): array {
		$apis = [];

		foreach ($this->appManager->getInstalledApps() as $app) {
			try {
				$baseDir = $this->appManager->getAppPath($app);
				$iterator = new \DirectoryIterator($baseDir);
				foreach ($iterator as $file) {
					if ($file->getFilename() == 'openapi.json') {
						$apis[] = $app;
					} else if (str_starts_with($file->getFilename(), 'openapi-') && str_ends_with($file->getFilename(), '.json')) {
						$apis[] = $app . '-' . substr($file->getFilename(), 8, -5);
					}
				}
			} catch (AppPathNotFoundException) {
			}
		}

		sort($apis);

		array_unshift($apis, 'core');

		return $apis;
	}

	private function getSpecPath(string $app): ?string {
		$scopeSuffix = '';
		if ($app === 'core') {
			$baseDir = OC::$SERVERROOT . DIRECTORY_SEPARATOR . "core";
		} else {
			try {
				if (str_contains($app, '-')) {
					[$app, $scope] = explode('-', $app, 2);
					$scopeSuffix = '-' . $scope;
				}
				$baseDir = $this->appManager->getAppPath($app);
			} catch (AppPathNotFoundException $e) {
				return null;
			}
		}

		return $baseDir . DIRECTORY_SEPARATOR . "openapi$scopeSuffix.json";
	}

	public function getSpec(string $app): string {
		$data = json_decode(file_get_contents($this->getSpecPath($app)), true);

		// Only give basic authentication as an option
		$data["components"]["securitySchemes"] = [
			"basic_auth" => [
				"type" => "http",
				"scheme" => "basic",
			],
		];
		$data["security"] = [
			[
				"basic_auth" => [],
			],
		];
		// Delete individual security requirements
		foreach (array_keys($data["paths"]) as $path) {
			foreach (array_keys($data["paths"][$path]) as $method) {
				if (!in_array($method, ["delete", "get", "post", "put", "patch", "options"])) {
					continue;
				}
				$operation = &$data["paths"][$path][$method];
				unset($operation["security"]);
			}
		}

		return json_encode($data);
	}
}
