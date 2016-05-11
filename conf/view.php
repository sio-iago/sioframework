<?php

$basedir = __DIR__ . '/../views';

$container = $app->container;

// Add a Twig service to the container.
$container['twig'] = function() use ($app, $basedir) {

    $loader = new Twig_Loader_Filesystem(array());

    // Get entities in each module
    $modules = $app->container->get('modules');

    foreach ($modules as $key => $module)
    {
        $dir = $module . '/views';

        if(is_dir($dir))
            $loader->addPath($dir, $key);

    }


    $twig = new Twig_Environment($loader, array('cache'));

    $twig->addGlobal('app',$app);
    $twig->addGlobal('resources', $app->request->getUrl() . $app->request->getRootUri() . '/resources');
    $twig->addGlobal('public_data', $app->request->getUrl() . $app->request->getRootUri() . '/public_data');



    return $twig;
};