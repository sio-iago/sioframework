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
     * @var array of WidgetInterface
     */
    protected $widgets;


    /**
     * DefaultController constructor.
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        $this->app = $app;
        $this->data = array_merge(array(),$app->request->params());

        $this->widgets = array();
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

        $this->processWidgets();
        echo $resp->render($args);
    }

    /**
     * Adds a widget to controller.
     *
     * @param WidgetInterface $widget
     */
    public function addWidget(WidgetInterface $widget)
    {
        $this->widgets[] = $widget;
    }

    /**
     * Gets a list of widgets.
     *
     * @return array
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * Process the widgets.
     * Creates $this->data['Widgets'].
     */
    protected function processWidgets()
    {
        $this->data['Widgets'] = $this->getWidgets();
    }
}