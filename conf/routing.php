<?php

$modules = $app->container->get('modules');

foreach($modules as $key => $dir)
{
    $moduleDir = $dir . '/conf';
    if(is_dir($moduleDir) && is_file($moduleDir . '/routes.php'))
    {
        require_once $moduleDir . '/routes.php';
    }
}