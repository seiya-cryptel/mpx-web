<?php

class ManagementController extends ControllerBase
{
    const SV_UPDMAIL = 'ManagementControllerUPDMAIL';   // 2017/05/12

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
        
        
        // CSSのローカルリソースを追加します
        $this->assets
            ->addCss('css/dataTables/dataTables.bootstrap.min.css')
            ->addCss('css/dataTables/responsive.bootstrap.min.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
            ->addJs('js/dataTables/jquery.dataTables.min.js')
            ->addJs('js/dataTables/dataTables.bootstrap.min.js')
            ->addJs('js/dataTables/dataTables.responsive.min.js')
            ->addJs('js/dataTables/responsive.bootstrap.min.js')
            ->addJs('js/dataTables/dataTables.options.js');
    }

    public function indexAction()
    {
        $this->view->users = Users::find();
    }

    public function useraddAction()
    {
        $user = new Users();

        $this->view->updateMode = 'new';
        $this->view->form = new UsersForm($user, array('edit' => false));
        $this->view->pick('management/useredit');
    }

    public function usereditAction($id)
    {
        if (!$this->request->isPost()) {

            $user = Users::findFirst(
                            array(
                                'conditions' => 'id=:id:',
                                'bind' => array('id' => $id),
                            )
            );
            if (!$user) {
                $this->flash->error("ユーザが見つかりません");
                return $this->response->redirect("management");
            }

            $this->view->updateMode = 'edit';
            $this->view->form = new UsersForm($user, array('edit' => true));
        }
    }

    public function usercreateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("management");
        }

        $form = new UsersForm();
        $user = new Users();

        $post = $this->request->getPost();
        if (!isset($post['isvalid'])) {   // 2015/12/18
            $post['isvalid'] = false;
        }

        if (!$form->isValid($post, $user)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/useradd');
        }

        try {
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->response->redirect('management/useradd');
            }
        } catch (Exception $e) {
            throw $e;
        }

        $form->clear();

        $this->flash->success("ユーザを登録しました");
        return $this->response->redirect("management");
    }

    public function usersaveAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("management");
        }

        $id = $this->request->getPost("id");

        $user = Users::findFirst(
                        array(
                            'conditions' => 'id=:id:',
                            'bind' => array('id' => $id),
                        )
        );
        if (!$user) {
            $this->flash->error("ユーザが見つかりません");
            return $this->response->redirect("management");
        }

        $form = new UsersForm();
        $this->view->form = $form;

        $post = $this->request->getPost();
        if (!isset($post['isvalid'])) {   // 2015/12/18
            $post['isvalid'] = false;
        }

        if (!$form->isValid($post, $user)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/useredit/' . $id);
        }

        if ($user->save() == false) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/useredit/' . $id);
        }

        $form->clear();

        $this->flash->success("ユーザを保存しました");
        return $this->response->redirect("management");
    }

    public function userprofileAction()
    {
        // viewにデータを渡す
        $this->view->setVars(
                array(
//                    'active_login' => 'active'
                )
        );
    }

    public function accesslogAction()
    {
        $where = '';
        $binds = array();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new LogSearchForm();
            // 日時
            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                $post['dtfrom'] = date('Y-m-d H:i:s', strtotime($post['dtfrom']));
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                $post['dtto'] = date('Y-m-d H:i:s', strtotime($post['dtto']));
            }

            if (!$form->isvalid($post)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect('management/accesslog');
            }

            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(log_time >= :dtfrom:)";
                $binds['dtfrom'] = $post['dtfrom'];
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(log_time <= :dtto:)";
                $binds['dtto'] = $post['dtto'];
            }
            if ((!is_null($post['email']) ) && ($post['email'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(user_id LIKE :email:)";
                $binds['email'] = '%' . $post['email'] . '%';
            }
            if ((!is_null($post['logtype']) ) && ($post['logtype'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(log_message LIKE :logtype:)";
                $binds['logtype'] = $post['logtype'];
            }

            $logs = MyLogs::find(
                            array(
                                'conditions' => $where,
                                'bind' => $binds,
                                'order' => 'log_time DESC',
                                'limit' => 1000,
                            )
            );
        } else {
            $logs = MyLogs::find(
                            array(
                                'order' => 'log_time DESC',
                                'limit' => 1000,
                            )
            );
        }

        $this->view->form = new LogSearchForm; // 原因
        $this->view->logs = $logs;
    }

    public function datalistAction()
    {
        $where = '';
        $binds = array();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new UploadSearchForm();
            // 日時
            if ((!is_null($post['upfrom']) ) && ($post['upfrom'] != '')) {
                $post['upfrom'] = date('Y-m-d H:i:s', strtotime($post['upfrom']));
            }
            if ((!is_null($post['upto']) ) && ($post['upto'] != '')) {
                $post['upto'] = date('Y-m-d H:i:s', strtotime($post['upto']));
            }
            if ((!is_null($post['targetfrom']) ) && ($post['targetfrom'] != '')) {
                $post['targetfrom'] = date('Y-m-d', strtotime($post['targetfrom']));
            }
            if ((!is_null($post['targetto']) ) && ($post['targetto'] != '')) {
                $post['targetto'] = date('Y-m-d', strtotime($post['targetto']));
            }

            if (!$form->isvalid($post)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect('management/accesslog');
            }

            if ((!is_null($post['upfrom']) ) && ($post['upfrom'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(regdate >= :upfrom:)";
                $binds['upfrom'] = $post['upfrom'];
            }
            if ((!is_null($post['upto']) ) && ($post['upto'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(regdate <= :upto:)";
                $binds['upto'] = $post['upto'];
            }
            if ((!is_null($post['targetfrom']) ) && ($post['targetfrom'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(target_date >= :targetfrom:)";
                $binds['targetfrom'] = $post['targetfrom'];
            }
            if ((!is_null($post['targetto']) ) && ($post['targetto'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(target_date <= :targetto:)";
                $binds['targetto'] = $post['targetto'];
            }
            if ((!is_null($post['email']) ) && ($post['email'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(user_id LIKE :email:)";
                $binds['email'] = '%' . $post['email'] . '%';
            }
            if ((!is_null($post['logtype']) ) && ($post['logtype'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(log_message LIKE :logtype:)";
                $binds['logtype'] = $post['logtype'];
            }

            $uploads = Uploads::find(
                            array(
                                'conditions' => $where,
                                'bind' => $binds,
                                'limit' => 1000,
                            )
            );
        }
        else {
            $uploads = Uploads::find(
                            array(
                                'limit' => 1000,
                            )
            );
        }

        $this->view->form = new UploadSearchForm;
        $this->view->uploads = $uploads;
    }

    // ニュース管理
    public function newsAction()
    {
        $where = '';
        $binds = array();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new NewsSearchForm();
            // 日時
            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                $post['dtfrom'] = date('Y-m-d H:i:s', strtotime($post['dtfrom']));
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                $post['dtto'] = date('Y-m-d H:i:s', strtotime($post['dtto']));
            }

            if (!$form->isvalid($post)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect('management/accesslog');
            }

            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(date_notice >= :dtfrom:)";
                $binds['dtfrom'] = $post['dtfrom'];
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(date_notice <= :dtto:)";
                $binds['dtto'] = $post['dtto'];
            }

            $news = Notices::find(
                            array(
                                'conditions' => $where,
                                'bind' => $binds,
                                'order' => 'date_notice DESC',
                                'limit' => 1000,
                            )
            );
        } else {
            $news = Notices::find(
                            array(
                                'order' => 'date_notice DESC',
                                'limit' => 1000,
                            )
            );
        }

        $this->view->form = new NewsSearchForm; // 原因
        $this->view->news = $news;
    }

    // ニュース お知らせ登録・編集・削除
    public function newspostAction()
    {
        $news = new Notices();

        $this->view->updateMode = 'new';
        $this->view->form = new NewsForm($news, array('edit' => false));
        $this->view->pick('management/newsedit');
    }
    
    public function newseditAction($id)
    {
        if (!$this->request->isPost()) {

            $news = Notices::findFirst(
                            array(
                                'conditions' => 'id=:newsId:',
                                'bind' => array('newsId' => $id),
                            )
            );
            if (! $news) {
                $this->flash->error("お知らせが見つかりません");
                return $this->response->redirect("management");
            }

            $this->view->updateMode = 'edit';
            $this->view->form = new NewsForm($news, array('edit' => true));
        }
    }
    
    public function newscreateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("management");
        }

        $form = new NewsForm();
        $news = new Notices();

        $post = $this->request->getPost();
        if (!isset($post['publish'])) {   // 2015/12/18
            $post['publish'] = false;
        }
        if (!isset($post['isvalid'])) {   // 2015/12/18
            $post['isvalid'] = false;
        }

        if (!$form->isValid($post, $news)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/newspost');
        }

        try {
            if ($news->save() == false) {
                foreach ($news->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->response->redirect('management/newspost');
            }
        } catch (Exception $e) {
            throw $e;
        }

        $form->clear();

        $this->flash->success("お知らせを登録しました");
        return $this->response->redirect("management");
    }
    
    public function newssaveAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("management");
        }

        $id = $this->request->getPost("id");

        $news = Notices::findFirst(
                        array(
                            'conditions' => 'id=:newsId:',
                            'bind' => array('newsId' => $id),
                        )
        );
        if (! $news) {
            $this->flash->error("お知らせが見つかりません");
            return $this->response->redirect("management");
        }

        $form = new NewsForm();
        $this->view->form = $form;

        $post = $this->request->getPost();
        if (!isset($post['publish'])) {   // 2015/12/18
            $post['publish'] = false;
        }
        if (!isset($post['isvalid'])) {   // 2015/12/18
            $post['isvalid'] = false;
        }

        if (!$form->isValid($post, $news)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/newsedit/' . $id);
        }

        if ($news->save() == false) {
            foreach ($news->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/newsedit/' . $id);
        }

        $form->clear();

        $this->flash->success("お知らせを保存しました");
        return $this->response->redirect("management");
   }

    // レポート一覧
    public function reportAction()
    {
        $where = '';
        $binds = array();

        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            $form = new NewsSearchForm();
            // 日時
            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                $post['dtfrom'] = date('Y-m-d H:i:s', strtotime($post['dtfrom']));
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                $post['dtto'] = date('Y-m-d H:i:s', strtotime($post['dtto']));
            }

            if (!$form->isvalid($post)) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect('management/mreport');
            }

            $where = "(category LIKE 'REPORT%')";
            
            if ((!is_null($post['dtfrom']) ) && ($post['dtfrom'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(date_notice >= :dtfrom:)";
                $binds['dtfrom'] = $post['dtfrom'];
            }
            if ((!is_null($post['dtto']) ) && ($post['dtto'] != '')) {
                if ($where != '')
                    $where .= ' AND ';
                $where .= "(date_notice <= :dtto:)";
                $binds['dtto'] = $post['dtto'];
            }

            $news = Notices::find(
                            array(
                                'conditions' => $where,
                                'bind' => $binds,
                                'order' => 'date_notice DESC',
                                'limit' => 1000,
                            )
            );
        } else {
            $news = Notices::find(
                            array(
                                'conditions' => "category LIKE 'REPORT%'",
                                'order' => 'date_notice DESC',
                                'limit' => 1000,
                            )
            );
        }

        $this->view->form = new NewsSearchForm;
        $this->view->news = $news;
    }

    // レポート登録
    public function reportpostAction()
    {
        $news = new Notices();

        $this->view->updateMode = 'new';
        $this->view->form = new ReportForm($news, array('edit' => false));
    }
    
    // レポート ディレクトリを決める 2020/01/30
    private function _reportDirectory($category)
    {
        $dir = null;
        switch($category) {
            case 'REPORT_M':
                $dir = $this->config->application->uploadDir . 'rm/';
                break;
            case 'REPORT_W':
                $dir = $this->config->application->uploadDir . 'rw/';
                break;
            case 'REPORT_LFC':  // 2017/097/12
                $dir = $this->config->application->uploadDir . 'rlfc/';
                break;
            case 'REPORT_GS':  // 2017/11/15
                $dir = $this->config->application->uploadDir . 'rgs/';
                break;
            case 'REPORT_VA':  // 2018/04/29
                $dir = $this->config->application->uploadDir . 'rva/';
                break;
            case 'REPORT_RP':  // 2018/04/29
                $dir = $this->config->application->uploadDir . 'rrp/';
                break;
            default:
                $dir = $this->config->application->uploadDir . 'misc/';
                break;
        }
        return $dir;
    }

    // レポート保存
    public function reportcreateAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect("management");
        }

        $form = new ReportForm();
        $news = new Notices();

        $post = $this->request->getPost();
        if (!isset($post['publish'])) {   // 2015/12/18
            $post['publish'] = false;
        }
        if (!isset($post['isvalid'])) {   // 2015/12/18
            $post['isvalid'] = false;
        }

        // アップロードファイルをコピー
        if (! $this->request->hasFiles()) {
            $this->flash->error('レポートＰＤＦファイルを指定してください。');
            return $this->response->redirect('management/reportpost');
        }
        $UploadFiles = $this->request->getUploadedFiles();
        // var_dump(count($UploadFiles));exit(0);
        $countFiles = count($UploadFiles);
        if($countFiles > 2)
        {
            $this->flash->error('レポートＰＤＦファイルが 2 つ以上指定されました。');
            return $this->response->redirect('management/reportpost');
        }

        // var_dump($UploadFiles[0]->getName());exit(0);
        // 日本語レポート
        $file = $UploadFiles[0];
        $fileName = $file->getName();
        $nPos = strrpos($fileName, '.', 1);
        $filebody = substr($fileName, 0, $nPos);
        $dir = $this->_reportDirectory($post['category']);
        // var_dump($dir);exit(0);
        $outFilePath = $dir . $fileName;
        $file->moveTo($outFilePath);     
        $post['url'] = $filebody;
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_UPLOAD, array($fileName, 'Done'));
        // 英語レポート
        if($countFiles > 1)
        {
            $file = $UploadFiles[1];
            $fileName = $file->getName();
            $nPos = strrpos($fileName, '.', 1);
            $filebody = substr($fileName, 0, $nPos);
            $dir = $this->_reportDirectory($post['category']);
            // var_dump($dir);exit(0);
            $outFilePath = $dir . $fileName;
            $file->moveTo($outFilePath);     
            $post['url_e'] = $filebody;
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_UPLOAD, array($fileName, 'Done'));
        }

        /*
        foreach ($this->request->getUploadedFiles() as $file) {
            $fileName = $file->getName();
            $nPos = strrpos($fileName, '.', 1);
            $filebody = substr($fileName, 0, $nPos);
            $dir = $this->_reportDirectory($post['category']);
            $outFilePath = $dir . $fileName;
            $file->moveTo($outFilePath);     
            
            $post['url'] = $filebody;
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_UPLOAD, array($file->getName(), 'Done'));
        }
         * 
         */

        if (!$form->isValid($post, $news)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->response->redirect('management/reportpost');
        }

        $isUpdate = false;
        try {
            // 配信日、カテゴリ、日本語タイトルが同じなら置換する 2020/01/30
            $Notice = Notices::findFirst([
                        'conditions' => '(date_notice=:Date:) AND (category=:Cat:) AND (title=:Ttl:)',
                        'bind' => [
                            'Date' => $post['date_notice'],
                            'Cat' => $post['category'],
                            'Ttl' => $post['title'],
                        ],
                    ]);
            if($Notice)
            {
                $Notice->delete();
                $isUpdate = true;
            }
            
            if ($news->save() == false) {
                foreach ($news->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->response->redirect('management/reportpost');
            }
        } catch (Exception $e) {
            throw $e;
        }

        $form->clear();

        $this->flash->success($isUpdate ? 'レポートを更新しました' : "レポートを登録しました");
        return $this->response->redirect("management/report");
    }

    // データ更新通知メール送信処理 2017/05/12
    // deguchi メールタイトル & 問い合わせ先修正 2019/05/22
    private function _updatedMailSend($post)
    {
        $updatedlist = $post['updatedlist'];
        $updatedsubj = $post['updatedsubj']; // deguchi修正
 
        $cntUser = 0;
        try {
            $users = Users::query()
                    ->where('isvalid=1')
                    ->andWhere('mail_flag=:flag:', ['flag' => '1'])
                    ->orderBy('id')
                    ->execute();
            
            foreach($users as $user) {
                $to = $user->id;
                $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];

                /* 2018/10/16
                $this->view->mailto_org = $user->mailto_org;
                $this->view->mailto_name = $user->mailto_name;
                $this->view->updatedlist = $updatedlist;
                // $this->mail($to, '[MPX]データを更新しました', 'updatedlist', $header); 2017/05/22
                $this->mail($to, $this->sysSetting['UPDATED_MAIL_SUBJ'][0], 'updatedlist', $header);
                 * 
                 */

                $mailbody  = "\n $updatedlist\n\n"; // 2018/10/16
                $mailbody .= "--\n≪お問い合わせ (Contact)≫\n株式会社MPX (MPX, Inc.)\n荒生、土石川 (Arao or Toishigawa)\n";
                $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";
                mb_send_mail($to, $siteMark . '[MPX]' . $updatedsubj , $mailbody, $header); // deguchi修正

                // mb_send_mail($to, $siteMark . '[MPX]' . $this->sysSetting['UPDATED_MAIL_SUBJ'][0] , $mailbody, $header);
                $cntUser++;
            }
        } catch (Exception $e) {
            throw $e;
        }
       
        $this->session->remove(self::SV_UPDMAIL);
        $this->flash->success($cntUser . '件のメールを送信しました。');
        return $this->response->redirect('management/updatedmail');
    }

    // データ更新通知メール送信 入力後 2017/05/12
    // deguchi メールタイトル修正 2019/05/22
    private function _updatedMailConfirm($post)
    {
        $form = new UpdatedMailForm();

        if (!$form->isvalid($post)) 
        {   // エラーあり
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->session->set(self::SV_UPDMAIL, $post);   // POST データを編集用に保存
            return $this->response->redirect('management/updatedmail');
        }
        
        $this->flash->warning('本文の内容を確認して送信してください。');
        $form = new UpdatedMailForm(null,['mode' => 'confirm']);
        $form->get('updatedlist')->setDefault($post['updatedlist']);
        $form->get('updatedsubj')->setDefault($post['updatedsubj']); // deguchi修正
        $this->view->mode = 'confirm';
        $this->view->form = $form;
    }

    // データ更新通知メール GET 2017/05/12
    // deguchi メールタイトル修正 2019/05/22
    private function _updatedMailEntry()
    {
        if ($this->session->has(self::SV_UPDMAIL))
        {
            $post = $this->session->get(self::SV_UPDMAIL);
            $form = new UpdatedMailForm(null, ['mode' => 'entry']);
            $form->get('updatedlist')->setDefault($post['updatedlist']);
            $form->get('updatedsubj')->setDefault($post['updatedsubj']); // deguchi修正
        }
        else
        {
            $form = new UpdatedMailForm(null, ['mode' => 'entry']);
        }
        $this->view->mode = 'entry';
        $this->view->form = $form;
    }

    // データ更新通知メール送信アクション 2017/05/12
    public function updatedmailAction()
    {
        if ($this->request->isPost()) 
        {   // POST
            $post = $this->request->getPost();
            if($post['mode'] == 'confirm')
            {   // 確認終了→送信
                $this->_updatedMailSend($post);
            }
            else
            {   // 入力終了→確認
                $this->_updatedMailConfirm($post);
            }
        }
        else 
        {   // GET
            $this->_updatedMailEntry();
        }
    }
}
