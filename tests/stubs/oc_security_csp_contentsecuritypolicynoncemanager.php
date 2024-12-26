<?php

/**
 * SPDX-FileCopyrightText: 2023 Joas Schilling <coding@schilljs.com>
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OC\Security\CSP;

class ContentSecurityPolicyNonceManager {
	/**
	 * Returns the current CSP nonce
	 */
	public function getNonce(): string {
	}

	/**
	 * Check if the browser supports CSP v3
	 */
	public function browserSupportsCspV3(): bool {
	}
}
