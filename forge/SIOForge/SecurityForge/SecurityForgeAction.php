<?php


namespace SIOForge\SecurityForge;

use SIOForge\Core\Action;
use SIOForge\Core\Environment;
use SIOForge\Core\TwigRenderAction;

class SecurityForgeAction extends TwigRenderAction implements Action
{
    /**
     * @var array
     */
    protected $properties;


    protected function setProperties($args)
    {
        $this->properties = array(
            'module' => $args[2],
            'loginForward' => $args[3],
            'logoutForward' => $args[4],
        );
    }


    public function performAction(Environment $environment, $args)
    {
        $this->environment = $environment;

        if (sizeof($args) != 5) {
            (new SecurityForgeHelpAction())->performAction($environment, $args);
            return;
        }

        $this->setProperties($args);

        // Module check
        $modulePath = $environment->getModules()[$this->properties['module']];

        if(!is_dir($modulePath))
        {
            print "Error: Module does not exist\n";
            return;
        }

        $twig = $this->getTemplateEngine(__DIR__ . '/templates');


        // Checking if module contains routes.php and creating if doesn't
        $moduleConfPath = $modulePath .'/conf';

        if(is_dir($moduleConfPath)) {
            print "Error: Module does not exist\n";
            return;
        }

        print "Creating module conf directory [$moduleConfPath]\n";
        mkdir($moduleConfPath);

        print "Creating conf/routes.php\n";

        $routesFile = fopen($moduleConfPath.'/routes.php','w');
        $routesTemplate = $twig->loadTemplate('routes.php.twig');

        fwrite($routesFile,$routesTemplate->render($this->properties));
        fclose($routesFile);

    }


}