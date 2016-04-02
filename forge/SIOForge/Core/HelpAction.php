<?php


namespace SIOForge\Core;


class HelpAction implements Action
{
    /**
     * @var array
     */
    protected $actions;


    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }


    public function performAction(Environment $environment, $args)
    {
        print "Usage: php forge.php [action] [options]\n\n";

        print "Available options:\n\n";

        foreach($this->actions as $key=>$action)
        {
            print "    + " .$key . "\n";
        }

        print "\nFor more details about each action, use:\n";

        print "php forge.php action\n\n";
    }

}