<?php

namespace SIOFramework\Acl\Model;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use SIOFramework\Common\Model\Model;

/**
 * Class SystemUser
 * @package SIOFramework\Acl\Model
 *
 * @ORM\Entity
 * @ORM\Table(name="sio_user")
 * @ORM\HasLifecycleCallbacks
 */
class SystemUser extends Model {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    private $username;


    /**
     * @ORM\Column(type="string")
     * @var strign
     */
    private $password;

    /**
     * @ORM\Column(type="string",columnDefinition="CHAR(2) NOT NULL DEFAULT 'A'")
     * @var string
     */
    private $status;

    /**
     * @ORM\Column(name="last_login", type="datetime")
     * @var DateTime
     */
    private $lastLogin;


    /**
     * @ORM\ManyToMany(targetEntity="SIOFramework\Acl\Model\SystemRole",cascade={"all"})
     * @ORM\JoinTable(name="sio_user_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection
     */
    protected $roles;


    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->currentTimestamp();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * @return DateTime
     */
    function getLastLogin() {
        return $this->lastLogin;
    }

    /**
     * @param string $password
     */
    function setPassword($password) {
        $this->password = sha1($password);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param ArrayCollection $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param SystemRole $role
     */
    public function addRole(SystemRole $role)
    {
        $this->roles->add($role);
    }

    /**
     * $role can be a SystemRole object or the role's id
     *
     * @param int|SystemRole $role
     */
    public function removeRole($role)
    {
        if (is_object($role))
            $this->roles->removeElement($role);

        else
        {
            foreach($this->roles as $myRole)
            {
                if($myRole->getId() == $role)
                {
                    $this->roles->removeElement($myRole);
                    return;
                }
            }
        }

    }

    /** 
    * @ORM\PrePersist
    */
   public function currentTimestamp()
   {
       $this->lastLogin = new DateTime("now");
       $this->lastLogin->setTimezone(new DateTimeZone('America/New_York'));
   }
}

