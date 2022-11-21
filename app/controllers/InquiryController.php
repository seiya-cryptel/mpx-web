<?php

class InquiryController extends ControllerBase
{
    const SV_POST = 'InquiryControllerPost';

    private function _sendInquiry($subj, $body) {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        $auth = $this->session->get('auth');
        $to = $this->sysSetting['INQUIRY_MAIL_TO'][0];
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
        /* 2020/03/01
        $this->view->user_id = $auth['user_id'];
        $this->view->user_name = $auth['name'];
        // $this->view->email = $email; 2020/02/29
        $this->view->subj = $subj;   // 2020/02/29 変数名 subject を使うとバグる
        $this->view->body = $body;
        $ret = $this->mail($to, $siteMark . '[MPX] 問い合わせ', 'inquiry', $header);   // 2020/02/28
         * 
         */

        // $this->view->subject = $subj;
        // $this->view->body = $body;
        // $this->mail($to, '[MPX] 問い合わせ', 'inquiry', $header);
        $user_id = $auth['user_id'];
        $user_name = $auth['name'];
        $mailbody  = "\n送信者: $user_id $user_name\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($to, $siteMark . '[MPX] 問い合わせ', $mailbody, $header);
        
        // 問い合わせ者へ
        $to = $auth['user_id'];
        // $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
        // $this->view->subject = $subj;     2020/02/29
        // $this->view->subj = $subj;
        // $this->view->body = $body;
        // $ret = $this->mail($to, $this->isJa() ? 'お問い合わせを承りました（株式会社MPX サービス担当）' : '[MPX] Your inquily has been sent', 'inquiryCopy', $header);
        // $ret = $this->mail($to, $this->isJa() ? 'お問い合わせを承りました（株式会社MPX サービス担当）' : '[MPX] Your inquily has been sent', 'inquirycopy', $header);
        // var_dump($ret);exit(0);

        $mailbody  = "\nＭＰＸについてのお問合せをいただきありがとうございます。\n\n以下の内容で送信されました\n\n";
        $mailbody .= "\n送信者: $user_id $user_name 様\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($to, $siteMark . 'お問い合わせを承りました（株式会社MPX）', $mailbody, $header);
    }

    private function _sendInquiryE($subj, $body) {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        $auth = $this->session->get('auth');
        $to = $this->sysSetting['INQUIRY_MAIL_TO'][0];
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];

        $user_id = $auth['user_id'];
        $user_name = $auth['name'];
        $mailbody  = "\n送信者: $user_id $user_name\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($to, $siteMark . '[MPX] 問い合わせ', $mailbody, $header);
        
        // 問い合わせ者へ
        $to = $auth['user_id'];
        $mailbody  = "\nThank you for your inquiry about MPX.\n\nWe have received your inquiry as follows.\n\n";
        $mailbody = "\nHi, $user_id $user_name\n\n";
        $mailbody .= "Subject: $subj\n\n";
        $mailbody .= "Detail:\n$body\n\n";
        $mailbody .= "--\nPlease contact to G Arao or A Toishigawa\n";
        $mailbody .= "MPX, Inc.\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($to, $siteMark . '[MPX] Your inquily has been sent', $mailbody, $header);
    }

    // 以下未使用
    private function _sendInquiryV2($subj, $body) {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        $auth = $this->session->get('auth');
        $to = $auth['user_id'];
        $hdr = 'From: ' . $this->sysSetting['MAIL_FROM'][0];
        $hdr .= "\nBcc: " . $this->sysSetting['INQUIRY_MAIL_TO'][0];
        $this->view->user_id = $auth['user_id'];
        $this->view->user_name = $auth['name'];
        // $this->view->email = $email; 2020/02/29
        $this->view->subj = $subj;   // 2020/02/29 変数名 subject を使うとバグる
        $this->view->body = $body;
        $ret = $this->mail($to, $this->isJa() ? 'お問い合わせを承りました（株式会社MPX）' : '[MPX] Your inquily has been sent', 'inquiryCopy', $hdr);
    }

    private function _sendGuestInquiry($email, $corp, $name, $subj, $body) {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        $to = $this->sysSetting['INQUIRY_MAIL_TO'][0];
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];  // 2017/06/02 戻す
        $mailbody  = "\n送信者: $corp $name\n\n";
        $mailbody .= "メールアドレス: $email\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";
        mb_send_mail($to, $siteMark . '[MPX] ゲスト問い合わせ', $mailbody, $header);
        
        // 問い合わせ者へ
        $to = $email;
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
        $mailbody  = "\nＭＰＸについてのお問合せをいただきありがとうございます。\n以下の内容で送信されました。\n\n";
        $mailbody .= "送信者: $corp $name 様\n\n";
        $mailbody .= "メールアドレス: $email\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";
        mb_send_mail($to, $siteMark . 'お問い合わせを承りました（株式会社MPX）', $mailbody, $header);
    }

    private function _sendGuestInquiryE($email, $corp, $name, $subj, $body) {
        $siteMark = empty($this->config->application->siteMark) ? '' : $this->config->application->siteMark; // 2018/10/15
        $to = $this->sysSetting['INQUIRY_MAIL_TO'][0];
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];  // 2017/06/02 戻す
        $mailbody  = "\n送信者: $corp $name\n\n";
        $mailbody .= "メールアドレス: $email\n\n";
        $mailbody .= "件名: $subj\n\n";
        $mailbody .= "本文:\n$body\n\n";
        $mailbody .= "--\n≪お問い合わせ≫\n株式会社MPX　荒生、土石川\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";
        mb_send_mail($to, $siteMark . '[MPX] ゲスト問い合わせ', $mailbody, $header);
        
        // 問い合わせ者へ
        $to = $email;
        $header = 'From:' . $this->sysSetting['MAIL_FROM'][0];
        $mailbody  = "\nThank you for contacting us.\nWe have received your inquiry as follows.\n\n";
        $mailbody .= "$name, $corp\n\n";
        $mailbody .= "Email Address: $email\n\n";
        $mailbody .= "Subject: $subj\n\n";
        $mailbody .= "Detail:\n$body\n\n";
        $mailbody .= "--\nPlease contact to G Arao or A Toishigawa\n";
        $mailbody .= "MPX, Inc.\n";
        $mailbody .= "TEL：03-6386-8327\nE-mail：mpx-ml@mpx.co.jp\n";        
        mb_send_mail($to, $siteMark . '[MPX] Your inquily has been sent', $mailbody, $header);
    }
    
    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->en = '/inquiry/e';   // 英語ページへのリンク 2020/01/28
        
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            if($post['mode'] == 'entry') {
                $form = new InquiryForm(null, ['mode' => 'entry']);
                if ( ! $form->isValid($post, null) ) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    $this->view->mode = 'entry';
                    $this->view->form = $form;
                }
                else {
                    $form = new InquiryForm(null, ['mode' => 'confirm']);
                    $form->isValid($post, null);
                    $this->view->mode = 'confirm';
                    $this->view->form = $form;
                }
            }
            else {
                // $this->_sendInquiry($post['subject'], $post['body']);    2020/02/29
                $this->_sendInquiry($post['subject'], $post['body']);
                $this->flash->success('問い合わせメールを送信しました。');
                return $this->response->redirect('/');
            }
        }
        else {
            $this->view->mode = 'entry';
            $this->view->form = new InquiryForm(null, ['mode' => 'entry']);
        }
    }

    public function guestAction()
    {
        $this->view->setMainView('notlogin'); // 2016/05/16
        $this->view->en = '/inquiry/gueste';   // 2020/01/28
        $this->setLang('ja');
        
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            if($post['mode'] == 'entry') {
                $form = new InquiryGuestForm(null, ['mode' => 'entry']);
                if ( ! $form->isValid($post, null) ) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    $this->view->mode = 'entry';
                    $this->view->form = $form;
                }
                else {
                    $form = new InquiryGuestForm(null, ['mode' => 'confirm']);
                    $form->isValid($post, null);
                    $this->view->mode = 'confirm';
                    $this->view->form = $form;
                }
            }
            else {
                // $this->_sendGuestInquiry($post['email1'], $post['guest_name'], $post['subject'], $post['body']); 2018/02/27
                $this->_sendGuestInquiry($post['email1'], $post['guest_corp'], $post['guest_name'], $post['subject'], $post['body']);
                $this->flash->success('問い合わせメールを送信しました。');
                return $this->response->redirect('/');
            }
        }
        else {
            $this->view->mode = 'entry';
            $this->view->form = new InquiryGuestForm(null, ['mode' => 'entry']);
        }
    }

    // 2020/01/29
    public function eAction()
    {
        $this->view->setMainView('indexe'); // 2016/05/16
        $this->view->ja = '/inquiry/';   // 2020/01/28
        
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            if($post['mode'] == 'entry') {
                $form = new InquiryFormE(null, ['mode' => 'entry']);    // 2020/03/01
                if ( ! $form->isValid($post, null) ) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    $this->view->mode = 'entry';
                    $this->view->form = $form;
                }
                else {
                    $form = new InquiryFormE(null, ['mode' => 'confirm']);  // 2020/03/01
                    $form->isValid($post, null);
                    $this->view->mode = 'confirm';
                    $this->view->form = $form;
                }
            }
            else {
                $this->_sendInquiryE($post['subj'], $post['body']);
                $this->flash->success('Inquiry mail is sent.');
                return $this->response->redirect('/index/e');
            }
        }
        else {
            $this->view->mode = 'entry';
            $this->view->form = new InquiryFormE(null, ['mode' => 'entry']);    // 2020/03/01
        }
    }
    
    public function guesteAction()
    {
        $this->view->setMainView('notlogine'); // 2016/05/16
        $this->view->ja = '/inquiry/guest';   // 2020/01/28
        $this->setLang('en');
       
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            if($post['mode'] == 'entry') {
                $form = new InquiryGuestEForm(null, ['mode' => 'entry']);
                if ( ! $form->isValid($post, null) ) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                    $this->view->mode = 'entry';
                    $this->view->form = $form;
                }
                else {
                    $form = new InquiryGuestForm(null, ['mode' => 'confirm']);
                    $form->isValid($post, null);
                    $this->view->mode = 'confirm';
                    $this->view->form = $form;
                }
            }
            else {
                // $this->_sendGuestInquiry($post['email1'], $post['guest_name'], $post['subject'], $post['body']); 2018/02/27
                $this->_sendGuestInquiryE($post['email1'], $post['guest_corp'], $post['guest_name'], $post['subject'], $post['body']);
                $this->flash->success('Inquiry mail is sent.');
                return $this->response->redirect('/index/e');
            }
        }
        else {
            $this->view->mode = 'entry';
            $this->view->form = new InquiryGuestForm(null, ['mode' => 'entry']);
        }
    }
}
