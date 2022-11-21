<?php

class BackgroundController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setMainView('notlogin'); // 2016/04/26
        $this->view->en = '/background/e';   // 英語ページへのリンク 2020/01/28
    }

    // 2020/01/29
    public function eAction()
    {
        $this->view->setMainView('notlogine');
        $this->view->ja = '/background/';   // 日本語ページへのリンク 2020/01/28
    }

}
