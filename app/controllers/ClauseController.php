<?php

class ClauseController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setMainView('notlogin'); // 2016/04/26
    }

}
