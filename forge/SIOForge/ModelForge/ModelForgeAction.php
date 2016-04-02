<?php


namespace SIOForge\ModelForge;

use SIOForge\Core\Action;
use SIOForge\Core\Environment;
use SIOForge\Core\TwigRenderAction;
use SIOForge\ModelForge\MetaEntity;

class ModelForgeAction extends TwigRenderAction implements Action
{
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

    /**
     * Verifies if the folder exists
     *
     * @param $folder string
     * @return bool
     */
    protected function folderExists($folder)
    {
        return is_dir($folder);
    }

    /**
     * Verifies if the entity exists
     *
     * @param $entityFolder string
     * @param $entityName string
     * @return bool
     */
    protected function entityExists($entityFolder, $entityName)
    {
        return file_exists($entityFolder .'/'.$entityName.'.php');
    }


    public function performAction(Environment $environment, $args)
    {
        $this->environment = $environment;

        if (sizeof($args) < 3) {
            (new ModelForgeHelpAction())->performAction($environment, $args);
            return;
        }

        $migrationsDir = $environment->getBaseDir() . '/migrations';

        if (!is_dir($migrationsDir)) {
            print "Error: migrations directory does not exist\n";
            print "Please create the directory $migrationsDir to use this tool.\n\n";
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
        $modulePath = $environment->getModules()[$metaEntity->getModule()];

        if(!$this->moduleExists($environment,
            $metaEntity->getModule(),
            $modulePath)
        ) {
            print "Error: Module does not exist\n";
            return;
        }

        $moduleModelPath = $modulePath . '/Model';

        if(!$this->folderExists($moduleModelPath))
        {
            print "Creating Model directory on your module\n";
            print "[$moduleModelPath]\n\n";
            mkdir($moduleModelPath);
        }

        if($this->entityExists($moduleModelPath,$metaEntity->getName()))
        {
            print "Error: Cannot override entity.\n\n";
            return;
        }

        // Creates the entity
        $templateEngine = $this->getTemplateEngine(__DIR__ . '/templates');
        $entityPath = $moduleModelPath.'/'.$metaEntity->getName().'.php';

        print "Generating entity on [$entityPath]\n\n";

        $modelFile = fopen($entityPath,'w');
        $modelTemplate = $templateEngine->loadTemplate('Model.php.twig');

        fwrite($modelFile,$modelTemplate->render(array('model'=>$metaEntity)));
        fclose($modelFile);


        print "Model generated.\n"
            ."You can use ./schema_update.sh to update your database.\n\n";
    }


}