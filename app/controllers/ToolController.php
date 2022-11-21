<?php

// 2017/05/21
class ToolController extends ControllerBase
{
    // ツールリスト
    public function indexAction()
    {
        $this->view->en = '/tool/en';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {   // 認証済みユーザのみ
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if($auth['role'] < 1) 
        if(($auth_bits & $this->authority['FC_SYS_MONTHLY']) == 0)  // 2018/10/07
        {   // 2018/03/30
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $user = Users::findFirst(
                    array(
                        'conditions' => '(id=:userId:)',
                        'bind' => array('userId' => $auth['user_id']),
                    )
                );
        $tools = Tools::find(
                    array(
                        'conditions' => '(isvalid=1)',
                        'order' => 'no',
                    )
                );
        // 2017/05/26
        $mytools = array();
        foreach($tools as $tool)
        {
            /* 2019/02/15
            switch($tool->no)
            {
                // 2018/10/07
                case 1: if($auth_bits & $this->authority['TOOL_DOWNLOAD'])    $mytools[] = $tool; break;
                case 2: if($auth_bits & $this->authority['TOOL_SIM_FUEL_EXCHANGE'])    $mytools[] = $tool; break;
                case 3: if($auth_bits & $this->authority['TOOL_SIM_THERMAL'])    $mytools[] = $tool; break;
                case 4: if($auth_bits & $this->authority['TOOL_SIM_MONTE_CARLO'])    $mytools[] = $tool; break;
                case 5: if($user->dl_tool05)    $mytools[] = $tool; break;
                case 6: if($user->dl_tool06)    $mytools[] = $tool; break;
                case 7: if($user->dl_tool07)    $mytools[] = $tool; break;
                case 8: if($user->dl_tool08)    $mytools[] = $tool; break;
                case 9: if($user->dl_tool09)    $mytools[] = $tool; break;
                case 10: if($user->dl_tool10)    $mytools[] = $tool; break;
                default:
                // ignore
            }
             * 
             */
            $auth_name = $tool->auth_name;  // 2019/02/15
            if((!empty($this->authority[$auth_name])) && ($auth_bits & $this->authority[$auth_name]))
            {
                $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . '%s %s %s ', array($auth_name, $this->authority[$auth_name], $auth_bits));
                $mytools[] = $tool;
            }
        }
        // $this->view->tools = $tools;
        $this->view->tools = $mytools;
    }
    
    // ダウンロード
    public function dlAction($no, $fileName)
    {
        $this->view->en = '/tool/dle';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {   // 認証済みユーザのみ
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if($auth['role'] < 1) 
        if(($auth_bits & $this->authority['FC_SYS_MONTHLY']) == 0)  // 2018/10/07
        {   // 2018/03/30
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $tool = Tools::findFirst(
                    array(
                        'conditions' => '(isvalid=1) AND (no=:no:)',
                        'bind' => ['no' => $no],
                    )
                );
        // 番号チェック
        if(empty($tool)) {
            // $this->flash->error('ツール番号が見つかりません。');
            $this->flash->error(($this->isOvr()) ? 'No tool found.' : 'ツール番号が見つかりません。');  // 2020/03/01
            // return $this->response->redirect('/tool/');
            return $this->response->redirect(($this->isOvr()) ? '/tool/en' : '/tool/');  // 2020/03/01
        }
        
        $this->view->disable();
        
        // $strFile = '/usr/share/nginx/data/tool/' . $tool->file_path; 2018/04/27
        $strFile = $this->config->application->uploadDir . "tool/" . $tool->file_path;
        $binData = file_get_contents($strFile);
        $len = strlen($binData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", $tool->content_type);
        // $response->setHeader("Content-Disposition", 'attachment; filename*=\'\'' . rawurlencode($strFile));
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($binData);
        $response->send();
    }
    
    // 追加ファイル リスト
    public function flistAction()
    {
        $this->view->en = '/tool/fliste';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {   // 認証済みユーザのみ
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if($auth['role'] < 1) 
        if(($auth_bits & $this->authority['FC_SYS_MONTHLY']) == 0)  // 2018/10/07
        {   // 2018/03/30
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $DFiles = AdditionalFiles::find(
                    array(
                        'conditions' => '(isvalid=1)',
                        'order' => 'no DESC',
                    )
                );
        // 2017/05/26
        $myfiles = array();
        $role = $auth['role'];
        foreach($DFiles as $DFile)
        {
            $rolearray = explode(' ', $DFile->privillage);
            if(array_search($role, $rolearray) !== false)
            {
                $myfiles[] = $DFile;
            }
        }
        // $this->view->tools = $tools;
        $this->view->files = $myfiles;
    }
    
    // ダウンロード
    public function dfAction($id)
    {
        $this->view->en = '/tool/dfe';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {   // 認証済みユーザのみ
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if($auth['role'] < 1) 
        if(($auth_bits & $this->authority['FC_SYS_MONTHLY']) == 0)  // 2018/10/07
        {   // 2018/03/30
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $DFile = AdditionalFiles::findFirst(
                    array(
                        'conditions' => '(isvalid=1) AND (id=:Id:)',
                        'bind' => ['Id' => $id],
                    )
                );
        // 番号チェック
        if(empty($DFile)) {
            // $this->flash->error('ファイル番号が見つかりません。');
            $this->flash->error(($this->isOvr()) ? 'No tool found.' : 'ツール番号が見つかりません。');  // 2020/03/01
            // return $this->response->redirect('/tool/');
            return $this->response->redirect(($this->isOvr()) ? '/tool/en' : '/tool/');  // 2020/03/01
        }
        
        $rolearray = explode(' ', $DFile->privillage);
        // var_dump($role);exit(0);
        $role = $auth['role'];
        if(array_search($role, $rolearray) === false)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $this->view->disable();
        
        // $strFile = '/usr/share/nginx/data/data/' . $DFile->filename; 2018/04/27
        $strFile = $this->config->application->uploadDir . "data/" . $DFile->filename;
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", $DFile->content_type);
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setFileToSend($strFile, $DFile->filename);       // 2018/03/01
        $response->send();
        /*
        $binData = file_get_contents($strFile);
        $len = strlen($binData);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", $DFile->content_type);
        $response->setHeader("Content-Disposition", 'attachment; filename=' . rawurlencode($DFile->filename));
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($binData);
        $response->send();
         * 
         */
    }
    
    // ダウンロードボタン表示
    public function dbAction($id)
    {
        $this->view->en = '/tool/dbe';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {   // 認証済みユーザのみ
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if($auth['role'] < 1) 
        if(($auth_bits & $this->authority['FC_SYS_MONTHLY']) == 0)  // 2018/10/07
        {   // 2018/03/30
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $DFile = AdditionalFiles::findFirst(
                    array(
                        'conditions' => '(isvalid=1) AND (id=:Id:)',
                        'bind' => ['Id' => $id],
                    )
                );
        // 番号チェック
        if(empty($DFile)) {
            // $this->flash->error('ファイル番号が見つかりません。');
            $this->flash->error(($this->isOvr()) ? 'No tool found.' : 'ツール番号が見つかりません。');  // 2020/03/01
            // return $this->response->redirect('/tool/');
            return $this->response->redirect(($this->isOvr()) ? '/tool/en' : '/tool/');  // 2020/03/01
        }
        
        $rolearray = explode(' ', $DFile->privillage);
        // var_dump($role);exit(0);
        $role = $auth['role'];
        if(array_search($role, $rolearray) === false)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        $this->view->dfile = $DFile;
    }
    
    // 2020/01/31
    public function enAction()
    {
        $this->indexAction();
        $this->view->setMainView('indexe');
        $this->view->ja = '/tool/';   // 日本語ページへのリンク
    }
    
    public function dleAction($no, $fileName)
    {
        $this->dlAction($no, $fileName);
        $this->view->setMainView('indexe');
        $this->view->ja = '/tool/dl/' . $no . '/' . $fileName;   // 日本語ページへのリンク
    }

    public function flisteAction()
    {
        $this->flistAction();
        $this->view->setMainView('indexe');
        $this->view->ja = '/tool/flist';   // 日本語ページへのリンク
    }
    public function dfeAction($id)
    {
        $this->dfAction($id);
        $this->view->setMainView('indexe');
        $this->view->ja = '/tool/df/' . $id;   // 日本語ページへのリンク
    }

    public function dbeAction($id)
    {
        $this->dbAction($id);
        $this->view->setMainView('indexe');
        $this->view->ja = '/tool/db/' . $id;   // 日本語ページへのリンク
    }
}
