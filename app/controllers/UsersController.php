<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Criteria;

class UsersController extends ControllerBase
{

    public function initialize()
    {
        // $this->tag->setTitle('ユーザ設定');
        // $this->view->pageTitle = 'ユーザ設定';
        parent::initialize();
    }

    public function indexAction()
    {
        /*
          // 検索条件クリア
          $this->session->conditions = null;
          // 検索・一覧へ
          return $this->response->redirect('users/search');
         * 
         */
    }

    public function searchAction()
    {
        /*
          $this->tag->setTitle('ユーザ設定 一覧');
          $this->view->pageTitle = 'ユーザ設定 一覧';

          if($this->request->isPost()) {
          $post = $this->request->getPost();
          $where = '';
          $binds = array();
          if( ! $post['showInvalid']) {
          if($where != '')    $where .= ' AND ';
          $where .= '(isvalid = 1)';
          }
          $query = Users::query();
          $query->where($where);
          $query->bind($binds);
          $this->session->set(get_class() . '.where', $where);
          $this->session->set(get_class() . '.binds', $binds);
          $users = $query->execute();
          }
          else {
          $users = Users::find(['isvalid=1']);
          }

          $this->view->form = new UsersSearchForm;
          $this->view->users = $users;
         * 
         */
    }

    public function editAction($id)
    {
        /*
          $this->tag->setTitle('利用者 編集');
          $this->view->pageTitle = '利用者 編集';

          if ( ! $this->request->isPost()) {

          $user = Users::findFirst(array(
          'conditions' => 'user_id=?1',
          'bind' => array(1 => $id),
          ));
          if ( ! $user ) {
          $this->flash->error("利用者が見つかりません");
          return $this->response->redirect("users/index");
          }

          $this->view->updateMode = 'edit';
          $this->view->form = new UsersForm($user, array('edit' => true));
          }
         * 
         */
    }

    public function newAction()
    {
        /*
          $this->tag->setTitle('利用者　追加');
          $this->view->pageTitle = '利用者 追加';

          $user = new Users();

          $this->view->updateMode = 'new';
          $this->view->form = new UsersForm($user, array('edit' => true));
          $this->view->pick('users/edit');
         * 
         */
    }

    public function saveAction()
    {
        /*
          if (!$this->request->isPost()) {
          return $this->response->redirect("users/index");
          }

          $id = $this->request->getPost("user_id");

          $user = Users::findFirst(array(
          'conditions' => 'user_id=?1',
          'bind' => array(1 => $id),
          ));
          if ( ! $user ) {
          $this->flash->error("利用者が見つかりません");
          return $this->response->redirect("users/index");
          }

          $form = new UsersForm();
          $this->view->form = $form;

          $data = $this->request->getPost();

          if ( ! $form->isValid($data, $user) ) {
          foreach ($form->getMessages() as $message) {
          $this->flash->error($message);
          }
          return $this->response->redirect('users/edit/' . $id);
          }

          try {
          if ($user->save() == false) {
          foreach ($user->getMessages() as $message) {
          $this->flash->error($message);
          }
          return $this->response->redirect('users/edit/' . $id);
          }
          }
          catch(Exception $e) {
          throw $e;
          }

          $form->clear();

          $this->flash->success("利用者を保存しました");
          return $this->response->redirect("users/index");
         * 
         */
    }

    public function createAction()
    {
        /*
          if (!$this->request->isPost()) {
          return $this->response->redirect("users/index");
          }

          $form    = new UsersForm();
          $user = new Users();

          $post = $this->request->getPost();
          if( ! $form->isValid($post, $user) ) {
          foreach ($form->getMessages() as $message) {
          $this->flash->error($message);
          }
          return $this->response->redirect('users/new');
          }

          $user->user_pwd = ($user->user_pwd ? $user->user_pwd : 'set me');

          try {
          if ($user->save() == false) {
          foreach ($user->getMessages() as $message) {
          $this->flash->error($message);
          }

          return $this->response->redirect('users/new');
          }
          }
          catch(Exception $e) {
          throw $e;
          }

          $form->clear();

          $this->flash->success("利用者を登録しました");
          return $this->response->redirect("users/index");
         * 
         */
    }

    public function setpwdAction()
    {
        $this->view->en = '/users/setpwde';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');   // 2020/03/01
        
        $this->view->pageTitle = ($this->session->has(self::FLG_LANGOVERRIDE)) ? 'Change Password' : 'パスワード設定';  // 2020/03/01
        $auth = $this->session->get('auth');
        try {
            $user = Users::findFirst(
                            array(
                                'id = :user_id:',
                                'bind' => array(
                                    'user_id' => $auth['user_id'],
                                )
                            )
            );
            if (!$user) {
                $this->flash->error(($this->session->has(self::FLG_LANGOVERRIDE)) ? 'User not found.' : "システムエラーです。利用者IDが見つかりません。");
                return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/index/e' : "/");     // 2020/03/01
            }
        } catch (Exception $e) {
            throw $e;
        }

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = ($this->session->has(self::FLG_LANGOVERRIDE)) ? new UserPwdsEForm() : new UserPwdsForm();   // 2020/03/01
            if (!$form->isValid($post, $user)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/users/setpwde' : 'users/setpwd');    // 2020/03/01
            }
            $newUserPwd = $post['user_pwd1'];
            $newUserPwd = $this->security->hash($newUserPwd);

            try {
                if ($user->save(array(
                            'pwd' => $newUserPwd,
                            'upddate' => date('Y-m-d H:i:s'),
                                )
                        ) == false) {
                    foreach ($contract->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/users/setpwde' : 'users/setpwd');    // 2020/03/01
                    // return $this->response->redirect('users/setpwd');
                }
            } catch (Exception $e) {
                throw $e;
            }

            $form->clear();
            $this->flash->success(($this->session->has(self::FLG_LANGOVERRIDE)) ? 'Password was changed.' : "パスワードを設定しました");    // 2020/03/01
            
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_RESETPWD, array($auth['user_id'], 'Done'));

            $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
            /* 2018/10/16
            $this->view->userName = $auth['name'];
            $this->mail($auth['user_id'], '[MPX] パスワードを設定しました', 'setpwd', $header);
             * 
             */
            $user_name = $auth['name'];
            if($this->session->has(self::FLG_LANGOVERRIDE))
            {   // 2020/03/01
                $mailbody  = "\nHi, $user_name\n\n";
                $mailbody .= "Password was changed.\n\n";
                $mailbody .= "--\nPlease contact to G Arao or A Toishigawa\n";
                $mailbody .= "MPX, Inc.\n";
                $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
                mb_send_mail($auth['user_id'], $siteMark . '[MPX] Password was changed', $mailbody, $header);
            }
            else
            {
                $mailbody  = "\n$user_name 様\n\n"; // 2018/10/16
                $mailbody .= "パスワードが設定されました。\n\n";
                $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
                $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
                mb_send_mail($auth['user_id'], $siteMark . '[MPX] パスワードを設定しました', $mailbody, $header);                
            }
            return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/index/e' : "/");     // 2020/03/01   
        }

        $this->user = $user;
        // $this->view->form = new UserPwdsForm($user);
        $this->view->form = ($this->session->has(self::FLG_LANGOVERRIDE)) ? new UserPwdsEForm($user) : new UserPwdsForm($user); // 2020/03/01
    }

    public function profileAction()
    {
        $this->view->en = '/users/profilee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');   // 2020/03/01
        
        $this->view->pageTitle = ($this->session->has(self::FLG_LANGOVERRIDE)) ? 'User profile' : 'プロファイル';   // 2020/03/01
        $auth = $this->session->get('auth');
        try {
            $user = Users::findFirst(
                            array(
                                'id = :user_id:',
                                'bind' => array(
                                    'user_id' => $auth['user_id'],
                                )
                            )
            );
            if (!$user) {
                $this->flash->error(($this->session->has(self::FLG_LANGOVERRIDE)) ? 'User not found.' : "システムエラーです。利用者IDが見つかりません。");
                return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/index/e' : "/");
            }
        } catch (Exception $e) {
            throw $e;
        }

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = ($this->session->has(self::FLG_LANGOVERRIDE)) ? new UserProfileEForm() : new UserProfileForm();     // 2020/03/01
            if (!$form->isValid($post, $user)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/users/profilee' : 'users/profile');  // 2020/03/01
            }

            try {
                if ($user->save(array(
                            'user_nickname' => $post['user_nickname'],
                            'user_name' => $post['user_name'],
                                )
                        ) == false) {
                    foreach ($contract->getMessages() as $message) {
                        $this->flash->error($message);
                    }

                    return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/users/profilee' : 'users/profile');  // 2020/03/01
                }
            } catch (Exception $e) {
                throw $e;
            }

            $form->clear();
            $this->flash->success(($this->session->has(self::FLG_LANGOVERRIDE)) ? 'Profile is updated.' : "プロファイルを設定しました");
            
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_PROFILE, array($auth['user_id'], 'Done'));

            /*
            $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
            $this->view->userName = $auth['name'];
            $this->mail($auth['user_id'], '[MPX] パスワードを設定しました', 'setpwd', $header);
             * 
             */
            return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/index/e' : "/");
        }

        $this->user = $user;
        // $this->view->form = new UserProfileForm($user);
        $this->view->form = ($this->session->has(self::FLG_LANGOVERRIDE)) ? new UserProfileEForm($user) : new UserProfileForm($user);
    }

    public function setpwdeAction()
    {   // 2020/03/01
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->setpwdAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/users/setpwd';   // 日本語ページへのリンク        
    }
    
    public function profileeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->profileAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/users/profile';   // 日本語ページへのリンク
    }
}
