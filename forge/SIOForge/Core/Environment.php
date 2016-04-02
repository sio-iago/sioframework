<?php


namespace SIOForge\Core;


class Environment
{
    /**
     * @var array
     */
    protected $modules;

    /**
     * @var string
     */
    protected $baseDir;

    /**
     * Environment constructor.
     * @param string $baseDir
     */
    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;

        $this->modules = require_once $this->baseDir . '/conf/modules.php';
    }

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return string
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }


}