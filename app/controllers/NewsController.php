<?php

class NewsController  extends ControllerBase 
{
    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    // 利用者向けニュース一覧
    public function indexAction()
    {
        $this->view->en = '/news/en';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
            $this->view->setMainView('notlogin'); // 2016/08/16
        }
        
        // News 表示数, New 日数
        $newsNew = $this->sysSetting['NEWS_NEW'][0];

        // var_dump($auth['auth_bits']);exit(0);
        
        // if($auth['role'] == 9)   2018/10/07
        // if($auth['auth_bits'] & $this->authority['ADMIN'])   2018/10/25
        if($auth['auth_bits'] & $this->authority['NEWS_ALL'])
        {
            $news = Notices::find(
                        array(
                            // 'conditions' => '(isvalid=1)',   2018/10/15
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1)",
                            'order' => 'date_notice DESC',
                            'limit' => 1000,
                        )
                    );
        }
        else {
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
                            // 'conditions' => '(isvalid=1) AND (publish=1) AND ' . $targetCond,   2018/10/12
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (publish=1) AND " . $targetCond,   
                            'order' => 'date_notice DESC',
                            'limit' => 1000,
                        )
                    );            
        }
        $this->view->news = $news;
        $this->view->enable_report_va = ($auth_bits & $this->authority['REPORT_VA']);
        $this->view->enable_report_rp = ($auth_bits & $this->authority['REPORT_RP']);
        // 20190620 deguchi modified
        $this->view->enable_report_misc = ($auth_bits & $this->authority['REPORT_OTHER']);
    }

    // 利用者向けニュースコンテンツ
    public function cAction($id)
    {
        $this->view->en = '/news/oe';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');

        $news = Notices::findFirst(
                    array(
                        'conditions' => '(isvalid=1) AND (publish=1) AND (id=' . $id . ')',
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 月次レポート
    public function mAction()
    {
        $this->view->en = '/news/me';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';     // 2016/10/19
            $auth_bits = 0;    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {     // 2016/06/07 4->1 2016/03/27 3 -> 4
        if(($auth_bits & $this->authority['REPORT_MONTHLY']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/m');    // 2016/06/20
            // return $this->response->redirect("login");
            return $this->response->redirect(($this->isOvr()) ? 'login/e' :  "login");
            //return $this->response->redirect("/");
        }
        
        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_M')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 週次レポート
    public function wAction()
    {
        $this->view->en = '/news/we';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['REPORT_WEEKLY']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/w');    // 2016/06/20
            // return $this->response->redirect("login");
            return $this->response->redirect(($this->isOvr()) ? 'login/e' :  "login");
            //return $this->response->redirect("/");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_W')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 長期フォワードカーブ レポート 2017/07/12
    public function fcAction()
    {
        $this->view->en = '/news/fce';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['NEWS_USER']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/fc');
            // return $this->response->redirect("login");
            return $this->response->redirect(($this->isOvr()) ? 'login/e' :  "login");
        }
        // if($auth['role'] < 3) { // B1 以上利用可能
        if(($auth_bits & $this->authority['REPORT_WEEKLY']) == 0)  // 2018/10/07
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_LFC')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // ジェネレーション・スタック レポート 2017/11/15
    public function gsAction()
    {
        $this->view->en = '/news/gse';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['NEWS_USER']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/fc');
            // return $this->response->redirect("login");
            return $this->response->redirect(($this->isOvr()) ? 'login/e' :  "login");
        }
        // if($auth['role'] < 3) { // B1 以上利用可能
        if(($auth_bits & $this->authority['REPORT_GS']) == 0)  // 2018/10/07
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_GS')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 検証データ 2018/04/27
    public function vaAction()
    {
        $this->view->en = '/news/vae';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        /* 2018/05/16
        if($auth['role'] < 1) {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/va');
            return $this->response->redirect("login");
        }
        if($auth['role'] < 7) { // D 以上利用可能
            return $this->response->redirect("/");
        }
         * 
         */
        // if(! $auth['report_va']) {
        if(($auth_bits & $this->authority['REPORT_VA']) == 0)  // 2018/10/07
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_VA')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // リスク・プレミアム 2018/04/27
    public function rpAction()
    {
        $this->view->en = '/news/rpe';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        /*
        if($auth['role'] < 1) {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/rp');
            return $this->response->redirect("login");
        }
        if($auth['role'] < 7) { // D 以上利用可能
            return $this->response->redirect("/");
        }
         * 2018/06/04
         */
        // if(! $auth['report_rp']) {
        if(($auth_bits & $this->authority['REPORT_RP']) == 0)  // 2018/10/07
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_RP')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // エリア間値差カーブ
    public function oAction()
    {
        $this->view->en = '/news/oe';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (category='REPORT_O')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 2020/01/31
    public function enAction()
    {
        $this->view->ja = '/news/';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
            $this->view->setMainView('indexe');
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
            $this->view->setMainView('notlogine'); // 2016/08/16
        }
        
        // News 表示数, New 日数
        $newsNew = $this->sysSetting['NEWS_NEW'][0];

        // var_dump($auth['auth_bits']);exit(0);
        
        // if($auth['role'] == 9)   2018/10/07
        // if($auth['auth_bits'] & $this->authority['ADMIN'])   2018/10/25
        if($auth['auth_bits'] & $this->authority['NEWS_ALL'])
        {
            $news = Notices::find(
                        array(
                            // 'conditions' => '(isvalid=1)',   2018/10/15
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (title_e IS NOT NULL) AND (title_e<>'')",
                            'order' => 'date_notice DESC',
                            'limit' => 1000,
                        )
                    );
        }
        else {
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
                            // 'conditions' => '(isvalid=1) AND (publish=1) AND ' . $targetCond,   2018/10/12
                            // 'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (publish=1) AND " . $targetCond,   
                            'conditions' => "(category<>'REPORT_GS') AND (isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND " . $targetCond,   
                            'order' => 'date_notice DESC',
                            'limit' => 1000,
                        )
                    );            
        }
        $this->view->news = $news;
        $this->view->enable_report_va = ($auth_bits & $this->authority['REPORT_VA']);
        $this->view->enable_report_rp = ($auth_bits & $this->authority['REPORT_RP']);
        // 20190620 deguchi modified
        $this->view->enable_report_misc = ($auth_bits & $this->authority['REPORT_OTHER']);
    }
    
    public function ceAction($id)
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/c';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');

        $news = Notices::findFirst(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (id=" . $id . ')',
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 月次レポート
    public function meAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/m';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';     // 2016/10/19
            $auth_bits = 0;    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {     // 2016/06/07 4->1 2016/03/27 3 -> 4
        if(($auth_bits & $this->authority['REPORT_MONTHLY']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/m');    // 2016/06/20
            return $this->response->redirect("login/e");
            //return $this->response->redirect("/");
        }
        
        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_M')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 週次レポート
    public function weAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/w';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['REPORT_WEEKLY']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/w');    // 2016/06/20
            return $this->response->redirect("login/e");
            //return $this->response->redirect("/");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_W')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 長期フォワードカーブ レポート 2017/07/12
    public function fceAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/fc';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['NEWS_USER']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/fc');
            return $this->response->redirect("login/e");
        }
        // if($auth['role'] < 3) { // B1 以上利用可能
        if(($auth_bits & $this->authority['REPORT_WEEKLY']) == 0)  // 2018/10/07
        {
            return $this->response->redirect("/index/e");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_LFC')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // ジェネレーション・スタック レポート 2017/11/15
    public function gseAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/gs';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        
        // if($auth['role'] < 1) {
        if(($auth_bits & $this->authority['NEWS_USER']) == 0)  // 2018/10/07
        {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/fc');
            return $this->response->redirect("login/e");
        }
        // if($auth['role'] < 3) { // B1 以上利用可能
        if(($auth_bits & $this->authority['REPORT_GS']) == 0)  // 2018/10/07
        {
            return $this->response->redirect("/index/e");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_GS')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // 検証データ 2018/04/27
    public function vaeAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/va';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        /* 2018/05/16
        if($auth['role'] < 1) {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/va');
            return $this->response->redirect("login");
        }
        if($auth['role'] < 7) { // D 以上利用可能
            return $this->response->redirect("/");
        }
         * 
         */
        // if(! $auth['report_va']) {
        if(($auth_bits & $this->authority['REPORT_VA']) == 0)  // 2018/10/07
        {
            return $this->response->redirect("/index/e");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_VA')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // リスク・プレミアム 2018/04/27
    public function rpeAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/rp';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        /*
        if($auth['role'] < 1) {
            $this->session->set(ControllerBase::SV_AFTERLOGIN, 'news/rp');
            return $this->response->redirect("login");
        }
        if($auth['role'] < 7) { // D 以上利用可能
            return $this->response->redirect("/");
        }
         * 2018/06/04
         */
        // if(! $auth['report_rp']) {
        if(($auth_bits & $this->authority['REPORT_RP']) == 0)  // 2018/10/07
        {
            return $this->response->redirect("/index/e");
        }

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_RP')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }

    // エリア間値差カーブ
    public function oeAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/news/o';   // 日本語ページへのリンク
        
        $auth = $this->session->get('auth');

        $news = Notices::find(
                    array(
                        'conditions' => "(isvalid=1) AND (publish=1) AND (title_e IS NOT NULL) AND (title_e<>'') AND (category='REPORT_O')",
                        'order' => 'date_notice DESC',
                        'limit' => 1000,
                    )
                );            
        $this->view->news = $news;
    }
}
