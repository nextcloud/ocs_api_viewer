<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later
?>
<html<?php echo $_['theme'] == 'dark' ? ' data-theme="dark"' : ($_['theme'] == 'light' ? ' data-theme="light"' : ''); ?>>
<head>
	<script src="<?php echo $_['viewer-root']; ?>/js/stoplight-elements.js"></script>
	<link rel="stylesheet" href="<?php echo $_['viewer-root']; ?>/js/stoplight-elements.css">
	<?php if ($_['theme'] == 'system') echo('<script src="' . $_['viewer-root'] . '/js/ocs_api_viewer-iframe-theme.js"></script>'); ?>
</head>
<body>
	<div style="background-color: var(--color-canvas);">
		<elements-api apiDescriptionUrl="../apps/<?php p($_['app']); ?>" logo="<?php echo $_['viewer-root']; ?>/img/app-color.svg" router="hash" hideExport="true" />
	</div>
</body>
</html>
