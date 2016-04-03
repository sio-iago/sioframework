<?php


namespace SIOFramework\Common\Controller;


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

}