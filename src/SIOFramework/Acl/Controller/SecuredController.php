<?php

namespace SIOFramework\Acl\Controller;

use Exception;
use Aura\Session\Segment;
use SIOFramework\Common\Controller\DefaultController;
use SIOFramework\Common\Factory\StandardFactory;
use SIOFramework\Common\Model\SystemRole;
use Slim\Slim;

abstract class SecuredController extends DefaultController
{
    /**
     * @var Slim $app
     */
    protected $app;

    /**
     * @var array $data
     */
    protected $data;

    /**
     * @var \Twig_Environment $twig
     */
    protected $twig;

    /**
     * @var Segment $session
     */
    protected $sessionContext;


    /**
     * Must be implemented in each secured module.
     * Returns true the user if has permission and
     * false if the user has not.
     *
     * @return bool
     */
    abstract protected function userHasAccess();


    /**
     * Class Constructor
     * @param Slim $app
     * @throws Exception
     */
    public function __construct(Slim $app)
    {
        parent::__construct($app);

        $this->sessionContext = $this->app->container->get('root_segment');

        $session = $this->sessionContext;

        if($session)
        {
            $this->data['userid'] = $session->get('userid');
            $this->data['roles'] = $session->get('roles');

            if($this->data['userid']==NULL)
            {
                throw new Exception('Unauthorized!');
            }

            $this->session = $session;

            $app->container->singleton('system_roles',function()
            {
                $dbFactory = new StandardFactory($this->app);
                $systemRoles = $dbFactory->selectAll('SIOFramework\Common\Model\SystemRole');

                return $systemRoles;
            });


            if(!$this->userHasAccess())
                throw new Exception('Unauthorized to this module.');
        }
        else
        {
            throw new Exception('Unauthorized!');
        }

    }


    /**
     * @param string $role
     * @return bool
     */
    protected function loggedUserHasRole($role)
    {
        $userRoles = $this->getLoggedUserRoles();

        if(is_array($userRoles)) foreach($userRoles as $userRole)
        {
            /**
             * @var $userRole SystemRole
             */
            if($userRole->equals($role))
                return TRUE;
        }

        return FALSE;
    }

    /**
     * @return int|null
     */
    protected function getLoggedUserId()
    {
        return $this->getSession()->get('userid');
    }

    /**
     * @return array|null
     */
    protected function getLoggedUserRoles()
    {
        return $this->getSession()->get('roles');
    }

    /**
     * @return Segment
     * @throws \Aura\Session\Exception
     */
    protected function getSession()
    {
        if(!$this->sessionContext)
            throw new \Aura\Session\Exception('No session started!');

        return $this->sessionContext;
    }

}