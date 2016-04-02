<?php


namespace SIOForge\ScaffoldForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class ScaffoldForgeHelpAction implements Action
{
    public function performAction(Environment $environment, $args)
    {
        print "Usage: ".$args[0]." MigrationName\n";
    }

}