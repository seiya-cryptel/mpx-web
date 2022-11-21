<?php

class LoginController extends ControllerBase
{

    // パスワードリセット
    private function _resetPassword(&$targetUser)
    {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        // データベースからユーザーを検索
        $user = Users::findFirst(
                        array(
                            "(id = :user:)",
                            'bind' => array(
                                'user' => $targetUser->id,
                            )
                        )
        );
        $user_name = $user->user_name;     // 2018/10/16
        // 新しいランダムパスワード
        $pwd = substr(str_shuffle(str_repeat('2345678abcdefhijkmnprstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ', 8)), 0, 8);
        $pwdCrypt = $this->security->hash($pwd);
        $user->update(array('pwd' => $pwdCrypt));

        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
        $this->view->userName = $user->user_name;
        $this->view->pwd = $pwd;
        $this->mail($user->id, $siteMark . $this->isJa() ? '[MPX] パスワードをリセットしました' : '[MPX] Password Reset Notification', 'resetpwd', $header);
        /*
        $mailbody  = "\n$user_name 様\n\n"; // 2018/10/16
        $mailbody .= "新しいパスワードは $pwd です。\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、松土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($targetUser->id, $siteMark . '[MPX] パスワードをリセットしました', $mailbody, $header);
         * 
         */
    }

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__, []);
        $this->view->setMainView('notlogin'); // 2016/05/16
        $this->view->en = '/login/e';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'active_login' => 'active'
                )
        );
         $this->assets->addCss('css/login.css');
    }
    
    // 2020/01/29
    public function eAction()
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__, []);
        $this->view->setMainView('notlogine'); // 2016/05/16
        $this->view->ja = '/login/';   // 日本語ページへのリンク
        $this->setLang('en');

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'active_login' => 'active'
                )
        );
         $this->assets->addCss('css/login.css');
    }

    public function lostpwdAction()
    {        
        if($this->isJa())
        {
            $this->view->setMainView('notlogin'); // 2016/05/16
            $this->view->en = '/login/lostpwde';   // 英語ページへのリンク 2020/01/28
        }
        else
        {
            $this->view->setMainView('notlogine'); // 2016/05/16
            $this->view->ja = '/login/lostpwd';   // 英語ページへのリンク 2020/01/28
        }
        
        if ($this->auth) {
            // ログイン済ならポータルへ
            return $this->response->redirect($this->isJa() ? '/' : '/index/e');
        }

        if ($this->request->isPost()) {
            $email = $this->request->getPost('id');
            $name = $this->request->getPost('user_nickname');

            // データベースからユーザーを検索
            $user = Users::findFirst(
                            array(
                                "(isvalid=1)"
                                . " AND (IFNULL(valid_from, CURDATE()) <= CURDATE())"
                                . " AND (IFNULL(valid_to,   CURDATE()) >= CURDATE())"
                                . " AND (id = :email:)"
                                . " AND (user_nickname = :name:)",
                                'bind' => array(
                                    'email' => $email,
                                    'name' => $name,
                                )
                            )
            );

            $userName = ($user ? $user->user_nickname : 'user not found');
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_RESETPWD, array($email, $name, $userName));
            
            if( ! $user ) {
                $this->flash->error($this->isJa() ? 'ユーザが見つかりません。' : 'Not a valid UserID.');
                return $this->response->redirect($this->isJa() ? 'login/lostpwd' : 'login/lostpwde');
            }
            
            $form = new LostpwdForm();

            $post = $this->request->getPost();
            
            if ( ! $form->isValid($post, $user) ) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect($this->isJa() ? 'login/lostpwd' : 'login/lostpwde');
            }
            
            $form->clear();
            $this->_resetPassword($user);
            $this->flash->success($this->isJa() ? 'パスワード リセット メールを送信しました。' : 'Password Reset Notification has been sent to your email.');
            return $this->response->redirect($this->isJa() ? 'login/index' :  'login/e');
        }
        else {
            $user = new Users();
            $this->view->form = new LostpwdForm($user);                    
        }
    }

    // 2020/01/31
    public function lostpwdeAction()
    {
        $this->lostpwdAction();
    }
}
