<?php

ini_set('display_errors', TRUE);

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\Slim();

require __DIR__ . '/../conf/bootstrap.php';

$app->run();