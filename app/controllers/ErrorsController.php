<?php

/**
 * ErrorController 
 */
class ErrorsController extends \Phalcon\Mvc\Controller
{
    public function show404Action()
    {
        // var_dump($this->request);exit(0);
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick('errors/404');
    }
    
    public function show500Action()
    {
        $this->response->setStatusCode(500, 'Not Found');
        $this->view->pick('errors/500');
        $this->view->msg = $this->session->get($this->config->application->svErrorMsg);
    }
}