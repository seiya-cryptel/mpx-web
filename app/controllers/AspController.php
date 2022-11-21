<?php

class AspController extends ControllerBase
{
    // Root パス
    // const FolderRoot = '/usr/share/nginx/data/folder/';      2018/04/26
    
    // セッション変数
    const SV_PATH = 'AspController_Path';

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->en = '/asp/en';   // 英語ページへのリンク 2020/01/28
        
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');
        }
        
        // 物理パスを求める
        // $path = self::FolderRoot;    2018/04/26
        $path = $this->config->application->uploadDir . 'folder/';
        $relativePath = '/';    // 2018/10/21        
        if($this->session->has(self::SV_PATH))
        {
            $sv_path_value = $this->session->get(self::SV_PATH);        // 2018/10/19
            if(!empty(($sv_path_value)))
            {
                if(is_array($sv_path_value))
                {
                    $path .= implode('/', $sv_path_value);
                    $relativePath .= implode('/', $sv_path_value);
                }
                else
                {
                    $path .= ($sv_path_value . '/');
                    $relativePath .= ($sv_path_value . '/');
                }
            }
        }
        // ファイル一覧を求める
        $fileNames = scandir($path);
        $fileList = array();
        foreach($fileNames as $fileName)
        {
            $fileInfo = array();
            if(substr($fileName, 0, 1) == '.') continue;
            $fileInfo['name'] = $fileName;
            $filepath = $path . '/' . $fileName;
            // $this->flash->error($filepath . ' ' . is_dir($filepath));
            if(is_dir($filepath))
            {
                $fileInfo['type'] = 'dir';
            }
            else
            {
                $fileInfo['type'] = 'file';
                $fileInfo['size'] = $this->filesizeDisp(filesize($filepath));
                $fileInfo['datetime'] = date('Y-m-d H:i:s', filemtime($filepath));
            }
            $fileList[] = $fileInfo;
        }
        
        // $abc = self::SV_PATH;
        // $this->view->path = '/' . implode('/', $this->session->get(self::SV_PATH));
        $this->view->path = $relativePath;  // 2018/10/21
        $this->view->filelist = $fileList;

        $this->assets->addCss('https://use.fontawesome.com/releases/v5.0.6/css/all.css')
                ->addCss('https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css')
                ;
        $this->assets->addJs('https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js')
                ->AddJs('https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js')
                ->AddJs('js/asp/index.js')
                ;
    }
    
    public function topAction()
    {
        //
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // パスを削除
        $this->session->remove(self::SV_PATH);
        // return $this->response->redirect('/asp/');
        return $this->response->redirect(($this->isOvr()) ? '/asp/en' : '/asp/');   // 2020/03/01
    }
    
    public function upAction()
    {
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // 最下位のディレクトリを削除
        // $prev = $this->session->get(self::SV_PATH);
        if($this->session->has(self::SV_PATH))
        {
            $path = $this->session->get(self::SV_PATH);
            // if(count($path) < 1)
            if(is_array($path))
            {
                if(count($path) > 1)     // 2018/10/21
                {
                    $this->session->set(self::SV_PATH, array_pop($path));
                }
                else
                {
                    $this->session->remove(self::SV_PATH);
                }
            }
            else
            {
                $this->session->remove(self::SV_PATH);
            }
        }
        // $next = $this->session->get(self::SV_PATH);
        // var_dump($next);exit(0);
        // return $this->response->redirect('/asp/');
        return $this->response->redirect(($this->isOvr()) ? '/asp/en' : '/asp/');   // 2020/03/01
    }
    
    public function folderAction($folderName)
    {
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // 最下位のディレクトリを追加
        $folderName = urldecode($folderName);
        $path = array();
        if($this->session->has(self::SV_PATH))
        {
            $path = $this->session->get(self::SV_PATH);
            if(! is_array($path))
            {
                $path = array();
                $this->session->remove(self::SV_PATH);
            }
        }
        $path[] = $folderName;
        $this->session->set(self::SV_PATH, $path);
        // return $this->response->redirect('/asp/');
        return $this->response->redirect(($this->isOvr()) ? '/asp/en' : '/asp/');   // 2020/03/01
    }
    
    public function fileAction($fileName)
    {
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // ファイル Path
        $fileName = urldecode($fileName);
        /* 2018/10/19
        if($this->session->has(self::SV_PATH))
        {
            // $dirPath = self::FolderRoot . implode('/', $this->session->get(self::SV_PATH)) . '/';    2018/04/26
            $dirPath = $this->config->application->uploadDir . 'folder/' . implode('/', $this->session->get(self::SV_PATH)) . '/';
        }
        else
        {
            // $dirPath = self::FolderRoot; 2018/04/26
            $dirPath = $this->config->application->uploadDir . 'folder/';
        }
         * 
         */
        $dirPath = $this->config->application->uploadDir . 'folder/';
        if($this->session->has(self::SV_PATH))
        {
            $sv_path_value = $this->session->get(self::SV_PATH);        // 2018/10/19
            if(!empty(($sv_path_value)))
            {
                if(is_array($sv_path_value))
                {
                    $dirPath = $this->config->application->uploadDir . 'folder/' . implode('/', $sv_path_value) . '/';
                }
                else
                {
                    $dirPath = $this->config->application->uploadDir . 'folder/' . $sv_path_value . '/';                    $this->view->path = '/' . $sv_path_value;
                }
            }
        }
        $filePath = $dirPath . $fileName;
        
        // フォルダなら ZIP 化
        $tmpPath = null;
        if(is_dir($filePath))
        {
            $tmpPath = tempnam('/tmp', '');
            $this->zipDirectory($dirPath, $fileName, $tmpPath);
            $filePath = $tmpPath;
            $fileName .= '.zip';
        }
        
        // ダウンロード
        $this->view->disable();
        
        $FInfo = new SplFileInfo($filePath);
        $ext = $FInfo->getExtension();
        switch (strtolower($ext))
        {
            case 'csv':
                $ctype = 'text/csv'; break;
            case 'pdf':
                $ctype = 'application/pdf'; break;
            case 'xls':
            case 'xlsx':
            case 'xlsm':
                $ctype = 'application/vnd.ms-excel'; break;
            case 'ppt':
            case 'pptx':
                $ctype = 'application/vnd.ms-powerpoint'; break;
            case 'doc':
            case 'docx':
                $ctype = 'application/msword'; break;
            case 'jpg':
            case 'jpeg':
                $ctype = 'image/jpeg'; break;
            case 'png':
                $ctype = 'image/png'; break;
            case 'gif':
                $ctype = 'image/gif'; break;
            case 'bmp':
                $ctype = 'image/bmp'; break;
            case 'zip':
                $ctype = 'application/zip'; break;
            default:
                $ctype = 'text/plain'; break;
        }
        
        ob_clean(); // 2018/10/19

        // $res = file_get_contents($sZipPath);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", $ctype);
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setFileToSend($filePath, $fileName);
        $response->send();
        if($tmpPath)
        {
            // unlink($tmpPath);
        }
        exit(0);
    }

    public function enAction()
    {
        $this->view->setMainView('indexe');
        $this->view->ja = '/asp/';   // 日本語ページへのリンク
        
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            return $this->response->redirect('/index/e');
        }
        
        // 物理パスを求める
        // $path = self::FolderRoot;    2018/04/26
        $path = $this->config->application->uploadDir . 'folder/';
        $relativePath = '/';    // 2018/10/21        
        if($this->session->has(self::SV_PATH))
        {
            $sv_path_value = $this->session->get(self::SV_PATH);        // 2018/10/19
            if(!empty(($sv_path_value)))
            {
                if(is_array($sv_path_value))
                {
                    $path .= implode('/', $sv_path_value);
                    $relativePath .= implode('/', $sv_path_value);
                }
                else
                {
                    $path .= ($sv_path_value . '/');
                    $relativePath .= ($sv_path_value . '/');
                }
            }
        }
        // ファイル一覧を求める
        $fileNames = scandir($path);
        $fileList = array();
        foreach($fileNames as $fileName)
        {
            $fileInfo = array();
            if(substr($fileName, 0, 1) == '.') continue;
            $fileInfo['name'] = $fileName;
            $filepath = $path . '/' . $fileName;
            // $this->flash->error($filepath . ' ' . is_dir($filepath));
            if(is_dir($filepath))
            {
                $fileInfo['type'] = 'dir';
            }
            else
            {
                $fileInfo['type'] = 'file';
                $fileInfo['size'] = $this->filesizeDisp(filesize($filepath));
                $fileInfo['datetime'] = date('Y-m-d H:i:s', filemtime($filepath));
            }
            $fileList[] = $fileInfo;
        }
        
        // $abc = self::SV_PATH;
        // $this->view->path = '/' . implode('/', $this->session->get(self::SV_PATH));
        $this->view->path = $relativePath;  // 2018/10/21
        $this->view->filelist = $fileList;

        $this->assets->addCss('https://use.fontawesome.com/releases/v5.0.6/css/all.css')
                ->addCss('https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css')
                ;
        $this->assets->addJs('https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js')
                ->AddJs('https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js')
                ->AddJs('js/asp/index.js')
                ;
    }
    
    public function topeAction()
    {
        //
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            return $this->response->redirect('/index/e');
        }
        
        // パスを削除
        $this->session->remove(self::SV_PATH);
        return $this->response->redirect('/asp/en');
    }
    
    public function upeAction()
    {
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            return $this->response->redirect('/index/e');
        }
        
        // 最下位のディレクトリを削除
        // $prev = $this->session->get(self::SV_PATH);
        if($this->session->has(self::SV_PATH))
        {
            $path = $this->session->get(self::SV_PATH);
            // if(count($path) < 1)
            if(is_array($path))
            {
                if(count($path) > 1)     // 2018/10/21
                {
                    $this->session->set(self::SV_PATH, array_pop($path));
                }
                else
                {
                    $this->session->remove(self::SV_PATH);
                }
            }
            else
            {
                $this->session->remove(self::SV_PATH);
            }
        }
        // $next = $this->session->get(self::SV_PATH);
        // var_dump($next);exit(0);
        return $this->response->redirect('/asp/en');
    }
    
    public function foldereAction($folderName)
    {
        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];
            // $asp_flag = $auth['asp_flag'];   2018/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/10/07
        }
        // 管理者または asp_flag
        // if($userRole < 9 && (! $asp_flag)) {
        if(($auth_bits & $this->authority['ASP_LIST']) == 0)    // 2018/10/07
        {
            return $this->response->redirect('/index/e');
        }
        
        // 最下位のディレクトリを追加
        $folderName = urldecode($folderName);
        $path = array();
        if($this->session->has(self::SV_PATH))
        {
            $path = $this->session->get(self::SV_PATH);
            if(! is_array($path))
            {
                $path = array();
                $this->session->remove(self::SV_PATH);
            }
        }
        $path[] = $folderName;
        $this->session->set(self::SV_PATH, $path);
        return $this->response->redirect('/asp/en');
    }

}
