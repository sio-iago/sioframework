<?php

$app->container->singleton('orm', function() use ($app) {
    // Get entities in each module
    $modules = $app->container->get('modules');

    $paths = array();

    foreach ($modules as $module)
    {
        $dir = $module . '/Model';
        if(is_dir($dir))
            $paths[] = $dir;

    }

    // Should run DevMode?
    $devMode = TRUE;

    // define credentials...
    $connectionOptions = array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'sio_framework',
        'user'     => 'root',
        'password' => 'root',
    );

    $config = \Doctrine\ORM\Tools\Setup::createConfiguration($devMode);
    $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
        new \Doctrine\Common\Annotations\AnnotationReader(), $paths
    );

    // registering no annotation autoloader - allow all annotations by default
    \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

    $config->setMetadataDriverImpl($driver);

    $em = NULL;
    try
    {
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
    }
    catch(\Exception $ex)
    {
        throw $ex;
    }

    return $em;

});