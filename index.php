<?php

ini_set('display_errors', TRUE);

require 'vendor/autoload.php';

$app = new \Slim\Slim();

require 'conf/bootstrap.php';

$app->run();