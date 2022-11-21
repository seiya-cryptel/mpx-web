<?php

class MethodologyController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'active_home' => 'active'
                )
        );
    }

}
