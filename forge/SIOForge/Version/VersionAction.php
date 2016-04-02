<?php


namespace SIOForge\Version;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class VersionAction implements Action
{

    const VERSION = '1.0.alpha';

    public function performAction(Environment $environment, $args)
    {
        print "SIOForge version " . VersionAction::VERSION . "\n\n";
    }

}