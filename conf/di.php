<?php

// Globals
$global_includes = require __DIR__ . '/global/includes.php';

foreach($global_includes as $key=>$instance)
{
	$app->container->singleton($key, function() use ($instance){ return $instance; });	
} 

// Module Specifics
$modules = $app->container->get('modules');

foreach($modules as $key => $dir)
{
	$moduleDir = $dir . '/conf';
	if(is_dir($moduleDir) && is_file($moduleDir . '/includes.php'))
	{
		$includes = require_once $moduleDir . '/includes.php';
		
		foreach($includes as $key=>$instance)
		{
			$app->container->singleton($key, function() use ($instance){ return $instance; });
		}
	}
}