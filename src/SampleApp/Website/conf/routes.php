<?php

// Welcome Template
$app->get('/',function() use ($app){
    $twig = $app->container->get('twig')->loadTemplate('default/index.twig');

    echo $twig->render(array());
})->name('welcome');
