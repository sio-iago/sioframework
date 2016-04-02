<?php


namespace SIOForge\ModelForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class ModelForgeHelpAction implements Action
{
    public function performAction(Environment $environment, $args)
    {
        print "Usage: ".$args[0]." model MigrationName\n";
    }

}