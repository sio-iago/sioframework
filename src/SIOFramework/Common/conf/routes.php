<?php

// Not Found Template
$app->notFound(function() use ($app){
    $twig = $app->twig->loadTemplate('@Common/notfound.twig');

    echo $twig->render(array());
});
