<?php

// File Manager Configuration
$app->container->singleton('fileManager', function(){

    $folder = __DIR__ . '/../public_data';

    $fileManager = new SIOFramework\Common\FileManager\FileManager($folder, 2 * SIOFramework\Common\FileManager\FileManager::$_MB);
    return $fileManager;
});

$app->container->singleton('imageManager', function(){

    $folder = __DIR__ . '/../public_data';

    $fileManager = new SIOFramework\Common\FileManager\ImageFileManager($folder, 2 * SIOFramework\Common\FileManager\FileManager::$_MB);
    return $fileManager;
});
