<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\OCSAPIViewer\Controller;

use OC\Security\CSP\ContentSecurityPolicyNonceManager;
use OCA\OCSAPIViewer\AppInfo\Application;
use OCA\Theming\Service\ThemesService;
use OCP\App\IAppManager;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller {
	private ThemesService $themesService;
	private IAppManager $appManager;
	private ContentSecurityPolicyNonceManager $nonceManager;

	public function __construct(
		IRequest $request,
		ThemesService $themesService,
		IAppManager $appManager,
		ContentSecurityPolicyNonceManager $nonceManager
	) {
		$this->appManager = $appManager;
		$this->themesService = $themesService;
		$this->nonceManager = $nonceManager;
		parent::__construct(Application::APP_ID, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index(): TemplateResponse {
		Util::addScript(Application::APP_ID, Application::APP_ID . '-main');

		$response = new TemplateResponse(Application::APP_ID, 'main');
		$csp = new ContentSecurityPolicy();
		$csp->addAllowedFrameDomain("'self'");
		$response->setContentSecurityPolicy($csp);
		return $response;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function view(string $app): TemplateResponse {
		// We can't load the script and initial state here, because otherwise all the other scripts would load too

		$theme = 'system';
		$enabledThemes = array_map(fn(string $id) => explode('-', $id)[0], $this->themesService->getEnabledThemes());
		if (count(array_filter($enabledThemes, fn(string $id) => $id == 'dark')) > 0) {
			$theme = 'dark';
		} else if (count(array_filter($enabledThemes, fn(string $id) => $id == 'light')) > 0) {
			$theme = 'light';
		}

		$response = new TemplateResponse(Application::APP_ID, 'iframe', [
			'app' => $app,
			'viewer-root' => $this->appManager->getAppWebPath(Application::APP_ID),
			'theme' => $theme,
			'nonce' => $this->nonceManager->getNonce(),
		], TemplateResponse::RENDER_AS_BLANK);
		$csp = new ContentSecurityPolicy();
		$csp->addAllowedFrameAncestorDomain("'self'");
		$csp->addAllowedScriptDomain("'unsafe-eval'");
		$csp->addAllowedScriptDomain("'unsafe-inline'");
		$csp->addAllowedScriptDomain('*');
		$response->setContentSecurityPolicy($csp);
		return $response;
	}
}
