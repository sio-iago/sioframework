<?php


namespace SIOForge\ModelForge;


class MetaEntity
{
    /**
     * The entity data from migration
     * @var array
     */
    protected $migration;

    /**
     * MetaEntity constructor.
     * @param array $migration
     */
    public function __construct(array $migration)
    {
        $this->migration = $migration;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return (array_key_exists('name',$this->migration) ? $this->migration['name'] : NULL);
    }

    /**
     * @return null|string
     */
    public function getTableName()
    {
        return (array_key_exists('table_name',$this->migration) ? $this->migration['table_name'] : NULL);
    }

    /**
     * @return null|string
     */
    public function getPackage()
    {
        return (array_key_exists('package',$this->migration) ? $this->migration['package'] : NULL);
    }

    /**
     * @return null|string
     */
    public function getModule()
    {
        return (array_key_exists('module',$this->migration) ? $this->migration['module'] : NULL);
    }


    /**
     * @return null|string
     */
    public function getParameters()
    {
        return (array_key_exists('parameters',$this->migration) ? $this->migration['parameters'] : NULL);
    }

}