<?php

namespace SIOForge\Core;

class Kernel
{
    /**
     * @var array
     */
    protected $actions;

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * Kernel constructor.
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        $this->environment = new Environment($baseDir);

        $this->actions = require_once __DIR__ . '/../conf/actions.php';
    }

    public function helpUser($args)
    {
        (new HelpAction($this->actions))->performAction($this->environment,$args);
    }

    private function printBanner()
    {
        print "===========================\n";
        print "|        SIO Forge        |\n";
        print "|    Forging your code    |\n";
        print "===========================\n";
    }

    public function run($args)
    {
        $this->printBanner();

        if(sizeof($args)<2)
        {
            $this->helpUser($args);
            return;
        }

        $action = $args[1];

        if(array_key_exists($action,$this->actions))
        {
            (new $this->actions[$action]())->performAction($this->environment,$args);
        }
        else
        {
            print "Action not found\n";
            $this->helpUser($args);
        }
    }

}