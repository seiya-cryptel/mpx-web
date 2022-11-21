<?php

class IndexController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setMainView('notlogin'); // 2016/04/26        
        $this->view->en = '/index/e';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        // News 表示数, New 日数
        $newsCount = $this->sysSetting['NEWS_TOP'][0];
        $newsNew = $this->sysSetting['NEWS_NEW'][0];

        // if($auth['role'] == 9) {     2018/09/28
        // if($auth['auth_bits'] & $this->authority['ADMIN'])   2018/10/25
        if($auth['auth_bits'] & $this->authority['NEWS_ALL'])
        {
            // var_dump('ADMIN'); exit(0);
            $news = Notices::find(
                        array(
                            // 'conditions' => '(isvalid=1)',   2018/10/15
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1)",
                            'order' => 'date_notice DESC',
                            'limit' => $newsCount,
                        )
                    );
        }
        else {
            // $targetCond = $auth['role'] > 0 ? '((target_user & 2) <>0)' : '((target_user & 1) <>0)';     2018/09/28
            // 2018/10/25
            $user_mask = 1;
            if($auth['auth_bits'] & $this->authority['NEWS_USER'])
            {
                $user_mask |= 2;
            }
            // if($auth['auth_bits'] & $this->authority['NEWS_PUBLIC'])
            // {
            //     $user_mask |= 1;
            // }
            // $targetCond = ($auth['auth_bits'] & $this->authority['FC_SYS_MONTHLY']) ? '((target_user & 2) <>0)' : '((target_user & 1) <>0)'; 
            $targetCond = '((target_user & ' . $user_mask . ') <> 0)'; 
            $news = Notices::find(
                        array(
                            // 'conditions' => "(isvalid=1) AND (publish=1) AND " . $targetCond,   2018/10/12
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (publish=1) AND " . $targetCond,   
                            'order' => 'date_notice DESC',
                            'limit' => $newsCount,
                        )
                    );            
        }
        
        // viewにデータを渡す
        $this->view->news = $news;
        $this->view->setVars([
            'active_home' => 'active',
            ]);
        
        $this->assets->addCss('css/top.css');
        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/jquery.tile.min.js')
                ->addJs('js/tile.js')
                ;
    }

    // 2020/01/28
    public function  eAction()
    {
        $this->view->setMainView('notlogine');        
        $this->view->ja = '/';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        // News 表示数, New 日数
        $newsCount = $this->sysSetting['NEWS_TOP'][0];
        $newsNew = $this->sysSetting['NEWS_NEW'][0];

        if($auth['auth_bits'] & $this->authority['NEWS_ALL'])
        {
            $news = Notices::find(
                        array(
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (title_e IS NOT NULL) AND (title_e<>'')",
                            'order' => 'date_notice DESC',
                            'limit' => $newsCount,
                        )
                    );
        }
        else {
            $user_mask = 1;
            if($auth['auth_bits'] & $this->authority['NEWS_USER'])
            {
                $user_mask |= 2;
            }
            $targetCond = '((target_user & ' . $user_mask . ') <> 0)'; 
            $news = Notices::find(
                        array(
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (publish=1) AND " . $targetCond,   
                            'order' => 'date_notice DESC',
                            'limit' => $newsCount,
                        )
                    );            
        }
        
        // viewにデータを渡す
        $this->view->news = $news;
        $this->view->setVars([
            'active_home' => 'active',
            ]);
        
        $this->assets->addCss('css/top.css');
        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/jquery.tile.min.js')
                ->addJs('js/tile.js')
                ;
    }
}
