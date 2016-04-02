<?php


namespace SIOForge\ModelForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class MigrationForgeHelpAction implements Action
{
    public function performAction(Environment $environment, $args)
    {
        print "Usage: php forge.php migration MigrationName\n";
    }

}