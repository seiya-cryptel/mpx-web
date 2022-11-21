<?php

class SessionController extends ControllerBase
{

    // 管理IDや利用者IDを覚えておくためのセッション変数名です。
    const SV_THISID = 'SessionsControllerConfSID';  // 重複ログイン管理用セッションID
    const SV_CONFID = 'SessionsControllerConfUID';  // 重複ログインが検出された利用者ID

    // セッション登録

    private function _registerSession($user)
    {
        $this->session->set(
            'auth', array(
                'user_id' => $user->id,
                'name' => $user->user_name,
                'role' => $user->user_type,
                'dl_tool' => $user->dl_tool,    // 2017/05/26
                // 'asp_flag' => $user->asp_flag,  // 2018/10/19 2018/02/26
                // 'fc_hourly' => $user->fc_hourly,
                // 'report_va' => $user->report_va,    // 2018/05/16
//                 'report_rp' => $user->report_rp,    // 2018/06/04
                'auth_bits' => $user->auth_bits,    // 2018/09/28
            )
        );
    }

    /**
     * This action authenticate and logs a user into the application
     */
    public function startAction()
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__, []);
        // POSTで送信された値
        $userId = $this->request->getPost('id');
        $userPwd = $this->request->getPost('pwd');
        
        // 2019/02/15
        $this->session->remove(ControllerBase::SV_AUTHORITY);

        // nameかemailが空の場合
        if ($userId == '' || $userPwd == '') {
            return $this->response->redirect(($this->getLang() == 'ja') ? '/' :  '/index/e');  // 2015/12/10　トップ画面へ
        }

        /**
         * TODO
         * CSRF対策(token)
         */
        // if( ! $this->security->checkToken()) {
        //     // ログインフォームへ再度転送
        //     return $this->response->redirect('sessions/index');
        // }

        $user = Users::findFirst(
                        array(
                            "(isvalid=1) AND (id = :id:)",
                            'bind' => array(
                                'id' => $userId,
                            )
                        )
        );
        // 2018/09/28 テンプレートの権限取得
        $Authority = Authority::findFirst(
                        array(
                            "(auth_name = :authName:)",
                            'bind' => array(
                                'authName' => 'TEMPLATE_' . $user->user_type,
                            )
                        )
        );
        $user->auth_bits = intval($Authority->auth_bits);
        // 2018/09/28 追加権限取得
        $Acls = Acl::find(
                        array(
                            "(isvalid=1) AND (user_id=:id:)",
                            'bind' => array(
                                'id' => $userId,
                            )
                        )
                );
        foreach ($Acls as $Acl) {
            // var_dump($Acl->Authority);exit(0);
            // var_dump(intval($Acl->Authority->auth_bits));exit(0);
            $user->auth_bits |= intval($Acl->Authority->auth_bits);
        }
        // var_dump($user->auth_bits);        exit(0);
        
        /* 2018/09/28
        // 2018/02/26
        $acl = Acl::findFirst(
                        array(
                            "(isvalid=1) AND (auth_name='FC_HOURLY') AND (user_id=:id:)",
                            'bind' => array(
                                'id' => $userId,
                            )
                        )
                );
        // 2018/05/16
        $aclRVA = Acl::findFirst(
                        array(
                            "(isvalid=1) AND (auth_name='REPORT_VA') AND (user_id=:id:)",
                            'bind' => array(
                                'id' => $userId,
                            )
                        )
                );
        // 2018/06/04
        $aclRRP = Acl::findFirst(
                        array(
                            "(isvalid=1) AND (auth_name='REPORT_RP') AND (user_id=:id:)",
                            'bind' => array(
                                'id' => $userId,
                            )
                        )
                );
         * 
         */

        // パスワードを比較
        if (($user == false) || (!$this->security->checkHash($userPwd, $user->pwd))) {
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGIN, array($userId, 'Fail'));
            // echo 'ID またはパスワードが間違っています。';
            // exit; // TODO 削除
            $this->flash->error($this->isJa()
                    ? 'ID またはパスワードが間違っています。'
                    : 'Not a valid email address or password.');
            return $this->response->redirect($this->isJa() ? '/login' : 'login/e');
        }
        
        // $user->fc_hourly = $acl ? true : false; // 2018/10/19 2018/04/15
        // $user->report_va = (($user->user_type > 0) || $aclRVA) ? true : false; // 2018/05/16
        // $user->report_va = (($user->user_type > 2) || $aclRVA) ? true : false; // 2018/05/21
        // $user->report_rp = (($user->user_type > 2) || $aclRRP) ? true : false; // 2018/06/04

        $this->session->set(self::SV_THISID, $this->session->getId());

        // 二重ログインチェック 2015/11/27
        $session = Session::findFirst(
                        array(
                            'user_id = :user_id:',
                            'bind' => array(
                                'user_id' => $userId
                            )
                        )
        );
        if ($session && (date('Y-m-d H:i:s') > $session->valid_until)) {
            // 有効期限切れ
            $session->delete();
            $session = false;
        }

        if ($session && ($session->id != $this->session->get(self::SV_THISID))) {
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGIN, array($userId, 'Duplicated'));
            // 二重ログインの可能性
            $this->session->set(self::SV_CONFID, $userId);
            $this->flash->warning($this->isJa()
                    ? '二重ログインの可能性があります。'
                    : 'There is a possibility of double login.');    // 2020/02/08
            // return $this->response->redirect('session/conflict');
            return $this->response->redirect(($this->getLang() == 'ja') ? 'session/conflict' : 'session/conflicte');            
        }
        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGIN, array($userId, 'Done'));

        // セッション書き込み
        if (!$session) {
            $strValidUntil = date('Y-m-d H:i:s', strtotime('+' . intval($this->sysSetting['SESSION_VALID_TIME'][0]) . ' minutes'));
            $session = new Session();
            $session->id = $this->session->get(self::SV_THISID);
            $session->user_id = $user->id;
            $session->valid_until = $strValidUntil;
            $session->save();
        }

        $this->_registerSession($user);

        // ログイン後画面へ
        if($user->user_type == 0)
        {   // 2018/03/30
            // $url = '/asp/';
            $url = $this->isJa() ? '/asp/' : '/asp/en';
        }
        else
        {
            $url = $this->session->get(ControllerBase::SV_AFTERLOGIN);  // 2016/06/20
        }
        if(empty($url)) {
            // return $this->response->redirect('forwardcurve'); 2017/08/16
            // return $this->response->redirect('/');
            return $this->response->redirect($this->isJa() ? '/' : '/index/e');
        }
        else {
            $this->session->remove(ControllerBase::SV_AFTERLOGIN);
            return $this->response->redirect($url);
        }
        // return $this->response->redirect('/');
    }

    /**
     * 二重ログインの可能性がある場合
     */
    public function conflictAction()
    {
        $userId = $this->session->get(self::SV_CONFID);

        if ($this->request->isPost()) {
            $user = Users::findFirst(
                            array(
                                'id = :email:',
                                'bind' => array(
                                    'email' => $userId,
                                )
                            )
            );
            
            // 2020/02/02; 2018/09/28 テンプレートの権限取得
            $Authority = Authority::findFirst(
                            array(
                                "(auth_name = :authName:)",
                                'bind' => array(
                                    'authName' => 'TEMPLATE_' . $user->user_type,
                                )
                            )
            );
            $user->auth_bits = intval($Authority->auth_bits);
            // 2018/09/28 追加権限取得
            $Acls = Acl::find(
                            array(
                                "(isvalid=1) AND (user_id=:id:)",
                                'bind' => array(
                                    'id' => $userId,
                                )
                            )
                    );
            foreach ($Acls as $Acl) {
                // var_dump($Acl->Authority);exit(0);
                // var_dump(intval($Acl->Authority->auth_bits));exit(0);
                $user->auth_bits |= intval($Acl->Authority->auth_bits);
            }
            // セッション管理レコード
            $session = Session::findFirst(
                            array(
                                'user_id=:user_id:',
                                'bind' => array(
                                    'user_id' => $userId,
                                )
                            )
            );
            if ($session == FALSE) {
                $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGIN, array($userId, 'Duplicated but no session'));
                // 他のセッションでログアウトされたのだろう
                return $this->response->redirect($this->isJa() ? '/' : '/index/e');
            }
            $session->delete();

            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGIN, array($userId, 'Duplicated and done'));
                
            $strValidUntil = date('Y-m-d H:i:s', strtotime('+' . intval($this->sysSetting['SESSION_VALID_TIME'][0]) . ' minutes'));
            $session = new Session();
            $session->id = $this->session->get(self::SV_THISID);
            $session->user_id = $userId;
            $session->valid_until = $strValidUntil;
            $session->save();

            $this->_registerSession($user);

            // FC画面へ
            // return $this->response->redirect('forwardcurve');

            // ログイン後画面へ 2020/01/31
            if($user->user_type == 0)
            {   // 2018/03/30
                // $url = '/asp/';
                $url = $this->isJa() ? '/asp/' : '/asp/en';
            }
            else
            {
                $url = $this->session->get(ControllerBase::SV_AFTERLOGIN);  // 2016/06/20
            }
            if(empty($url)) {
                // return $this->response->redirect('forwardcurve'); 2017/08/16
                // return $this->response->redirect('/');
                return $this->response->redirect($this->isJa() ? '/' : '/index/e');
            }
            else {
                $this->session->remove(ControllerBase::SV_AFTERLOGIN);
                return $this->response->redirect($url);
            }
        }
        $this->view->user_id = $userId;
    }

    // 2020/01/31
    public function conflicteAction()
    {
        $ret = $this->conflictAction();
        $this->view->setMainView('indexe'); // 2016/05/16
        $this->view->ja = '/session/conflict';   // 日本語ページへのリンク
        return $ret;
    }

    /**
     * ログアウト処理
     */
    public function logoutAction()
    {
        $auth = $this->session->get('auth');
        if ($auth) {
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_LOGOUT, array($auth['user_id']));
            $userId = $auth['user_id'];
            $session = Session::findFirst(
                            array(
                                'user_id=:user_id:',
                                'bind' => array(
                                    'user_id' => $userId,
                                )
                            )
            );
            if ($session) {
                $session->delete();
            }
            $this->session->remove('auth');
            $this->session->remove(self::SV_THISID);
        }
        $this->session->destroy();
        $this->flash->success(($this->getLang() == 'ja') ? 'ログアウトしました。' : 'Logout Succeeded.');
        return $this->response->redirect(($this->getLang() == 'ja') ? '/' : '/index/e');    // 2020/01/31
    }

}
