<?php


namespace SIOForge\ModuleForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class ModuleForgeHelpAction implements Action
{
    public function performAction(Environment $environment, $args)
    {
        print "Usage: ".$args[0]." module ModuleName ModuleNamespace [scaffold]\n";
    }

}