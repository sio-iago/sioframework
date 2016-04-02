<?php

namespace SIOFramework\Common\Controller;

use Slim\Slim;


abstract class DefaultController implements ControllerInterface
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

    /*
     * @var Language
     */
    protected $language;


    /**
     * DefaultController constructor.
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        $this->app = $app;
        $this->data = array_merge(array(),$app->request->params());

        $this->twig = $this->app->container->get('twig');
    }

    /**
     * Renders a view.
     * E.g.: $view = "module/view.twig"
     *
     * If $args is NULL, it will use $this->data
     * as the view data.
     *
     * @param string $view
     * @param null|array $args
     */
    public function render($view, $args=NULL)
    {
        $args = ($args == NULL ? $this->data : $args);

        $resp = $this->twig->loadTemplate($view);
        echo $resp->render($args);
    }
}