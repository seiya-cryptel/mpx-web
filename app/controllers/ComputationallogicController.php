<?php

class ComputationallogicController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        // 権限の設定
        $auth = $this->session->get('auth');
        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'active_computationallogic' => 'active'
                )
        );
    }

}
