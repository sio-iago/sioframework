<?php


namespace SIOFramework\Common\Controller;


use Slim\Slim;

interface ControllerInterface
{

    /**
     * Renders a view.
     *
     * @param string $view
     * @param null|array $args
     * @return mixed
     */
    public function render($view, $args=NULL);

    /**
     * ControllerInterface constructor.
     * Uses Slim to handle the application.
     *
     * @param Slim $app
     */
    public function __construct(Slim $app);

}