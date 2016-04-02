<?php


namespace SIOForge\ModuleForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;
use SIOForge\Core\TwigRenderAction;

class ModuleForgeAction extends TwigRenderAction implements Action
{
    /**
     * Sanitizes the module string.
     *
     * @param $module string
     * @return string
     */
    protected function sanitize($module,$namespace=TRUE)
    {
        $moduleNamespace = $module;
        $moduleLen = strlen($moduleNamespace);

        if($moduleNamespace[$moduleLen-1] == '/')
            $moduleNamespace = substr($moduleNamespace,0,$moduleLen-1);

        if($namespace)
            $moduleNamespace = str_replace('/','\\',$moduleNamespace);

        return $moduleNamespace;
    }

    /**
     * Verifies if the module exists
     *
     * @param $env Environment
     * @param $name string
     * @param $folder string
     * @return bool
     */
    protected function moduleExists(Environment $environment, $name, $folder)
    {
        return (array_key_exists($name,$environment->getModules())
            || is_dir($environment->getBaseDir() .'/src/'.$folder));
    }



    public function performAction(Environment $environment, $args)
    {
        if(sizeof($args)<4)
        {
            (new ModuleForgeHelpAction())->performAction($environment,$args);
            return;
        }

        if($this->moduleExists($environment, $args[2],$args[3]))
        {
            print "Error: Module Exists\n";
        }
        else
        {
            // Getting the template engine and configuring
            $twig = $this->getTemplateEngine(__DIR__ . '/templates');
            $data = array(
                'module' => $this->sanitize($args[3]),
                'moduleName' => $args[2],
            );

            $generateScaffold = FALSE;
            if(sizeof($args) == 5)
            {
                if($args[4] == 'scaffold')
                    $generateScaffold = TRUE;
            }

            // Module directory
            $moduleDir = $environment->getBaseDir() . '/src/' . $args[3];
            print "Creating module [$moduleDir]\n";
            mkdir($moduleDir);

            if($generateScaffold)
            {
                print "Scaffolding your module\n";

                // Controller directory
                $controllerDir = $moduleDir . '/Controller';
                mkdir($controllerDir);

                // Controller.php
                $controllerTemplate = $twig->loadTemplate('controller.php.twig');
                $controllerFile = fopen($controllerDir .'/' . $data['moduleName'] . 'Controller.php','w');

                fwrite($controllerFile,$controllerTemplate->render($data));
                fclose($controllerFile);

                // conf directory
                $confDir = $moduleDir . '/conf';
                mkdir($confDir);

                // routes.php
                $routesTemplate = $twig->loadTemplate('routes.php.twig');
                $routesFile = fopen($confDir .'/routes.php','w');

                fwrite($routesFile,$routesTemplate->render($data));
                fclose($routesFile);
            }


            // Information printing
            print "Module created!\n\n";

            if($generateScaffold)
            {
                print "To add this module to your app, go to "
                    . $environment->getBaseDir() . "/conf/modules.php " .
                    "and add the following line to the return array:\n\n";

                print "'" . $data['moduleName'] . "' => \$base . 'src/"
                    . $this->sanitize($args[3], FALSE) . "',\n\n";
            }

            print "Don't forget to add the new module to composer autoload file and "
                . "execute composer dump-autoloader\n\n";
        }
    }


}