<?php

class ForwardcurveController extends ControllerBase
{
    // 2018/09/28 フォーワードカーブ表示権限
    protected function _enable_fc($auth_bits)
    {
        $ret = (
                    $auth_bits & 
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
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/e';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            return $this->response->redirect(($this->session->has(self::FLG_LANGOVERRIDE)) ? '/index/e' : '/');     // 2020/03/01
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }
        $upload_id = $upload->id;

        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $monthly_upload_date = $daily_upload_date;
        $half_hourly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;
        $export_date = date('Ymd', strtotime($strTargetDate));

        // Monthly データ
        /*
          $monthly = GraphData::findFirst(
          array(
          '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
          'bind' => array(
          'graph_type' => UploadController::GRAPH_FORWARD_POWER_MONTH,
          'upload_id' => $upload_id,
          )
          )
          );
          $monthlyJason = $monthly->graph_data;
         * 2016/04/18
         */
        $monthly = ForwardMainMonths::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        foreach ($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_SYS_DAILY'])
        {
            /*
              $daily = GraphData::findFirst(
              array(
              '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
              'bind' => array(
              'graph_type' => UploadController::GRAPH_FORWARD_POWER_DAY,
              'upload_id' => $upload_id,
              )
              )
              );
              $dailyJason = $daily->graph_data;
             * 2016/04/18
             */
            $daily = ForwardMainDays::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($daily as $rec) {
                $dailyData[] = array(
                    'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 3)
        $dailyJason = json_encode($dailyData);

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_SYS_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHours::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($hHourly as $rec) {
                $hHourlyData[] = array(
                    'fc_datetime' => date('Y/m/d H:i:s', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 4)
        $hHourlyJason = json_encode($hHourlyData);

        // hourlyのデータ
        // if ($userRole > 8 
        // ||  $fc_hourly)  // 2018/02/26
        if($auth_bits & $this->authority['FC_SYS_HOURLY'])
        {
            $hourly = ForwardMainHours::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)
        $hourlyJason = json_encode($hourlyData);

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'), 2018/10/19
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN'] == 0) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'), // 2018/11/04
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        // JEPXスポット短期予想
        /*
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04

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
         * 
         */

        $short_data_list = [];
        /*
        $i = 0;
        foreach ($shorts as $data) {
            $short_data_list[$i]['dt'] = date('Y/m/d H:i:s', strtotime($data->dt));
            $short_data_list[$i]['spot'] = $data->spot;
            $i++;
        }
         * 
         */

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css')
                ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_half_hourly.js')
                    ->addJs('js/chart_daily.js')
                    ->addJs('js/chart_monthly.js')
                    ->addJs('js/chart_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    // JEPXスポット短期予想
                    // 'short_data_list' => $short_data_list,
                    // 'jepx_upload_date' => $jepx_upload_date, 2018/11/04
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    'filename_area' => '',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_SYS_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_SYS_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_SYS_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Forward Price (円/kWh)':'Forward Price (円/kWh)','ダウンロード':'ダウンロード','ベースロード':'ベースロード','ピークロード':'ピークロード','日中ロード':'日中ロード'}",
                )
        );
    }

    // 東エリアプライス
    public function eastpriceAction()
    {
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/eastpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if ($userRole == 2 || $userRole == 4 || $userRole == 6 || $userRole == 8 || $userRole == 9)
        // {
            // A2, B2, C2, D2, admin エリア表示可
        // }
        // else {
        if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']) == 0)
        {
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_E, // 2016/05/20
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }
        $upload_id = $upload->id;

        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $export_date = date('Ymd', strtotime($strTargetDate));
        $half_hourly_upload_date = $daily_upload_date;
        $monthly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;

        /*
          $monthly = GraphData::findFirst(
          array(
          '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
          'bind' => array(
          'graph_type' => UploadController::GRAPH_FORWARD_POWER_MONTH,
          'upload_id' => $upload_id,
          )
          )
          );
          $monthlyJason = $monthly->graph_data;
         * 2016/04/18
         */
        $monthly = ForwardMainMonthsEast::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        foreach ($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {
            /*
              $daily = GraphData::findFirst(
              array(
              '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
              'bind' => array(
              'graph_type' => UploadController::GRAPH_FORWARD_POWER_DAY,
              'upload_id' => $upload_id,
              )
              )
              );
              $dailyJason = $daily->graph_data;
             * 2016/04/18
             */
            $daily = ForwardMainDaysEast::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($daily as $rec) {
                $dailyData[] = array(
                    'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 3)
        $dailyJason = json_encode($dailyData);

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHoursEast::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($hHourly as $rec) {
                $hHourlyData[] = array(
                    'fc_datetime' => date('Y/m/d H:i:s', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 4)
        $hHourlyJason = json_encode($hHourlyData);

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly = ForwardMainHoursEast::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)
        $hourlyJason = json_encode($hourlyData);

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN'] == 0) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        // JEPXスポット短期予想
        /* 2018/11/04
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_E,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04

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
         * 
         */

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_half_hourly.js')
                    ->addJs('js/chart_daily.js')
                    ->addJs('js/chart_monthly.js')
                    ->addJs('js/chart_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    // JEPXスポット短期予想
                    // 'short_data_list' => $short_data_list,
                    // 'jepx_upload_date' => $jepx_upload_date,
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    'filename_area' => '_east',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_5AREA_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_5AREA_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Forward Price (円/kWh)':'Forward Price (円/kWh)','ダウンロード':'ダウンロード','ベースロード':'ベースロード','ピークロード':'ピークロード','日中ロード':'日中ロード'}",
                )
        );
    }

    // 西エリアプライス
    public function westpriceAction()
    {
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/westpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if ($userRole == 2 || $userRole == 4 || $userRole == 6 || $userRole == 8 || $userRole == 9)
        // {
            // A2, B2, C2, D2, admin エリア表示可
        // }
        // else {
        if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']) == 0)
        {
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_W,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }
        $upload_id = $upload->id;

        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $export_date = date('Ymd', strtotime($strTargetDate));
        $half_hourly_upload_date = $daily_upload_date;
        $monthly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;

        /*
          $monthly = GraphData::findFirst(
          array(
          '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
          'bind' => array(
          'graph_type' => UploadController::GRAPH_FORWARD_POWER_MONTH,
          'upload_id' => $upload_id,
          )
          )
          );
          $monthlyJason = $monthly->graph_data;
         * 2016/04/18
         */
        $monthly = ForwardMainMonthsWest::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        foreach ($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {
            /*
              $daily = GraphData::findFirst(
              array(
              '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
              'bind' => array(
              'graph_type' => UploadController::GRAPH_FORWARD_POWER_DAY,
              'upload_id' => $upload_id,
              )
              )
              );
              $dailyJason = $daily->graph_data;
             * 2016/04/18
             */
            $daily = ForwardMainDaysWest::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($daily as $rec) {
                $dailyData[] = array(
                    'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 3)
        $dailyJason = json_encode($dailyData);

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHoursWest::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($hHourly as $rec) {
                $hHourlyData[] = array(
                    'fc_datetime' => date('Y/m/d H:i:s', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 4)
        $hHourlyJason = json_encode($hHourlyData);

         // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
           $hourly = ForwardMainHoursWest::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)
        $hourlyJason = json_encode($hourlyData);

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN']) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        // JEPXスポット短期予想
        /*
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_W,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04

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
         * 
         */

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_half_hourly.js')
                    ->addJs('js/chart_daily.js')
                    ->addJs('js/chart_monthly.js')
                    ->addJs('js/chart_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    // JEPXスポット短期予想
                    // 'short_data_list' => $short_data_list,
                    // 'jepx_upload_date' => $jepx_upload_date,
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    'filename_area' => '_west',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_5AREA_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_5AREA_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Forward Price (円/kWh)':'Forward Price (円/kWh)','ダウンロード':'ダウンロード','ベースロード':'ベースロード','ピークロード':'ピークロード','日中ロード':'日中ロード'}",
                )
        );
    }

    // 北海道エリアプライス 2017/02/17
    public function hpriceAction()
    {
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/hpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if ($userRole == 2 || $userRole == 4 || $userRole == 6 || $userRole == 8 || $userRole == 9)
        // {
            // A2, B2, C2, D2, admin エリア表示可
        // }
        // else {
        if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']) == 0)
        {
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_H,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }
        $upload_id = $upload->id;

        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $export_date = date('Ymd', strtotime($strTargetDate));
        $half_hourly_upload_date = $daily_upload_date;
        $monthly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;

        // 月次
        $monthly = ForwardMainMonthsHokkaido::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        foreach ($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {
            $daily = ForwardMainDaysHokkaido::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($daily as $rec) {
                $dailyData[] = array(
                    'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 3)
        $dailyJason = json_encode($dailyData);

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/25
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHoursHokkaido::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($hHourly as $rec) {
                $hHourlyData[] = array(
                    'fc_datetime' => date('Y/m/d H:i:s', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 4)
        $hHourlyJason = json_encode($hHourlyData);

         // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
           $hourly = ForwardMainHoursHokkaido::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)
        $hourlyJason = json_encode($hourlyData);

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN'] == 0) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        // JEPXスポット短期予想
        /*
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_H,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04

        // データの取得
        $shorts = JEPXShortsHokkaido::find(
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
         * 
         */

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_half_hourly.js')
                    ->addJs('js/chart_daily.js')
                    ->addJs('js/chart_monthly.js')
                    ->addJs('js/chart_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    // JEPXスポット短期予想
                    // 'short_data_list' => $short_data_list,
                    // 'jepx_upload_date' => $jepx_upload_date,
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    'filename_area' => '_hokkaido',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_5AREA_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_5AREA_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Forward Price (円/kWh)':'Forward Price (円/kWh)','ダウンロード':'ダウンロード','ベースロード':'ベースロード','ピークロード':'ピークロード','日中ロード':'日中ロード'}",
                )
        );
    }

    // 九州エリアプライス 2017/02/17
    public function kpriceAction()
    {
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/kpricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if ($userRole == 2 || $userRole == 4 || $userRole == 6 || $userRole == 8 || $userRole == 9)
        // {
            // A2, B2, C2, D2, admin エリア表示可
        // }
        // else {
        if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']) == 0)
        {
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_K,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }
        $upload_id = $upload->id;

        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $export_date = date('Ymd', strtotime($strTargetDate));
        $half_hourly_upload_date = $daily_upload_date;
        $monthly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;

        // 月次
        $monthly = ForwardMainMonthsKyushu::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        foreach ($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {
            $daily = ForwardMainDaysKyushu::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($daily as $rec) {
                $dailyData[] = array(
                    'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 3)
        $dailyJason = json_encode($dailyData);

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHoursKyushu::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            foreach ($hHourly as $rec) {
                $hHourlyData[] = array(
                    'fc_datetime' => date('Y/m/d H:i:s', strtotime($rec->fc_datetime)),
                    'price' => $rec->price,
                );
            }
        }   // if($userRole > 4)
        $hHourlyJason = json_encode($hHourlyData);

         // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
           $hourly = ForwardMainHoursKyushu::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)
        $hourlyJason = json_encode($hourlyData);

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN'] == 0) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        // JEPXスポット短期予想
        /*
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_K,
                            ),
                        )
        );
        $upload_id = $upload->id;
        $jepx_upload_date = date('Y年m月d日', strtotime($upload->target_date)); // 2016/07/04

        // データの取得
        $shorts = JEPXShortsKyushu::find(
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
         * 
         */

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_half_hourly.js')
                    ->addJs('js/chart_daily.js')
                    ->addJs('js/chart_monthly.js')
                    ->addJs('js/chart_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    // JEPXスポット短期予想
                    // 'short_data_list' => $short_data_list,
                    // 'jepx_upload_date' => $jepx_upload_date,
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    'filename_area' => '_kyushu',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_5AREA_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_5AREA_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Forward Price (円/kWh)':'Forward Price (円/kWh)','ダウンロード':'ダウンロード','ベースロード':'ベースロード','ピークロード':'ピークロード','日中ロード':'日中ロード'}",
                )
        );
    }

    // 5エリア 2017/04/07
    public function fivepriceAction()
    {
        ini_set('memory_limit', '256M');
        $this->view->en = '/forwardcurve/fivepricee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        // $userRole = 0;
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            // $userRole = $auth['role'];
            $userId = $auth['user_id'];     // 2016/10/19
            // $fc_hourly = $auth['fc_hourly'];    // 2018/02/26
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if($userRole < 1)    2019/09/28
        if($this->_enable_fc($auth_bits) == 0)
        {   // 2018/03/30
            // return $this->response->redirect('/');
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // if ($userRole == 2 || $userRole == 4 || $userRole == 6 || $userRole == 8 || $userRole == 9)
        // {
            // A2, B2, C2, D2, admin エリア表示可
        // }
        // else {
        if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']) == 0)
        {
            // return $this->response->redirect('forwardcurve/index');
            return $this->response->redirect(($this->isOvr()) ? 'forwardcurve/e' : 'forwardcurve/index');
        }

        // システムプライス
        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            return $this->response->redirect('forwardcurve/threeprice/');
        }
        $upload_id = $upload->id;


        $dailyData = array();
        $monthlyData = array();
        $hHourlyData = array();
        $hourlyData = array();

        // 配信日(アップロードされた日)
        $daily_upload_date = date('Y年m月d日', strtotime($strTargetDate));
        $monthly_upload_date = $daily_upload_date;
        $half_hourly_upload_date = $daily_upload_date;
        $hourly_upload_date = $daily_upload_date;
        $export_date = date('Ymd', strtotime($strTargetDate));

        // Monthly データ
        $monthly = ForwardMainMonths::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );

        $i = 0;
        foreach ($monthly as $rec) {
            $monthlyData[$i]['fc_datetime'] = date('Y/m/d', strtotime($rec->fc_datetime));
            $monthlyData[$i]['price_base'] = $rec->price_base;
            $monthlyData[$i]['price_offpeak'] = $rec->price_offpeak;
            $monthlyData[$i]['price_peak'] = $rec->price_peak;
            $i++;
        }

        // dairyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {
            $daily = ForwardMainDays::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            $i = 0;
            foreach ($daily as $rec) {
                $dailyData[$i]['fc_datetime'] = date('Y/m/d', strtotime($rec->fc_datetime));
                $dailyData[$i]['price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 3)

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly = ForwardMainHHours::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($hHourly as $rec) {
                $hHourlyData[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($rec->fc_datetime));
                $hHourlyData[$i]['price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 4)

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly = ForwardMainHours::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );

            $i = 0;
            foreach ($hourly as $rec) {
                $hourlyData[] = array(
                    'dt' => date('Y/m/d H:i:s', strtotime($rec->dt)),
                    'pr' => $rec->pr,
                );
            }
        }   // if($userRole > 8)

        $calender_date_list = array();
        $isAdmin = (($auth_bits & $this->authority['ADMIN']) != 0);
        $uploads = Uploads::find(
                        array(
                            '(deleted=0) AND (upload_type=:type:) AND (target_date>:targetDate:)',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                // 'targetDate' => ($userRole < '9' ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                // 'targetDate' => (($auth_bits & $this->authority['ADMIN'] == 0) ? date('Y-m-d', strtotime('-1 month')) : '1970-1-1'),
                                'targetDate' => ($isAdmin ?  '1970-1-1' : date('Y-m-d', strtotime('-1 month'))),
                            ),
                        )
        );
        foreach ($uploads as $upload) {
            $calender_date_list[] = date('Y-m-d', strtotime($upload->target_date));
        }

        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_E, // 2016/05/20
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            return $this->response->redirect('forwardcurve/threeprice/');
        }
        $upload_id = $upload->id;


        // 東エリア
        // monthlyのデータ
        $monthly_east = ForwardMainMonthsEast::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );

        $i = 0;
        foreach ($monthly_east as $rec) {
            $monthlyData[$i]['east_price_base'] = $rec->price_base;
            $monthlyData[$i]['east_price_offpeak'] = $rec->price_offpeak;
            $monthlyData[$i]['east_price_peak'] = $rec->price_peak;
            $i++;
        }

        // dailyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {

            $daily_east = ForwardMainDaysEast::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($daily_east as $rec) {
                $dailyData[$i]['east_price'] = $rec->price;
                $i++;
            }

        }   // if($userRole > 3)

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly_east = ForwardMainHHoursEast::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($hHourly_east as $rec) {
                $hHourlyData[$i]['east_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 4)

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly_east = ForwardMainHoursEast::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );

            $i = 0;
            foreach ($hourly_east as $rec) {
                $hourlyData[$i]['east_pr'] = $rec->pr;
                $i++;
            }
        }   // if($userRole > 8)

        // 西エリア
        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_W,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            return $this->response->redirect('forwardcurve/threeprice/');
        }
        $upload_id = $upload->id;

        $monthly_west = ForwardMainMonthsWest::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );

        $i = 0;
        foreach ($monthly_west as $rec) {
            $monthlyData[$i]['west_price_base'] = $rec->price_base;
            $monthlyData[$i]['west_price_offpeak'] = $rec->price_offpeak;
            $monthlyData[$i]['west_price_peak'] = $rec->price_peak;
            $i++;
        }

        // dailyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {

            $daily_west = ForwardMainDaysWest::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            $i = 0;
            foreach ($daily_west as $rec) {
                $dailyData[$i]['west_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 3)

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly_west = ForwardMainHHoursWest::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($hHourly_west as $rec) {
                $hHourlyData[$i]['west_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 4)

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly_west = ForwardMainHoursWest::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );

            $i = 0;
            foreach ($hourly_west as $rec) {
                $hourlyData[$i]['west_pr'] = $rec->pr;
                $i++;
            }
        }   // if($userRole > 8)

        // 北海道
        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_H,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            return $this->response->redirect('forwardcurve/threeprice/');
        }
        $upload_id = $upload->id;

        $monthly_hokkaido = ForwardMainMonthsHokkaido::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );

        $i = 0;
        foreach ($monthly_hokkaido as $rec) {
            $monthlyData[$i]['hokkaido_price_base'] = $rec->price_base;
            $monthlyData[$i]['hokkaido_price_offpeak'] = $rec->price_offpeak;
            $monthlyData[$i]['hokkaido_price_peak'] = $rec->price_peak;
            $i++;
        }

        // dailyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {

            $daily_hokkaido = ForwardMainDaysHokkaido::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            $i = 0;
            foreach ($daily_hokkaido as $rec) {
                $dailyData[$i]['hokkaido_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 3)

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly_hokkaido = ForwardMainHHoursHokkaido::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($hHourly_hokkaido as $rec) {
                $hHourlyData[$i]['hokkaido_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 4)

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly_hokkaido = ForwardMainHoursHokkaido::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );

            $i = 0;
            foreach ($hourly_hokkaido as $rec) {
                $hourlyData[$i]['hokkaido_pr'] = $rec->pr;
                $i++;
            }
        }   // if($userRole > 8)

        // 九州
        if ($this->request->isPost()) {
            // POSTされたデータ取得
            $post_data_list = $this->request->getPost();
            $strTargetDate = date('Y-m-d', strtotime($post_data_list['day']));
            $this->view->half_hourly_upload_date = $post_data_list['day'];
        } else {
            $upload = Uploads::findFirst(
                            array(
                                'deleted=0 AND upload_type=:type:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDMAIN_K,
                                ),
                                'order' => 'target_date DESC'
                            )
            );
            $strTargetDate = date('Y-m-d', strtotime($upload->target_date));
        }

        // 指定日を対象日としてアップロードレコードを検索
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date=:date:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                                'date' => $strTargetDate,
                            ),
                        )
        );
        if ($upload == false) {
            // $this->flash->error($strTargetDate . ' 配信のデータはありません。');
            $this->flash->error(($this->isOvr()) ? 'No data on ' . $strTargetDate : $strTargetDate . ' 配信のデータはありません。');   // 2020/03/01
            return $this->response->redirect('forwardcurve/threeprice/');
        }
        $upload_id = $upload->id;

        $monthly_kyushu = ForwardMainMonthsKyushu::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );

        $i = 0;
        foreach ($monthly_kyushu as $rec) {
            $monthlyData[$i]['kyushu_price_base'] = $rec->price_base;
            $monthlyData[$i]['kyushu_price_offpeak'] = $rec->price_offpeak;
            $monthlyData[$i]['kyushu_price_peak'] = $rec->price_peak;
            $i++;
        }

        // dailyのデータ
        // if ($userRole > 4) {    // PlanC 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_DAILY'])
        {

            $daily_kyushu = ForwardMainDaysKyushu::find(
                            array(
                                '(upload_id=:uploadId:)',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );
            $i = 0;
            foreach ($daily_kyushu as $rec) {
                $dailyData[$i]['kyushu_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 3)

        // half_hourlyのデータ
        // if ($userRole > 6) {    // PlanD 以上    2018/10/06
        if($auth_bits & $this->authority['FC_5AREA_HALFHOURLY'])
        {
            $hHourly_kyushu = ForwardMainHHoursKyushu::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'fc_datetime',
                            )
            );

            $i = 0;
            foreach ($hHourly_kyushu as $rec) {
                $hHourlyData[$i]['kyushu_price'] = $rec->price;
                $i++;
            }
        }   // if($userRole > 4)

        // hourlyのデータ 2016/10/19
        // if ($userRole > 8
        // ||  $fc_hourly  // 2018/02/26
        // || ($fc_hourly && in_array($userRole, [2, 4, 6, 8]))   // 2018/04/17
        //         ) {
        if($auth_bits & $this->authority['FC_5AREA_HOURLY'])
        {
            $hourly_kyushu = ForwardMainHoursKyushu::find(
                            array(
                                '(upload_id=:upload_id:)',
                                'bind' => array(
                                    'upload_id' => $upload_id,
                                ),
                                'order' => 'dt',
                            )
            );

            $i = 0;
            foreach ($hourly_kyushu as $rec) {
                $hourlyData[$i]['kyushu_pr'] = $rec->pr;
                $i++;
            }
        }   // if($userRole > 8)

        // ----------------------------------------------------------------
        $monthlyJason = json_encode($monthlyData);
        $dailyJason = json_encode($dailyData);
        $hHourlyJason = json_encode($hHourlyData);
        $hourlyJason = json_encode($hourlyData);

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_forwardcurve.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_forwardcurve_five_area_monthly.js')
                    ->addJs('js/chart_forwardcurve_five_area_half_hourly.js')
                    ->addJs('js/chart_forwardcurve_five_area_daily.js')
                    ->addJs('js/chart_forwardcurve_five_area_hourly.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_data_list' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_data_list' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_data_list' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'hourly_data_list' => $hourlyJason,
                    'hourly_upload_date' => $hourly_upload_date,
                    'day' => "3年間",
                    'calender_date_list' => $calender_date_list,
                    'export_date' => $export_date,
                    // 'filename_area' => '_threearea',   // 2017/01/02
                    'filename_area' => '_fivearea',   // 2017/01/02
                    'enable_5area' => ($auth_bits & $this->authority['FC_5AREA_MONTHLY']),  // 2018/10/06
                    'enable_daily' => ($auth_bits & $this->authority['FC_5AREA_DAILY']),  // 2018/10/06
                    'enable_halfhourly' => ($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']),  // 2018/10/06
                    'enable_hourly' => ($auth_bits & $this->authority['FC_5AREA_HOURLY']),  // 2018/10/06
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{"
                    . "'Forward Price (円/kWh)':'Forward Price (円/kWh)'"
                    . ",'システムプライス・ベースロード':'システムプライス・ベースロード'"
                    . ",'システムプライス・ピークロード':'システムプライス・ピークロード'"
                    . ",'システムプライス・日中ロード':'システムプライス・日中ロード'"
                    . ",'東エリア・ベースロード':'東エリア・ベースロード'"
                    . ",'東エリア・ピークロード':'東エリア・ピークロード'"
                    . ",'東エリア・日中ロード':'東エリア・日中ロード'"
                    . ",'西エリア・ベースロード':'西エリア・ベースロード'"
                    . ",'西エリア・ピークロード':'西エリア・ピークロード'"
                    . ",'西エリア・日中ロード':'西エリア・日中ロード'"
                    . ",'北海道・ベースロード':'北海道・ベースロード'"
                    . ",'北海道・ピークロード':'北海道・ピークロード'"
                    . ",'北海道・日中ロード':'北海道・日中ロード'"
                    . ",'九州・ベースロード':'九州・ベースロード'"
                    . ",'九州・ピークロード':'九州・ピークロード'"
                    . ",'九州・日中ロード':'九州・日中ロード'"
                    . ",'ダウンロード':'ダウンロード'"
                    . "}",
                )
        );
    }

    // 2020/01/28
    public function eAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->indexAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Forward Price (円/kWh)':'Forward Price (JPY/kWh)','ダウンロード':'Download','ベースロード':'Base Load','ピークロード':'Peak Load','日中ロード':'Daytime Load'}";
        $this->assets
                ->addJs('js/chart_half_hourlye.js')
                ->addJs('js/chart_dailye.js')
                ->addJs('js/chart_monthlye.js')
                ->addJs('js/chart_hourlye.js')
        ;
    }
    
    public function  eastpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->eastpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/eastprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Forward Price (円/kWh)':'Forward Price (JPY/kWh)','ダウンロード':'Download','ベースロード':'Base Load','ピークロード':'Peak Load','日中ロード':'Daytime Load'}";
        $this->assets
                ->addJs('js/chart_half_hourlye.js')
                ->addJs('js/chart_dailye.js')
                ->addJs('js/chart_monthlye.js')
                ->addJs('js/chart_hourlye.js')
        ;
    }
    
    public function  westpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->westpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/westprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Forward Price (円/kWh)':'Forward Price (JPY/kWh)','ダウンロード':'Download','ベースロード':'Base Load','ピークロード':'Peak Load','日中ロード':'Daytime Load'}";
        $this->assets
                ->addJs('js/chart_half_hourlye.js')
                ->addJs('js/chart_dailye.js')
                ->addJs('js/chart_monthlye.js')
                ->addJs('js/chart_hourlye.js')
        ;
    }
    
    public function  hpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->hpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/hprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Forward Price (円/kWh)':'Forward Price (JPY/kWh)','ダウンロード':'Download','ベースロード':'Base Load','ピークロード':'Peak Load','日中ロード':'Daytime Load'}";
        $this->assets
                ->addJs('js/chart_half_hourlye.js')
                ->addJs('js/chart_dailye.js')
                ->addJs('js/chart_monthlye.js')
                ->addJs('js/chart_hourlye.js')
        ;
    }
    
    public function  kpriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->kpriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/kprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Forward Price (円/kWh)':'Forward Price (JPY/kWh)','ダウンロード':'Download','ベースロード':'Base Load','ピークロード':'Peak Load','日中ロード':'Daytime Load'}";
        $this->assets
                ->addJs('js/chart_half_hourlye.js')
                ->addJs('js/chart_dailye.js')
                ->addJs('js/chart_monthlye.js')
                ->addJs('js/chart_hourlye.js')
        ;
    }
    
    public function  fivepriceeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->fivepriceAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/forwardcurve/fiveprice';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->monthly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->daily_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->half_hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->hourly_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{"
                    . "'Forward Price (円/kWh)':'Forward Price (JPY/kWh)'"
                    . ",'システムプライス・ベースロード':'System Price・Base Load'"
                    . ",'システムプライス・ピークロード':'System Price・Peak Load'"
                    . ",'システムプライス・日中ロード':'System Price・Daytime Load'"
                    . ",'東エリア・ベースロード':'East Area・Base Load'"
                    . ",'東エリア・ピークロード':'East Area・Peak Load'"
                    . ",'東エリア・日中ロード':'East Area・Daytime Load'"
                    . ",'西エリア・ベースロード':'West Area・Base Load'"
                    . ",'西エリア・ピークロード':'West Area・Peak Load'"
                    . ",'西エリア・日中ロード':'West Area・Daytime Load'"
                    . ",'北海道・ベースロード':'Hokkaido・Base Load'"
                    . ",'北海道・ピークロード':'Hokkaido・Peak Load'"
                    . ",'北海道・日中ロード':'Hokkaido・Daytime Load'"
                    . ",'九州・ベースロード':'Kyushu・Base Load'"
                    . ",'九州・ピークロード':'Kyushu・Peak Load'"
                    . ",'九州・日中ロード':'Kyushu・Daytime Load'"
                    . ",'ダウンロード':'Download'"
                    . "}";
        $this->assets
                ->addJs('js/chart_forwardcurve_five_area_monthlye.js')
                ->addJs('js/chart_forwardcurve_five_area_half_hourlye.js')
                ->addJs('js/chart_forwardcurve_five_area_dailye.js')
                ->addJs('js/chart_forwardcurve_five_area_hourlye.js')
        ;
    }
}
