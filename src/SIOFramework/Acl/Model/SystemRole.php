<?php

namespace SIOFramework\Acl\Model;

use Doctrine\ORM\Mapping as ORM;
use SIOFramework\Common\Model\Model;

/**
 * Class SystemRole
 * @package SIOFramework\Acl\Model
 *
 * @ORM\Entity
 * @ORM\Table(name="sio_role")
 */
class SystemRole extends Model{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $value;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|SystemRole $role
     * @return bool
     */
    public function equals($role)
    {
        if(is_object($role) && get_class($this) == get_class($role))
            return $this->value == $role->value;
        else
            return $this->value == $role;
    }

}

