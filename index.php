<?php
/**
 * All requests routed through here. This is an overview of what actaully happens during
 * a request.
 *
 * @package NexusCore
 */

// ---------------------------------------------------------------------------------------
//
// PHASE: BOOTSTRAP
//
define('NEXUS_INSTALL_PATH', dirname(__FILE__));
define('NEXUS_SITE_PATH', NEXUS_INSTALL_PATH . '/site');

require(NEXUS_INSTALL_PATH.'/src/bootstrap.php');

$nx = CNexus::Instance();


// ---------------------------------------------------------------------------------------
//
// PHASE: FRONTCONTROLLER ROUTE
//
$nx->FrontControllerRoute();


// ---------------------------------------------------------------------------------------
//
// PHASE: THEME ENGINE RENDER
//
$nx->ThemeEngineRender();
