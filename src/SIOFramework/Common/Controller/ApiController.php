<?php


namespace SIOFramework\Common\Controller;


use Slim\Slim;

class ApiController
{
    /**
     * @var Slim
     */
    protected $app;

    public function __construct(Slim $app)
    {
        $this->app = $app;

        // Setting JSON Header
        $this->app->response()->headers->set('Content-Type', 'application/json');
    }

    protected function render($data=array())
    {
        $callback = $this->app->request()->get('callback');
        $this->app->response->setStatus(200);

        $this->app->response->setBody(
            ($callback?$callback.'(':'')
            .json_encode($data, JSON_OBJECT_AS_ARRAY)
            .($callback?')':'')
        );
    }

    /**
     * @param $message
     */
    protected function renderError($message)
    {
        $callback = $this->app->request()->get('callback');
        $this->app->response->setStatus(503);
        $this->app->response->setBody(
            ($callback?$callback.'(':'')
            .json_encode(array('error'=>$message),JSON_OBJECT_AS_ARRAY)
            .($callback?')':'')
        );
    }
}