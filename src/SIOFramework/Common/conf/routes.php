<?php

// Not Found Template
$app->notFound(function() use ($app){
    $twig = $app->container->get('twig')->loadTemplate('default/notfound.twig');

    echo $twig->render(array());
});
