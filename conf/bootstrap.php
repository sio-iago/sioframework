<?php

// Slim Configurations
$app->config('debug',TRUE);

$app->container->singleton('modules', function() {
// Modules Manager (Loads the modules of our application and MUST BE THE FIRST)
    return require_once __dir__ . '/modules.php';
});

// Session Manager (Session Manager, optional)
require_once __DIR__ . '/session.php';

// Routing manager
// Scans for each src/Module/conf/routes.php and configures the routes
require_once __DIR__ . '/routing.php';

// View Manager (Configures twig views)
require_once __DIR__ . '/view.php';

// File Manager (File Manager, optional)
require_once __DIR__ . '/filemanager.php';

// Database Manager (Database Manager, optional)
require_once __DIR__ . '/database.php';
