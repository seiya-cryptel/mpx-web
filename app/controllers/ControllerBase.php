<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

class ControllerBase extends Controller
{

    const SV_VALUES = 'ControllerBaseSysValues';
    const SV_AFTERLOGIN = 'ControllerBaseAfterLogin';   // 2016/06/20
    const SV_AUTHORITY = 'ControllerBaseAuthority';     // 2018/09/28
    const SV_SHOW202207 = __CLASS__ . 'Show202207';     // 2022/07/11
    
    const FLG_LANGOVERRIDE = 'langoverride';        // 2020/02/02

    public $auth;
    public $sysSetting;
    public $_MyLog;
    public $authority;  // 2018/09/28

    // 2017/05/21 EMail アドレスを表示用に短縮する
    private function _shortenEMail($mail) 
    {
        if(strlen($mail) < 12)  return $mail;
        return substr($mail, 0, 10) . '…';
    }
    
    // 2018/09/28
    protected function _menuVariables($auth)
    {
        $ret = array(
                    'enable_forwardcurve_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['FC_SYS_MONTHLY']
                          | $this->authority['FC_SYS_DAILY']
                          | $this->authority['FC_SYS_HALFHOURLY']
                          | $this->authority['FC_SYS_HOURLY']
                          | $this->authority['FC_5AREA_MONTHLY']
                          | $this->authority['FC_5AREA_DAILY']
                          | $this->authority['FC_5AREA_HALFHOURLY']
                          | $this->authority['FC_5AREA_HOURLY']
                        )
                    ),   // 2018/09/28
                    'enable_jepx_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['FC_JEPX_SYS']
                          | $this->authority['FC_JEPX_5AREA']
                        )
                    ),   // 2018/09/28
                    'enable_ds_price_menu' => ( // 2019/10/31
                        $auth['auth_bits'] & 
                        (
                            // $this->authority['FWD_DEMAND_SUPPLY_BALANCE']    2020/02/26 メニュー表示は B 以上の利用者
                            $this->authority['FC_JEPX_SYS']
                        )
                    ),
                    'enable_prerequisite_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['PRE_JEPX']
                          | $this->authority['PRE_FUEL_EXCHANGE']
                          | $this->authority['PRE_FUEL']
                          | $this->authority['PRE_FUEL_CIF']        // 2019/02/07
                          | $this->authority['PRE_DEMAND']          // 2018/10/14
                          | $this->authority['PRE_DEMAND_ALL']      // 2018/10/14
                          | $this->authority['PRE_CAPACITY']
                          | $this->authority['PRE_CAPACITY_ALL']
                          | $this->authority['PRE_CONNECT']
                          | $this->authority['PRE_HISTORICAL_DEMAND']
                        )
                    ),   // 2018/09/28
                    'enable_tool_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['TOOL_DOWNLOAD']
                          | $this->authority['TOOL_SIM_FUEL_EXCHANGE']
                          | $this->authority['TOOL_SIM_THERMAL']
                          | $this->authority['TOOL_SIM_MONTE_CARLO']
                        )
                    ),   // 2018/09/28
                    'enable_monthly_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_MONTHLY']
                          | $this->authority['REPORT_WEEKLY']
                        )
                    ),   // 2018/09/28
                    'enable_fc_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_FC']
                        )
                    ),   // 2018/09/28
                    'enable_gs_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_GS']
                        )
                    ),   // 2018/09/28
                    'enable_va_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_VA']
                        )
                    ),   // 2018/09/28
                    'enable_rp_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_RP']
                        )
                    ),   // 2018/09/28
                    'enable_misc_report_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_OTHER']
                        )
                    ),   // 2018/09/28
                    'enable_tool_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['TOOL_DOWNLOAD']
                          | $this->authority['TOOL_SIM_FUEL_EXCHANGE']
                          | $this->authority['TOOL_SIM_THERMAL']
                          | $this->authority['TOOL_SIM_MONTE_CARLO']
                        )
                    ),   // 2018/09/28
                    'enable_asp_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['ASP_LIST']
                        )
                    ),   // 2018/09/28
                    'enable_admin_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['ADMIN']
                        )
                    ),   // 2018/09/28
                    'enable_profile_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['LOGGED_IN']
                        )
                    ),   // 2018/09/28
                    'enable_pay_user_menu' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['FC_SYS_MONTHLY']
                        )
                    ),   // 2018/09/28
                    // 2018/10/25
                    'enable_report_monthly' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_MONTHLY']
                        )
                    ),
                    'enable_report_weekly' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_WEEKLY']
                        )
                    ),
                    'enable_report_fc' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_FC']
                        )
                    ),
                    'enable_report_gs' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_GS']
                        )
                    ),
                    'enable_report_va' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_VA']
                        )
                    ),
                    'enable_report_rp' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_RP']
                        )
                    ),
                    // 20190620 deguchi modified
                    'enable_report_misc' => (
                        $auth['auth_bits'] & 
                        (
                            $this->authority['REPORT_OTHER']
                        )
                    ),
                );
        $this->view->setVars($ret);
    }

    // protected function initialize()  2018/10/15
    public function initialize()
    {
        $this->_MyLog = new MyLogs();
        
        $this->tag->prependTitle('MRI Power Index');
        // $this->view->setTemplateAfter('main');
        // 認証情報
        $this->auth = false;
        $auth = $this->session->get('auth');
        //        echo '<pre>';print_r($auth);echo '</pre>';exit;

        if (!is_null($auth)) {
            $this->auth = true;
            $this->view->user_id = $auth['user_id'];
            $this->view->user_name = $auth['name'];
        }
        $this->view->auth = $this->auth;
                
        // 権限マスタ読込 2018/10/14; 2018/09/28
        $this->authority = $this->session->get(self::SV_AUTHORITY);
        if (!$this->authority) {
            $this->authority = Authority::findNameBits();
            $this->session->set(self::SV_AUTHORITY, $this->authority);
        }

        // 2015/12/20 View 変数 email, role を設定する
        if($this->auth) {   // 2016/04/06
            $this->view->setVars(
                    array(
                        'email' => $auth['user_id'],
                        'shortEmail' => $this->_shortenEMail($auth['user_id']),     // 2017/07/08
                        'role' => $auth['role'],
                        'dl_tool' => $auth['dl_tool'],  // 2017/05/26
                        // 'asp_flag' => $auth['asp_flag'],    // 2018/02/26
                        // 'fc_hourly' => $auth['fc_hourly'],   2018/10/19
                        // 'report_va' => $auth['report_va'],  // 2018/05/16
                        // 'report_rp' => $auth['report_rp'],  // 2018/06/03
                        /* 2018/09/28
                        'auth_string' => $auth['role']
                            . ($auth['fc_hourly'] ? 'H' : '') 
                            . ($auth['report_va'] ? 'V' : '')
                            . ($auth['report_rp'] ? 'R' : '')
                        , // 2018/05/24
                         * 
                         */
                        'auth_bits' => $auth['auth_bits'],  // 2018/09/28
                        // 'auth_string' => dechex($auth['auth_bits']),
                        'auth_string' => $auth['role'], // 2018/10/15
                        'authority' => $this->authority,
                    )
            );
            // var_dump(dechex($auth['auth_bits']));exit(0);
        }
        else {
            $this->view->setVars(   // 2018/10/14
                array(
                    'email' => null,
                    'shortEmail' => null,
                    'role' => null,
                    'auth_bits' => 0,
                    'auth_string' => '',
                    'authority' => $this->authority,
                )
            );
        }

        // システム設定読み込み
        $this->sysSetting = $this->session->get(self::SV_VALUES);
        if (!$this->sysSetting) {
            $ss = new SysSettings();
            $this->sysSetting = $ss->load();
            $this->session->set(self::SV_VALUES, $this->sysSetting);
        }
        
        // Cookie 承諾チェック 2020/01/28
        $this->view->cookieconf = 0;
        $cookieName = $this->config->application->cookieConf;
        if(! $this->cookies->has($cookieName))
        {
            $this->view->cookieconf = 1;     // メッセージを表示する
            $this->cookies->set($cookieName, 'Yes');
        }

        // View 変数設定 2018/09/28
        $this->_menuVariables($auth);
        
        // 2022/07/11 燃料炉前/CIF追加調達石油/石炭表示有無
        $bShow202207 = ((!empty($this->config->application->show202207)) && $this->config->application->show202207) ? true : false;
        $this->session->set(self::SV_SHOW202207, $bShow202207);    // セッション変数
        $this->view->show202207 = $bShow202207;     // view 変数
    }

    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(
                        array(
                            'controller' => $uriParts[0],
                            'action' => $uriParts[1],
                            'params' => $params
                        )
        );
    }

    protected function mail($to, $subj, $tmpl, $hdrs = null, $prms = null)
    {
        if (empty($tmpl)) {
            return false;
        }

        $view = clone $this->view;
        $view->start();
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->render('emails', $tmpl);
        $view->finish();
        $body = $view->getContent();

        return mb_send_mail($to, $subj, $body, $hdrs, $prms);
    }
    
    // 2020/01/31
    protected function setLang($lang) {
        $this->session->set('lang', $lang);
    }

    protected function getLang() {
        $lang = $this->session->has('lang') ? $this->session->get('lang') : 'ja';
        return $lang;
    }

    protected function isJa() {
        return ($this->getLang() == 'ja');
    }
    
    // 2020/03/01
    protected function isOvr()
    {
        return $this->session->has(self::FLG_LANGOVERRIDE);
    }

    // ディレクトリ内の一覧を取得する
    private function get_inner_path_of_directory( $dir_path )
    {
        $file_array = array();
        if( is_dir( $dir_path ) )
        {
            if( $dh = opendir( $dir_path ) )
            {
                while( ( $file = readdir( $dh ) ) !== false )
                {
                    if( $file == "." || $file == ".." ) continue;
                    $file_array[] = $file;
                }
                closedir( $dh );
            }
        }
        sort( $file_array );
        return $file_array;
    }
 
    // 再起的にディレクトリかファイルを判断し、ストリームに追加する
    private function add_zip( $zip, $dir_path, $dir_name )
    {
        if( ! is_dir( $dir_path . $dir_name ) ){
            $zip->addEmptyDir( $dir_name );
        }
 
        foreach( $this->get_inner_path_of_directory( $dir_path . $dir_name ) as $file )
        {
            if( is_dir( $dir_path . $dir_name . "/" . $file ) )
            {
                $this->add_zip( $zip, $dir_path, $dir_name . "/" , $file );
            }
            else
            {
                $zip->addFile( $dir_path . $dir_name . "/" . $file, $dir_name . "/" . $file );
            }
        }
    }
    
    // ディレクトリ再帰 chmod
    private function _chmoddir($path, $mode)
    {
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' %s ', array($path));
        foreach( $this->get_inner_path_of_directory( $path ) as $file )
        {
            $subPath = $path . "/" . $file;
            // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' %s ', array($subPath));
            
            if( is_dir( $subPath ) )
            {
                $this->_chmoddir( $subPath, $mode );
            }
            else
            {
                chmod($subPath, $mode);
            }
        }
        $ret = chmod($path, $mode | 0111);
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' %s, %s, %s ', array($path, ($mode + 0111), $ret));
    }
    
    // ディレクトリ ZIP 処理
    protected function zipDirectory($dir_path, $dir_name, $zip_path)
    {
        $zip = new ZipArchive();
        if( $zip->open( $zip_path, ZipArchive::OVERWRITE ) === true )
        {
            $this->add_zip( $zip, $dir_path, $dir_name );
            $zip->close();
        }
        else
        {
            throw new Exception('It does not make a zip file');
        }
    }
    
    // ファイル・ディレクトリ chmod
    protected function chmodrf($path, $mode)
    {
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' %s ', array($path));
        if(!is_link($path))
        {
            if(is_dir($path))
            {
                $this->_chmoddir($path, $mode);
            }
            elseif(is_file($path))
            {
                chmod($path, $mode);
            }
        }
    }
    
    // ディレクトリ再帰削除
    // https://qiita.com/kumazo/items/e0797004513d9029613e
    protected function rmrf($dir) {
        if (is_dir($dir) and !is_link($dir)) {
            array_map('rmrf',   glob($dir . '/*', GLOB_ONLYDIR));
            array_map('unlink', glob($dir.'/*'));
            rmdir($dir);
        }
    }

    // ファイルサイズ表示用編集
    protected function filesizeDisp($byte)
    {
        $edt = '';
        if($byte > (1024 * 1024 * 1024))
        {
            $edt = number_format(ceil($byte / (1024 * 1024 * 1024))) . ' GB';
        }
        else if($byte > (1024 * 1024))
        {
            $edt = number_format(ceil($byte / (1024 * 1024))) . ' MB';
        }
        else if($byte > 1024)
        {
            $edt = number_format(ceil($byte / 1024)) . ' KB';
        }
        else
        {
            $edt = number_format($byte) . ' B';
        }
        return $edt;
    }

}
