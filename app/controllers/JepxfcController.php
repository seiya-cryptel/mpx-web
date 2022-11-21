<?php

class JepxfcController extends ControllerBase
{
    // 2018/09/28 フォーワードカーブ表示権限
    protected function _enable_fc($auth_bit)
    {
        $ret = (
                    $auth_bit & 
                    (
                        $this->authority['FC_JEPX_SYS']
                      | $this->authority['FC_JEPX_5AREA']
                    )
                );
        return $ret;
    }

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        // ini_set('memory_limit', '256M');
        $this->view->en = '/jepxfc/e';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        /*
        $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userRole = $auth['role'];
            $userId = $auth['user_id'];
        }
        if($userRole < 1)
        {   // 2018/03/30
            return $this->response->redirect('/');
        }
        // if($userRole < 9) { 2016/10/07
        if($userRole < 3) {
            if($userId != 'seiya@officeu.com'
            && $userId != 'yuh@sukagawagas.co.jp'
            // && $userId != 'nishi_hirotoshi@koyoelec.com' 2017/04/28
            && $userId != 'motohisa.miura_a@eneserve.co.jp'
            && $userId != 'eiko.fujii@toshiba.co.jp'
            ) {
                return $this->response->redirect('/');
            }
        }
         * 
         */
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $shorts = JEPXShorts::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>=:date:)", // 2016/06/28
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            // 'date' => date('Y-m-d H:i:s'),
                            ),
                        )
        );

        $short_data_list = [];
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '',      // 2017/01/02
                    'series_name' => 'システムプライス',    // 2017/02/24
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 東エリア
    public function eastpriceAction()
    {
        // ini_set('memory_limit', '256M');
        $this->view->en = '/jepxfc/eastpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        if(($auth_bits & $this->authority['FC_JEPX_5AREA']) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_E,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $shorts = JEPXShortsEast::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>=:date:)", // 2016/06/28
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            // 'date' => date('Y-m-d H:i:s'),
                            ),
                        )
        );

        $short_data_list = [];
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_east',      // 2017/01/02
                    'series_name' => '東エリアプライス',    // 2017/02/24
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 西エリアプライス
    public function westpriceAction()
    {
        // ini_set('memory_limit', '256M');
        $this->view->en = '/jepxfc/westpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        if(($auth_bits & $this->authority['FC_JEPX_5AREA']) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_W,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $shorts = JEPXShortsWest::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>=:date:)", // 2016/06/28
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            // 'date' => date('Y-m-d H:i:s'),
                            ),
                        )
        );

        $short_data_list = [];
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_west',      // 2017/01/02
                    'series_name' => '西エリアプライス',    // 2017/02/24
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 北海道プライス
    public function hpriceAction()
    {
        $this->view->en = '/jepxfc/hpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        if(($auth_bits & $this->authority['FC_JEPX_5AREA']) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_H,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $shorts = JEPXShortsHokkaido::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );

        $short_data_list = [];
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_hokkaido',      // 2017/01/02
                    'series_name' => '北海道エリアプライス',    // 2017/02/24
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 九州プライス
    public function kpriceAction()
    {
        $this->view->en = '/jepxfc/kpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        if(($auth_bits & $this->authority['FC_JEPX_5AREA']) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_K,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $shorts = JEPXShortsKyushu::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );

        $short_data_list = [];
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_kyushu',      // 2017/01/02
                    'series_name' => '九州エリアプライス',    // 2017/02/24
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 5 エリア 2017/02/20
    public function fivepriceAction()
    {
        // ini_set('memory_limit', '256M');
        $this->view->en = '/jepxfc/fivepricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        if(($auth_bits & $this->authority['FC_JEPX_5AREA']) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload_id = null;
        $upload_id_east = null;
        $upload_id_west = null;
        $jepx_upload_date = null;
        $export_date = null;
        $short_data = [];
        $short_data_list = [];
        
        // システムプライス
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                        )
        );
        if($upload) {
            $upload_id = $upload->id;
            // システムプライスの日付で代表
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
            $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date));
            $export_date = date('Ymd', strtotime($upload->target_date));
        }
        // 東エリア
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_E,
                            ),
                        )
        );
        if($upload) {
            $upload_id_east = $upload->id;
        }
        // 西エリア
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_W,
                            ),
                        )
        );
        if($upload) {
            $upload_id_west = $upload->id;
        }
        // 北海道 2017/02/20
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_H,
                            ),
                        )
        );
        if($upload) {
            $upload_id_hokkaido = $upload->id;
        }
        // 九州
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_K,
                            ),
                        )
        );
        if($upload) {
            $upload_id_kyushu = $upload->id;
        }
        
        // データの取得
        if(! empty($upload_id)) {
            $shorts = JEPXShorts::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot'] = $data->spot;
            }
        }
        if(! empty($upload_id_east)) {
            $shorts = JEPXShortsEast::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_east,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_east'] = $data->spot;
            }
        }
        if(! empty($upload_id_west)) {
            $shorts = JEPXShortsWest::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_west,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_west'] = $data->spot;
            }
        }
        // 2017/02/20
        if(! empty($upload_id_hokkaido)) {
            $shorts = JEPXShortsHokkaido::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_hokkaido,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_hokkaido'] = $data->spot;
            }
        }
        if(! empty($upload_id_kyushu)) {
            $shorts = JEPXShortsKyushu::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_kyushu,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_kyushu'] = $data->spot;
            }
        }
        // 配列作成
        ksort($short_data);
        $i = 0;
        foreach($short_data as $dt => $rec) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($dt));
            $short_data_list[$i]['spot'] = isset($rec['spot']) ? $rec['spot'] : null;
            $short_data_list[$i]['spot_east'] = isset($rec['spot_east']) ? $rec['spot_east'] : null;
            $short_data_list[$i]['spot_west'] = isset($rec['spot_west']) ? $rec['spot_west'] : null;
            $short_data_list[$i]['spot_hokkaido'] = isset($rec['spot_hokkaido']) ? $rec['spot_hokkaido'] : null;    // 2017/02/20
            $short_data_list[$i]['spot_kyushu'] = isset($rec['spot_kyushu']) ? $rec['spot_kyushu'] : null;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_short_jepx_five_area.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_allarea',      // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_JEPX_5AREA']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Spot Price (円/kWh)':'Spot Price (円/kWh)','ダウンロード':'ダウンロード'"
                    . ",'システムプライス':'システムプライス'"
                    . ",'東エリアプライス':'東エリアプライス'"
                    . ",'西エリアプライス':'西エリアプライス'"
                    . ",'北海道エリアプライス':'北海道エリアプライス'"
                    . ",'九州エリアプライス':'九州エリアプライス'"
                    . "}",
                )
        );
    }

    // 3 エリア
    public function threepriceAction()
    {
        // ini_set('memory_limit', '256M');

        $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userRole = $auth['role'];
            $userId = $auth['user_id'];
        }
        if($userRole < 1)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        // if($userRole < 9) { 2016/10/07
        if($userRole != 4 && $userRole != 6 && $userRole != 8 && $userRole != 9) {
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // JEPXスポット短期予想
        $upload_id = null;
        $upload_id_east = null;
        $upload_id_west = null;
        $jepx_upload_date = null;
        $export_date = null;
        $short_data = [];
        $short_data_list = [];
        
        // システムプライス
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                        )
        );
        if($upload) {
            $upload_id = $upload->id;
            // システムプライスの日付で代表
            $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date));
            $export_date = date('Ymd', strtotime($upload->target_date));
        }
        // 東エリア
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_E,
                            ),
                        )
        );
        if($upload) {
            $upload_id_east = $upload->id;
        }
        // 西エリア
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_W,
                            ),
                        )
        );
        if($upload) {
            $upload_id_west = $upload->id;
        }
        
        // データの取得
        if(! empty($upload_id)) {
            $shorts = JEPXShorts::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot'] = $data->spot;
            }
        }
        if(! empty($upload_id_east)) {
            $shorts = JEPXShortsEast::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_east,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_east'] = $data->spot;
            }
        }
        if(! empty($upload_id_west)) {
            $shorts = JEPXShortsWest::find(
                            array(
                                "(upload_id=:uploadId:)",
                                'bind' => array(
                                    'uploadId' => $upload_id_west,
                                ),
                            )
            );
            foreach ($shorts as $data) {
                $short_data[$data->dt]['spot_west'] = $data->spot;
            }
        }
        
        // 配列作成
        ksort($short_data);
        $i = 0;
        foreach($short_data as $dt => $rec) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($dt));
            $short_data_list[$i]['spot'] = isset($rec['spot']) ? $rec['spot'] : null;
            $short_data_list[$i]['spot_east'] = isset($rec['spot_east']) ? $rec['spot_east'] : null;
            $short_data_list[$i]['spot_west'] = isset($rec['spot_west']) ? $rec['spot_west'] : null;
            $i++;
        }

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_short_jepx_three_area.js')
        ;

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_jepxfc' => 'active',
                    'short_data_list' => $short_data_list,
                    'jepx_upload_date' => $jepx_upload_date,
                    'export_date' => $export_date,
                    'filename_area' => '_allarea',      // 2017/01/02
                )
        );
    }

    // 2020/01/28
    public function  eAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->indexAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->series_name = 'System Price';    // 2017/02/24
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_short_jepxe.js')
        ;
    }
    
    public function  eastpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->eastpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/eastprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->series_name = 'East Area Price';    // 2020/03/01; 2017/02/24
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_short_jepxe.js')
        ;
    }
    
    public function  westpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->westpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/westprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->series_name = 'West Area Price';    // 2017/02/24
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_short_jepxe.js')
        ;
    }
    
    public function  hpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->hpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/hprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->series_name = 'Hokkaido Area Price';    // 2017/02/24
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_short_jepxe.js')
        ;
    }
    
    public function  kpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->kpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/kprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->series_name = 'Kyushu Area Price';    // 2017/02/24
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_short_jepxe.js')
        ;
    }
    
    public function  fivepriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->fivepriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/jepxfc/fiveprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->jepx_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Spot Price (円/kWh)':'Spot Price (JPY/kWh)','ダウンロード':'Download'"
                    . ",'システムプライス':'System Price'"
                    . ",'東エリアプライス':'East Area Price'"       // 2020/03/01
                    . ",'西エリアプライス':'West Area Price'"
                    . ",'北海道エリアプライス':'Hokkaido Area Price'"
                    . ",'九州エリアプライス':'Kyushu Area Price'"
                    . "}";
        $this->assets
                ->addJs('js/chart_short_jepx_five_areae.js')
        ;
    }

}
