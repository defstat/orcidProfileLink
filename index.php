<?php

/**
 * @defgroup plugins_generic_orcidProfileLink
 */
 
/**
 * @file plugins/generic/orcidProfileLink/index.php
 *
 * Copyright (c) National Documentation Centre
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_orcidProfileLink
 * @brief Wrapper for ORCID Profile Link provider plugin.
 *
 */

require_once('OrcidProfileLinkPlugin.inc.php');

return new OrcidProfileLinkPlugin();

?>
