<?php


namespace SIOForge\ScaffoldForge;


use SIOForge\Core\Action;
use SIOForge\Core\Environment;
use SIOForge\Core\TwigRenderAction;
use SIOForge\ModelForge\MetaEntity;

class ScaffoldForgeAction extends TwigRenderAction implements Action
{
    /**
     * Sanitizes the module string.
     *
     * @param $module string
     * @return string
     */
    protected function getBaseModule($module)
    {
        $moduleNamespace = $module;

        $moduleNamespace = str_replace('\Model','',$moduleNamespace);

        return $moduleNamespace;
    }

    protected function getOperationName(MetaEntity $metaEntity, $name)
    {
        return $metaEntity->getModule() . '-'. $metaEntity->getName() . '-' . $name;
    }


    public function performAction(Environment $environment, $args)
    {
        if(sizeof($args)!=3)
        {
            (new ScaffoldForgeHelpAction())->performAction($environment,$args);
            return;
        }

        // Migration configurations
        $migrationsDir = $environment->getBaseDir() . '/migrations';

        if (!is_dir($migrationsDir)) {
            print "Error: Migrations directory does not exist.\n\n";
            return;
        }

        $migrationPath = $migrationsDir . '/' . $args[2] . '.php';

        if (!file_exists($migrationPath))
        {
            print "Error: migration does not exist\n";
            print "Please verify your migration name.\n\n";
            return;
        }

        $metaEntity = new MetaEntity(require $migrationPath);

        // Module check
        $modulePath = $environment->getModules()[$metaEntity->getModule()];

        if(!is_dir($modulePath))
        {
            print "Error: Module does not exist\n";
            return;
        }

        // Views Configuration
        $moduleViewsDir = $modulePath . '/views';
        $migrationViewsDir = $moduleViewsDir . '/' . $metaEntity->getName();

        if(!is_dir($moduleViewsDir))
        {
            print "Creating new views directory for module ["
                .$metaEntity->getModule()."]\n\n";

            mkdir($moduleViewsDir);
        }

        if(is_dir($migrationViewsDir))
        {
            print "Error: Cannot override directory.\n\n";
            return;
        }

        print "Creating views directory for " . $metaEntity->getName() . "\n\n";
        mkdir($migrationViewsDir);


        // Templates
        $data = array(
            'model' => $metaEntity,
            'module' => $metaEntity->getModule(),
            'package' => $this->getBaseModule($metaEntity->getPackage()),
        );

        $twig = $this->getTemplateEngine(__DIR__ . '/templates');


        // Checking if module contains routes.php and creating if doesn't
        $moduleConfPath = $modulePath .'/conf';
        $routesGenerated = FALSE;

        if(!is_dir($moduleConfPath))
        {
            print "Creating module conf directory [$moduleConfPath]\n";
            mkdir($moduleConfPath);

            // routes.php.twig rendering
            $data['list_name'] = $this->getOperationName($metaEntity,'List');
            $data['create_name'] = $this->getOperationName($metaEntity,'Create');
            $data['edit_name'] = $this->getOperationName($metaEntity,'Edit');
            $data['delete_name'] = $this->getOperationName($metaEntity,'Delete');

            print "Creating conf/routes.php\n";

            $routesFile = fopen($moduleConfPath.'/routes.php','w');
            $routesTemplate = $twig->loadTemplate('routes.php.twig');

            fwrite($routesFile,$routesTemplate->render($data));
            fclose($routesFile);

            $routesGenerated = TRUE;
        }


        // Controller.php
        print "Creating controller for ".$metaEntity->getName()."\n";

        $controllerDir = $modulePath . '/Controller';

        if(!is_dir($controllerDir))
        {
            print "Creating controller directory [$controllerDir]";
            mkdir($controllerDir);
        }

        $controllerPath = $controllerDir .'/' . $metaEntity->getName() . 'Controller.php';

        if(file_exists($controllerPath))
        {
            print "Error: Cannot override controller\n\n";
            return;
        }

        print "Creating Controller ".$metaEntity->getName()."Controller\n";
        $controllerTemplate = $twig->loadTemplate('controller.php.twig');
        $controllerFile = fopen($controllerPath ,'w');

        fwrite($controllerFile,$controllerTemplate->render($data));
        fclose($controllerFile);


        // Rendering views
        if($routesGenerated)
        {
            $data['listUrl'] = "{{ app.urlFor('".$data['list_name']."') }}";
            $data['createUrl'] = "{{ app.urlFor('".$data['create_name']."') }}";
            $data['editUrl'] = "{{ app.urlFor('".$data['edit_name']."'"
                . ", {'id':obj.getId()}) }}";

            $data['deleteUrl'] = "{{ app.urlFor('".$data['delete_name']."'"
                . ", {'id':obj.getId()}) }}";
        }


        // list.twig.twig
        print "Creating list view for ".$metaEntity->getName()."\n";
        $listTemplate = $twig->loadTemplate('list.twig.twig');
        $listFile = fopen($migrationViewsDir.'/list.twig','w');

        fwrite($listFile,$listTemplate->render($data));
        fclose($listFile);

        // edit.twig.twig
        print "Creating edit view for ".$metaEntity->getName()."\n";
        $listTemplate = $twig->loadTemplate('edit.twig.twig');
        $listFile = fopen($migrationViewsDir.'/edit.twig','w');

        fwrite($listFile,$listTemplate->render($data));
        fclose($listFile);

    }


}