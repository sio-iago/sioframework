<?php


namespace SIOFramework\Acl\Controller;


use Aura\Session\Session;
use SIOFramework\Common\Controller\DefaultController;
use SIOFramework\Common\Factory\DatabaseFactoryInterface;
use SIOFramework\Common\Factory\StandardFactory;
use SIOFramework\Acl\Model\SystemUser;
use Slim\Slim;

class AccessController extends DefaultController
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var DatabaseFactoryInterface
     */
    protected $dbFactory;

    /**
     * AccessController constructor.
     */
    public function __construct(Slim $app, DatabaseFactoryInterface $dbFactory)
    {
        parent::__construct($app);

        $this->session = $app->container->get('session');
        $this->dbFactory = $dbFactory;
    }


    /**
     * @return SystemUser|null
     */
    protected function doLogin()
    {
        if($this->app->request->isPost())
        {
            $criteria = array(
                'username' => $this->app->request->params('username'),
                'password' => sha1($this->app->request->params('password')),
                'status' => 'A',
            );

            $user = $this->dbFactory->selectOne('SIOFramework\Acl\Model\SystemUser', $criteria);

            if(is_object($user) && get_class($user)==get_class(new SystemUser())){

                $user->currentTimestamp();
                $this->dbFactory->persist($user);

                return $user;
            }
        }

        return NULL;
    }

    /**
     * Does the login and redirects to $routeName where
     * $routeName is a Slim pre-configured route name.
     *
     * It stores in the session:
     * 'userid' => int
     * 'roles' => array of SystemRole
     *
     * @param string $routeName
     */
    public function login($routeName)
    {
        $user = $this->doLogin();

        if($user)
        {
            $sessionContext = $this->app->container->get('root_segment');
            $sessionContext->set('userid',$user->getId());
            $sessionContext->set('roles',$user->getRoles()->toArray());

            $this->app->redirect($this->app->urlFor($routeName));
            return;
        }
        else
        {
            if($this->app->request->isPost())
                $this->data['error'] = 'Erro ao realizar login.';

            $this->render('acl/login.twig', $this->data);
        }
    }

    public function logout($routeName)
    {
        $this->session->destroy();

        $this->app->redirect($this->app->urlFor($routeName));
        return;
    }

}