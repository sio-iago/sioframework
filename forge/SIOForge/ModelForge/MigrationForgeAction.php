<?php


namespace SIOForge\ModelForge;

use SIOForge\Core\Action;
use SIOForge\Core\Environment;
use SIOForge\Core\TwigRenderAction;

class MigrationForgeAction extends TwigRenderAction implements Action
{

    public function performAction(Environment $environment, $args)
    {
        $this->environment = $environment;

        if (sizeof($args) < 3) {
            (new MigrationForgeHelpAction())->performAction($environment, $args);
            return;
        }

        $migrationsDir = $environment->getBaseDir() . '/migrations';

        if (!is_dir($migrationsDir)) {
            print "Creating the migrations directory.\n\n";
            mkdir($migrationsDir);
        }

        $migrationPath = $migrationsDir . '/' . $args[2] . '.php';

        if (file_exists($migrationPath))
        {
            print "Error: Cannot override migration file.\n\n";
            return;
        }

        // Creates the entity
        $templateEngine = $this->getTemplateEngine(__DIR__.'/templates');

        print "Generating migration on [$migrationPath]\n\n";

        $migrationFile = fopen($migrationPath,'w');
        $migrationTemplate = $templateEngine->loadTemplate('Migration.php.twig');

        fwrite($migrationFile,$migrationTemplate->render(array('name'=>$args[2])));
        fclose($migrationFile);

        print "Migration generated.\n"
            ."Use '".$args[0]." model ".$args[2]."' to generate the entity'.\n\n";
    }


}