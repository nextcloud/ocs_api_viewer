<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\OCSAPIViewer\Service;

use OC;
use OCP\App\AppPathNotFoundException;
use OCP\App\IAppManager;
use OCP\IURLGenerator;

class AppsService {

	public function __construct(
		private IAppManager $appManager,
		private IURLGenerator $url,
	) {
	}

	/**
	 * @return array[]
	 */
	public function findSupported(): array {
		$apis = [];

		$always = $this->appManager->getAlwaysEnabledApps();
		foreach ($this->appManager->getInstalledApps() as $app) {
			if (!$this->appManager->isEnabledForUser($app)) {
				continue;
			}
			$appSpecs = [];
			try {
				$baseDir = $this->appManager->getAppPath($app);
				$iterator = new \DirectoryIterator($baseDir);
				foreach ($iterator as $file) {
					if ($file->getFilename() == 'openapi.json') {
						$appSpecs[] = $app;
					} else if (str_starts_with($file->getFilename(), 'openapi-') && str_ends_with($file->getFilename(), '.json')) {
						$appSpecs[] = $app . '-' . substr($file->getFilename(), 8, -5);
					}
				}
			} catch (AppPathNotFoundException) {
			}
			if ($appSpecs !== []) {
				$appInfo = $this->appManager->getAppInfo($app);
				$apiInfo = [
					'id' => $app,
					'specs' => $appSpecs,
					'name' => $appInfo['name'],
					'version' => $appInfo['version'],
					'always_enabled' => in_array($app, $always),
				];
				$iconUrl = $this->appManager->getAppIcon($app);
				if ($iconUrl !== null) {
					$apiInfo['icon_url'] = $iconUrl;
				}
				$apis[] = $apiInfo;
			}
		}

		/** @psalm-suppress UndefinedClass */
		if (file_exists(OC::$SERVERROOT . '/core/openapi.json')) {
			array_unshift($apis, [
				'id' => 'core',
				'specs' => ['core'],
				'name' => 'Core Nextcloud API',
				'version' => implode('.', \OCP\Util::getVersion()),
				'always_enabled' => true,
				'icon_url' => $this->url->imagePath('core', 'logo/logo.svg')
			]);
		}

		return $apis;
	}

	private function getSpecPath(string $app): ?string {
		$scopeSuffix = '';
		if ($app === 'core') {
			/** @psalm-suppress UndefinedClass */
			$baseDir = OC::$SERVERROOT . DIRECTORY_SEPARATOR . 'core';
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
		$data['components']['securitySchemes'] = [
			'basic_auth' => [
				'type' => 'http',
				'scheme' => 'basic',
			],
		];
		$data['security'] = [
			[
				'basic_auth' => [],
			],
		];
		// Delete individual security requirements
		foreach (array_keys($data['paths']) as $path) {
			foreach (array_keys($data['paths'][$path]) as $method) {
				if (!in_array($method, ['delete', 'get', 'post', 'put', 'patch', 'options'])) {
					continue;
				}
				$operation = &$data['paths'][$path][$method];
				unset($operation['security']);
			}
		}
		// fix paths when NC is accessed at a sub path
		$webRoot = $this->url->getWebroot();
		if ($webRoot !== '' && $webRoot !== '/') {
			foreach (array_keys($data['paths']) as $path) {
				$prefixedPath = $webRoot . $path;
				$data['paths'][$prefixedPath] = $data['paths'][$path];
				unset($data['paths'][$path]);
			}
		}

		return json_encode($data, JSON_THROW_ON_ERROR);
	}
}
