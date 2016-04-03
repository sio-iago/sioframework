<?php

// Default route from scaffolding
// Feel free to change it.

$app->get('/SampleAppLogin/login',function() use ($app){

(new SIOFramework\Acl\Controller\AccessController(
    $app, new \SIOFramework\Common\Factory\StandardFactory($app)
))->login('welcome');

})->via('GET','POST')->name('SampleAppLogin-login');

$app->get('/SampleAppLogin/logout',function() use ($app){

(new SIOFramework\Acl\Controller\AccessController(
    $app, new \SIOFramework\Common\Factory\StandardFactory($app)
))->logout('welcome');

})->via('GET','POST')->name('SampleAppLogin-logout');
