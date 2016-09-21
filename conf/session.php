<?php

// Session Configuration
$app->container->singleton('session', function(){

    $session_factory = new \Aura\Session\SessionFactory();
    $session = $session_factory->newInstance($_COOKIE);

    $session->setName('sioframework-session-manager');
    $session->setCookieParams(array('lifetime' => '28800')); // 6 hours

    return $session;
});

$app->container->singleton('root_segment', function() use ($app) {
    return $app->container->get('session')->getSegment('Member');
});