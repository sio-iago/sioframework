<?php


namespace SIOFramework\Common\Controller;


use Slim\Slim;

abstract class WidgetController implements WidgetInterface
{
    /**
     * @var Slim
     */
    protected $app;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string
     */
    protected $partial;

    public function __construct(Slim $app, $partial, array $data)
    {
        $this->app = $app;
        $this->data = $data;
        $this->partial = $partial;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getPartial()
    {
        return $this->partial;
    }



}