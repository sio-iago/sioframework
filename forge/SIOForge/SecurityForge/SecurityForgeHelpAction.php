<?php


namespace SIOForge\SecurityForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;

class SecurityForgeHelpAction implements Action
{
    public function performAction(Environment $environment, $args)
    {
        print "Usage: php forge.php security ModuleName loginForwardRouteName logoutForwardRouteName\n";
    }

}