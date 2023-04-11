<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Kate Döen <kate.doeen@nextcloud.com>
// SPDX-License-Identifier: AGPL-3.0-or-later
?>
<html>
<head>
	<script src="/apps/ocs_api_viewer/js/stoplight-elements.js"></script>
	<link rel="stylesheet" href="/apps/ocs_api_viewer/js/stoplight-elements.css">
</head>
<body>
	<div style="background-color: white">
		<elements-api apiDescriptionUrl="../apps/<?php p($_['app']); ?>" logo="/apps/ocs_api_viewer/img/app-color.svg" router="hash" hideExport="true" />
	</div>
</body>
</html>
