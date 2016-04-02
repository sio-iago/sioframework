<?php

require_once 'vendor/autoload.php';

use \Doctrine\ORM\Tools\Console\ConsoleRunner;

// Loads the Slim app
$app = new \Slim\Slim();

// Loads configurations
require 'conf/bootstrap.php';

// Returns the EntityManager for console running
return ConsoleRunner::createHelperSet($app->container->get('orm'));
