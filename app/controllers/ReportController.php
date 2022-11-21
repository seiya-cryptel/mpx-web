<?php

class ReportController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    // rType    "w" | "m"
    public function indexAction($rType, $rName)
    {
        return $this->response->redirect('/');
            
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/r" . $rType . "/" . $rName . ".pdf";   2018/04/26
        // $pdfData = file_get_contents("/usr/share/nginx/data/r" . $rType . "/" . $rName . ".pdf");
        $strFile = $this->config->application->uploadDir . "r" . $rType . "/" . $rName . ".pdf";
        $pdfData = file_get_contents($this->config->application->uploadDir . "r" . $rType . "/" . $rName . ".pdf");
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // 月次レポート 2016/3/15
    public function mAction($rName)
    {
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rm/" . $rName . ".pdf";    2018/04/26
        $strFile = $this->config->application->uploadDir . "rm/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // 週次レポート 2016/3/15
    public function wAction($rName)
    {
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rw/" . $rName . ".pdf";    2018/04/26
        $strFile = $this->config->application->uploadDir . "rw/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // 週次FCレポート 2017/7/12
    public function fcAction($rName)
    {
        /* 2018/10/19
        $auth = $this->session->get('auth');
        if($auth['role'] < 3) { // B1 以上利用可能
            return $this->response->redirect("/");
        }
         * 
         */
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
        }
        if($auth_bits & $this->authority['REPORT_FC'] == 0)
        {
            return $this->response->redirect("/");
        }
        
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rlfc/" . $rName . ".pdf";  2018/04/27
        $strFile = $this->config->application->uploadDir . "rlfc/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // ジェネレーション・スタック レポート 2017/11/15
    public function gsAction($rName)
    {
        /*  2018/10/19
        $auth = $this->session->get('auth');
        if($auth['role'] < 7) { // B1 以上利用可能
            return $this->response->redirect("/");
        }
         * 
         */
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
        }
        if($auth_bits & $this->authority['REPORT_GS'] == 0)
        {
            return $this->response->redirect("/");
        }
        
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rgs/" . $rName . ".pdf";   2018/04/27
        $strFile = $this->config->application->uploadDir . "rgs/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // 検証データ 2018/04/27
    public function vaAction($rName)
    {
        /* 2018/05/16
        $auth = $this->session->get('auth');
        if($auth['role'] < 7) { // B1 以上利用可能
            return $this->response->redirect("/");
        }
        if(! $auth['report_va']) {  // 2018/05/16
            return $this->response->redirect("/");
        }
         * 
         */
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
        }
        if($auth_bits & $this->authority['REPORT_VA'] == 0)
        {
            return $this->response->redirect("/");
        }
        
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rgs/" . $rName . ".pdf";   2018/04/27
        $strFile = $this->config->application->uploadDir . "rva/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // リスク・プレミアム 2018/04/27
    public function rpAction($rName)
    {
        /*  2018/10/19
        $auth = $this->session->get('auth');
        if($auth['role'] < 7) { // B1 以上利用可能
            return $this->response->redirect("/");
        }
        if(! $auth['report_rp']) {  // 2018/06/04
            return $this->response->redirect("/");
        }
         * 
         */
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        else
        {
            $userId = '';       // 2018/10/19
            $auth_bits = 0;     // 2018/10/19
        }
        if($auth_bits & $this->authority['REPORT_RP'] == 0)
        {
            return $this->response->redirect("/");
        }
        
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/rgs/" . $rName . ".pdf";   2018/04/27
        $strFile = $this->config->application->uploadDir . "rrp/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }

    // 週次レポート 2016/3/27
    public function oAction($rName)
    {
        $this->view->disable();
        
        // $strFile = "/usr/share/nginx/data/misc/" . $rName . ".pdf";  2018/04/27
        $strFile = $this->config->application->uploadDir . "misc/" . $rName . ".pdf";
        $pdfData = file_get_contents($strFile);
        $len = strlen($pdfData);
        
        ob_clean(); // 2018/10/19
        
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/pdf");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($pdfData);
        $response->send();
    }
}
