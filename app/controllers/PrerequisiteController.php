<?php

class PrerequisiteController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    /**
     * 時間の時分秒を取り除く YYYY-MM-DD H:i:sからH:i:sを取り除く
     * @param string $date_str YYYY-MM-DD H:i:s
     * @return string $yyyy_mm_dd YYYY-MM-DD
     */
    public function removeDataHis($date_str) {
        $date_list = explode(' ', $date_str);
        $yyyy_mm_dd = $date_list[0];
        return $yyyy_mm_dd;
    }

    /**
     * 最新のupload_idを取得
     * @param int $upload_id
     * @param int $latest_upload_id
     */
    public function getLatestUploadId($upload_id) {
        foreach ($upload_id as $data) {
            $latest_upload_id = $data->upload_id;
        }
        return $latest_upload_id;
    }

    /**
     * 日付のフォーマットを整える
     * @param string $latest_upload_id
     * return string $upload_date
     */
    private function formatUploadDate($latest_upload_id) {
        $upload = Uploads::find(
                        array(
                            "id = $latest_upload_id"
                        )
        );
        foreach ($upload as $data) {
            $upload_daily_data_str = $data->target_date;
        }
        $origin_str_list = explode(' ', $upload_daily_data_str); // [0] YYYY-MM-DD [1] 00:00:00
        $yyyy_mm_dd = $origin_str_list[0];
        $yyyy_mm_dd_list = explode('-', $yyyy_mm_dd);
        return $yyyy_mm_dd_list[0] . "年" . $yyyy_mm_dd_list[1] . "月" . $yyyy_mm_dd_list[2] . "日";
    }
    
    // 2020/02/02
    private function formatUploadDatee($latest_upload_id) {
        $upload = Uploads::findFirstWC($latest_upload_id);
        return date('F j, Y', strtotime($upload->target_date));
    }

    // JEPX
    public function indexAction() {
        $this->view->en = '/prerequisite/en';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_JEPX']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        // if ($auth['role'] < 3) { // 2016/05/28
        //     return $this->response->redirect('prerequisite/interconnect');
        // }
        // POSTされたデータ取得
        /* 2016/07/03
        $post_data_list = $this->request->getPost();
        $hhourly_upload = Uploads::find(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_HISTORICALMAIN,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        $hhourly_target_date = [];
        foreach ($hhourly_upload as $data) {
            $hhourly_target_date[] = date('Y-m-d', strtotime($data->target_date));
        }

        // JEPXスポット取引情報 JEPXインデックス
        if ($post_data_list['selected_date_spot']) {
            $strDisplayDate = date('Y-m-d', strtotime($post_data_list['selected_date_spot']));
            // dailyの配信日(アップロードされた日)
            $spot_upload_date = date('Y年m月d日', strtotime($strDisplayDate));
        } else {
            $strDisplayDate = HistoricalMainSpots::maximum(
                            array(
                                'column' => 'hst_datetime',
                            )
            );
            $strDisplayDate = date('Y-m-d', strtotime($strDisplayDate));
            // dailyの配信日(アップロードされた日)
            $spot_upload_date = date('Y年m月d日', strtotime($strDisplayDate));
        }
        $strDisplayDateUntil = date('Y-m-d', strtotime('+1 day', strtotime($strDisplayDate)));
        */

        // データの取得
        $upload = Uploads::findFirst(
                    array(
                        'deleted=0 AND upload_type=:type:',
                        'bind' => array(
                            'type' => UploadController::DATA_HISTORICALMAIN,
                        ),
                        'order' => 'id DESC'
                    )
        );
            
        // 全履歴
        $spot_all = HistoricalMainSpots::find(
                    array(
                        'upload_id=:uploadId:',
                        'bind' => array(
                            'uploadId' => $upload->id,
                        ),
                        'order' => 'hst_datetime'
                    )
        );

        $spot_all_data_list = [];
        $i = 0;
        foreach ($spot_all as $data) {
            // 年月日
            $spot_all_data_list[$i]['hst_datetime'] = date('Y/m/d H:i:00', strtotime($data->hst_datetime));
            // 売り入札量(kWh)
            $spot_all_data_list[$i]['sale'] = $data->sale;
            // 買い入札量(kWh)
            $spot_all_data_list[$i]['buy'] = $data->buy;
            // 約定総量(kWh)
            $spot_all_data_list[$i]['contract'] = $data->contract;
            // システムプライス(円/kWh)
            $spot_all_data_list[$i]['price_system'] = $data->price_system;
            // エリアプライス北海道(円/kWh)
            $spot_all_data_list[$i]['price_area_01'] = $data->price_area_01;
            // エリアプライス東北(円/kWh)
            $spot_all_data_list[$i]['price_area_02'] = $data->price_area_02;
            // エリアプライス東京(円/kWh)
            $spot_all_data_list[$i]['price_area_03'] = $data->price_area_03;
            // エリアプライス中部(円/kWh)
            $spot_all_data_list[$i]['price_area_04'] = $data->price_area_04;
            // エリアプライス北陸(円/kWh)
            $spot_all_data_list[$i]['price_area_05'] = $data->price_area_05;
            // エリアプライス関西(円/kWh)
            $spot_all_data_list[$i]['price_area_06'] = $data->price_area_06;
            // エリアプライス中国(円/kWh)
            $spot_all_data_list[$i]['price_area_07'] = $data->price_area_07;
            // エリアプライス四国(円/kWh)
            $spot_all_data_list[$i]['price_area_08'] = $data->price_area_08;
            // エリアプライス九州(円/kWh)
            $spot_all_data_list[$i]['price_area_09'] = $data->price_area_09;

            // カレンダーに必要な日付
            // $calender_date_list[$i] = date('Y-m-d', strtotime($data->hst_datetime));

            $i++;
        }
        // $calender_date_list = array_unique($calender_date_list);
        // $calender_date_list = array_merge($calender_date_list);

        // JEPXインデックス
        /* 2016/07/03
        $upload_id = HistoricalMainIndexes::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );
        $latest_upload_id = $this->getLatestUploadId($upload_id);
        */

        // データの取得
        $index = HistoricalMainIndexes::find(
                    array(
                        'upload_id=:uploadId:',
                        'bind' => array(
                            'uploadId' => $upload->id,
                        ),
                        'order' => 'hst_datetime'
                    )
        );
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'JEPX Index %d', array(count($index)));
        $index_data_list = [];
        $i = 0;
        foreach ($index as $data) {
            // 年月日
            $index_data_list[$i]['hst_datetime'] = date('Y/m/d', strtotime($data->hst_datetime));
            // $index_data_list[$i]['hst_datetime'] = $this->removeDataHis($data->hst_datetime);
            // DA-24(kWh)
            $index_data_list[$i]['da_24'] = $data->da_24;
            // DA-DT(kWh)
            $index_data_list[$i]['da_dt'] = $data->da_dt;
            // DA-PT(kWh)
            $index_data_list[$i]['da_pt'] = $data->da_pt;
            // TTV(kWh)
            $index_data_list[$i]['ttv'] = $data->ttv;
            $i++;
        }

        // データの取得
        /* 2016/07/03
        if ($post_data_list['selected_date_subs']) {
            $target_date = date('Y-m-d', strtotime($post_data_list['selected_date_subs']));
            $subs_calender_query = Uploads::find(
                            array(
                                'deleted=:deleted: AND upload_type=:type: AND target_date LIKE :target_date:',
                                'bind' => array(
                                    'deleted' => 0,
                                    'type' => UploadController::DATA_HISTORICALSUB,
                                    'target_date' => '%' . $target_date . '%'
                                )
                            )
            );
            // ヒストリカルサブのカレンダーリスト
            foreach ($subs_calender_query as $value) {
                $latest_upload_id = $value->id;
            }
        }
        */

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'active_historicaldata' => 'active',
                    'day' => '全履歴',
                    // 'spot_upload_date' => $spot_upload_date,
                    // 'spot_upload_date_2' => $calender_date_list,
                    'spot_all_data_list' => $spot_all_data_list,
                    'index_data_list' => $index_data_list,
                    // 'index_upload_date' => $spot_upload_date,
                    // 'calender_date_list2' => $calender_date_list,
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                // ヒストリカルデータ(スポット,日時インデックス)
                ->addCss('css/chart_jepx.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_spot_all.js')
                    ->addJs('js/chart_index.js');
        }

        // 権限の設定
        /*
        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
        */
    }

    // 燃料・為替先物
    public function fuelandexchangeAction() {
        $this->view->en = '/prerequisite/fuelandexchangee';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // $userRole = 0;
        // $auth = $this->session->get('auth');
        // if (!empty($auth)) {
        //     $userRole = $auth['role'];
        // }

        // POSTされたデータ取得
        $post_data_list = $this->request->getPost();

        // 燃料・為替先物
        // 原油先物 石炭先物 為替
        // カレンダーに使う日付をDBから取得
        $subs_calender_query = Uploads::find(
                        array(
                            // '(deleted=:deletedFlag:) AND (upload_type=:uploadType:) AND (target_date>:targetDate:)',
                            '(deleted=:deletedFlag:) AND (upload_type=:uploadType:)',
                            'bind' => array(
                                'deletedFlag' => 0,
                                'uploadType' => UploadController::DATA_HISTORICALSUB,
                            // 'targetDate' => ($userRole < 9 ? Date('Y-m-d', strtotime('-5 days')) : '1970-01-01'),   // 2016/04/03
                            ),
                            'order' => 'target_date DESC',
                            // 'limit' => ($userRole < 9 ? 5 : 1000), // 2016/04/18
                            'limit' => (($auth_bits & $this->authority['ADMIN']) ? 1000 : 5), // 2018/10/06
                        )
        );
        // ヒストリカルサブのカレンダーリスト
        $subs_calender_date_list = [];
        foreach ($subs_calender_query as $value) {
            $subs_calender_date_list[] = date('Y-m-d', strtotime($value->target_date));
        }

        $upload_id = HistoricalSubs::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );
        $latest_upload_id = $this->getLatestUploadId($upload_id);

        // データの取得
        if (!empty($post_data_list['selected_date_subs'])) {    // 2018/10/19
            $target_date = date('Y-m-d', strtotime($post_data_list['selected_date_subs']));
            $subs_calender_query = Uploads::find(
                            array(
                                'deleted=:deleted: AND upload_type=:type: AND target_date LIKE :target_date:',
                                'bind' => array(
                                    'deleted' => 0,
                                    'type' => UploadController::DATA_HISTORICALSUB,
                                    'target_date' => '%' . $target_date . '%'
                                ),
                            )
            );
            // ヒストリカルサブのカレンダーリスト
            foreach ($subs_calender_query as $value) {
                $latest_upload_id = $value->id;
            }
        }
        // else    // 2018/10/19
        // {
        //     $target_date = null;
        //     $subs_calender_query = [];
        //     $latest_upload_id = null;
        // }
        // dailyの配信日(アップロードされた日)
        $subs_upload_date = $this->formatUploadDate($latest_upload_id);
        $strTargetDate = $this->formatUploadDatee($latest_upload_id);
        $date = DateTime::createFromFormat('Y年m月d日', $subs_upload_date);
        $export_date = $date->format('Ymd');

        $subs = HistoricalSubs::find(
                        array(
                            'upload_id=:uploadId:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                            ),
                            'order' => 'hst_datetime'
                        )
        );
        $coal_data_list = [];
        $oil_data_list = [];
        $exchange_data_list = [];
        $coal_i = 0;
        $oil_i = 0;
        $exchange_i = 0;
        foreach ($subs as $data) {
            /* 2022/03/17 202203-02
            // 石炭先物
            if ($data->coal > 0) {    // 2016/03/11
                $coal_data_list[$coal_i]['coal'] = $data->coal;
                $coal_data_list[$coal_i]['coal_hst_datetime'] = date('Y/m/d', strtotime($data->hst_datetime));
                $coal_i++;
            }

            // 原油先物
            if (!is_null($data->oil)) {    // 2016/03/11
                $oil_data_list[$oil_i]['oil'] = $data->oil;
                $oil_data_list[$oil_i]['oil_hst_datetime'] = date('Y/m/d', strtotime($data->hst_datetime));
                $oil_i++;
            }
             * 
             */

            // 為替
            if ($data->exchange > 0) {   // 2016/03/11
                $exchange_data_list[$exchange_i]['exchange'] = $data->exchange;
                $exchange_data_list[$exchange_i]['exchange_hst_datetime'] = date('Y/m/d', strtotime($data->hst_datetime));
                $exchange_i++;
            }
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'coal_data_list' => $coal_data_list,
                    'oil_data_list' => $oil_data_list,
                    'exchange_data_list' => $exchange_data_list,
                    'subs_upload_date' => $subs_upload_date,
                    'subs_calender_date_list' => $subs_calender_date_list,
                    'export_date' => $export_date,
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_fuelandexchange.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        
        // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    /* 2022/03/17 202203-02
                    ->addJs('js/chart_hst_oil.js')
                    ->addJs('js/chart_hst_coal.js')
                     * 
                     */
                    ->addJs('js/chart_hst_exchange.js')
                    ;
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'dict' => "{'Settlement_Price (円/$)':'Settlement_Price (円/$)','ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 需要・再エネ想定
    public function demandandrenewableenergyAction() {
        $this->view->en = '/prerequisite/demandandrenewableenergye';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = Prerequisites::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'export_date' => date('Ymd'),
                    'filename_area' => '',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
        // 権限の設定
        // $auth = $this->session->get('auth');
        // CSSのローカルリソースを追加します
        $this->assets
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_demand_forecast.js')
                    ->addJs('js/chart_residual_load.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 需要・再エネ想定 東エリア
    public function demandandrenewableenergyeastAction() {
        $this->view->en = '/prerequisite/demandandrenewableenergyeaste';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DEMAND_ALL']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_E,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesEast::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'export_date' => date('Ymd'),
                    'filename_area' => '_east',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
        // 権限の設定
        // $auth = $this->session->get('auth');
        // CSSのローカルリソースを追加します
        $this->assets
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_demand_forecast.js')
                    ->addJs('js/chart_residual_load.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 需要・再エネ想定 西エリア
    public function demandandrenewableenergywestAction() {
        $this->view->en = '/prerequisite/demandandrenewableenergyweste';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
       
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DEMAND_ALL']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_W,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesWest::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'export_date' => date('Ymd'),
                    'filename_area' => '_west',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
        // 権限の設定
        // $auth = $this->session->get('auth');
        // CSSのローカルリソースを追加します
        $this->assets
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_demand_forecast.js')
                    ->addJs('js/chart_residual_load.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 需要・再エネ想定 北海道  2017/02/19
    public function demandandrenewableenergyhAction() {
        $this->view->en = '/prerequisite/demandandrenewableenergyhe';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DEMAND_ALL']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_H,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesHokkaido::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'export_date' => date('Ymd'),
                    'filename_area' => '_hokkaido',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
        // 権限の設定
        // $auth = $this->session->get('auth');
        // CSSのローカルリソースを追加します
        $this->assets
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_demand_forecast.js')
                    ->addJs('js/chart_residual_load.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 需要・再エネ想定 九州
    public function demandandrenewableenergykAction() {
        $this->view->en = '/prerequisite/demandandrenewableenergyke';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DEMAND_ALL']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_K,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesKyushu::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'export_date' => date('Ymd'),
                    'filename_area' => '_kyushu',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_demand_all_menu' => ($auth_bits & $this->authority['PRE_DEMAND_ALL']),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
        // 権限の設定
        // $auth = $this->session->get('auth');
        // CSSのローカルリソースを追加します
        $this->assets
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
                    ->addJs('js/chart_demand_forecast.js')
                    ->addJs('js/chart_residual_load.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 燃料炉前価格想定
    public function fuelAction() {
        $this->view->en = '/prerequisite/fuele';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_FUEL']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // POSTされたデータ取得
        $post_data_list = $this->request->getPost();

        // 燃料炉前価格想定
        // 石油炉前価格想定 
        $upload_id = ForwardSubOils::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );

        $latest_upload_id = $this->getLatestUploadId($upload_id);

        // データの取得
        // if ($post_data_list['selected_date_oil_lng_coal']) { 2018/10/19
        if (!empty($post_data_list['selected_date_oil_lng_coal'])) {
            $target_date = date('Y-m-d', strtotime($post_data_list['selected_date_oil_lng_coal']));
            $oil_lng_coal_calender_query = Uploads::find(
                            array(
                                'deleted=:deleted: AND upload_type=:type: AND target_date LIKE :target_date:',
                                'bind' => array(
                                    'deleted' => 0,
                                    'type' => UploadController::DATA_FORWARDSUB,
                                    'target_date' => '%' . $target_date . '%'
                                )
                            )
            );
            // ヒストリカルサブのカレンダーリスト
            foreach ($oil_lng_coal_calender_query as $value) {
                $latest_upload_id = $value->id;
            }
        }
        // dailyの配信日(アップロードされた日)
        $oil_lng_coal_upload_date = $this->formatUploadDate($latest_upload_id);
        $oil_lng_coal_upload_datee = $this->formatUploadDatee($latest_upload_id);

        // exportに使う日付
        $date = DateTime::createFromFormat('Y年m月d日', $oil_lng_coal_upload_date);
        $export_date = $date->format('Ymd');


        // データの取得
        // 石油
        $sub_oil = ForwardSubOils::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_oil_data_list = [];
        $i = 0;
        foreach ($sub_oil as $data) {
            $sub_oil_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_oil_data_list[$i]['price'] = $data->price;
            // カレンダーに必要な日付
            if (strtotime('-1 month') < strtotime($data->fc_datetime)) { // 2016/03/31
                $oil_lng_coal_calender_date_list[$i] = date('Y-m-d', strtotime($data->fc_datetime));
            }

            $i++;
        }

        // 2022/07/11 石油追加調達
        $sub_oil_add_data_list = [];
        if($this->session->get(self::SV_SHOW202207))
        {
            $sub_oil = ForwardSubOilAdds::find(
                            array(
                                "upload_id = $latest_upload_id"
                            )
            );
            $i = 0;
            foreach ($sub_oil as $data) {
                $sub_oil_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
                $sub_oil_add_data_list[$i]['price'] = $data->price;
                // カレンダーに必要な日付
                // if (strtotime('-1 month') < strtotime($data->fc_datetime)) { // 2016/03/31
                //     $oil_lng_coal_calender_date_list[$i] = date('Y-m-d', strtotime($data->fc_datetime));
                // }

                $i++;
            }
        }
        
        // 石炭
        $oil_lng_coal_calender_query = Uploads::find(
                        array(
                            'deleted=:deleted: AND upload_type=:type: AND target_date',
                            'bind' => array(
                                'deleted' => 0,
                                'type' => UploadController::DATA_FORWARDSUB
                            )
                        )
        );
        // ヒストリカルサブのカレンダーリスト
        foreach ($oil_lng_coal_calender_query as $value) {
            if ($auth['role'] == 9 || strtotime($value->target_date) > strtotime('-1 Month')) {  // 2016/04/03
                $oil_lng_coal_exist_upload_date[] = date('Y-m-d', strtotime($value->target_date));
            }
        }
        $oil_lng_coal_calender_date_list = array_unique($oil_lng_coal_calender_date_list);
        $oil_lng_coal_calender_date_list = array_merge($oil_lng_coal_calender_date_list);

        // データの取得
        $sub_lng = ForwardSubLngs::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_lng_data_list = [];
        $i = 0;
        foreach ($sub_lng as $data) {
            $sub_lng_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_lng_data_list[$i]['price'] = $data->price;
            $i++;
        }

        // >>> 2022/03/17 202203-03
        // データの取得
        $sub_lng = ForwardSubLngAdds::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_lng_add_data_list = [];
        $i = 0;
        foreach ($sub_lng as $data) {
            $sub_lng_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_lng_add_data_list[$i]['price'] = $data->price;
            $i++;
        }
        // <<< 2022/03/17 202203-03

        // データの取得
        $sub_coal = ForwardSubCoals::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_coal_data_list = [];
        $i = 0;
        foreach ($sub_coal as $data) {
            $sub_coal_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_coal_data_list[$i]['price'] = $data->price;
            $i++;
        }

        // 2022/07/11 石炭追加調達
        $sub_coal_add_data_list = [];
        if($this->session->get(self::SV_SHOW202207))
        {
            $sub_oil = ForwardSubCoalAdds::find(
                            array(
                                "upload_id = $latest_upload_id"
                            )
            );
            $i = 0;
            foreach ($sub_oil as $data) {
                $sub_coal_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
                $sub_coal_add_data_list[$i]['price'] = $data->price;
                $i++;
            }
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'day' => '全履歴',
                    // 石油価格想定 LNG価格想定 石炭価格想定
                    'sub_oil_data_list' => $sub_oil_data_list,
                    'sub_oil_add_data_list' => $sub_oil_add_data_list,      // 2022/07/11
                    'sub_lng_data_list' => $sub_lng_data_list,
                    'sub_lng_add_data_list' => $sub_lng_add_data_list,      // 2022/03/17 202203-03
                    'sub_coal_data_list' => $sub_coal_data_list,
                    'sub_coal_add_data_list' => $sub_coal_add_data_list,    // 2022/07/11
                    'oil_lng_coal_calender_date_list' => $oil_lng_coal_calender_date_list,
                    'oil_lng_coal_upload_date' => $oil_lng_coal_upload_date,
                    'oil_lng_coal_upload_datee' => $oil_lng_coal_upload_datee,  // 2020/02/02
                    'oil_lng_coal_exist_upload_date' => $oil_lng_coal_exist_upload_date,
                    'export_date' => $export_date,
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/07
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                // 燃料炉前価格想定(石油価格想定, LNG価格想定, 石炭価格想定)
                ->addCss('css/chart_fuel.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                    ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_sub_oil.js')
                    ->addJs('js/chart_sub_lng.js')
                    ->addJs('js/chart_sub_lng_add.js')  // 2022/03/17 202203-03
                    ->addJs('js/chart_sub_coal.js')
                    ;
            if($this->session->get(self::SV_SHOW202207))
            {   // 2022/07/21 202207-02
                $this->assets
                        ->addJs('js/chart_sub_oil_add.js')  // 2022/07/11
                        ->addJs('js/chart_sub_coal_add.js')  // 2022/07/11
                        ;
            }
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'dict' => "{'Price (千円/MWh)':'Price (千円/MWh)', 'ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 2019/02/07 燃料CIF価格想定
    public function fuelcifAction() {
        $this->view->en = '/prerequisite/fuelcife';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        if(($auth_bits & $this->authority['PRE_FUEL_CIF']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // POSTされたデータ取得
        $post_data_list = $this->request->getPost();

        // 燃料CIF価格想定
        // 石油価格想定 
        $upload_id = ForwardSubCifOils::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );

        $latest_upload_id = $this->getLatestUploadId($upload_id);

        // データの取得
        if (!empty($post_data_list['selected_date_oil_lng_coal'])) {
            $target_date = date('Y-m-d', strtotime($post_data_list['selected_date_oil_lng_coal']));
            $oil_lng_coal_calender_query = Uploads::find(
                            array(
                                'deleted=0 AND upload_type=:type: AND target_date LIKE :target_date:',
                                'bind' => array(
                                    'type' => UploadController::DATA_FORWARDSUB_CIF,
                                    'target_date' => '%' . $target_date . '%'
                                )
                            )
            );
            // ヒストリカルサブのカレンダーリスト
            foreach ($oil_lng_coal_calender_query as $value) {
                $latest_upload_id = $value->id;
            }
        }
        // dailyの配信日(アップロードされた日)
        $oil_lng_coal_upload_date = $this->formatUploadDate($latest_upload_id);
        $oil_lng_coal_upload_datee = $this->formatUploadDatee($latest_upload_id);
        // var_dump(date('Y',strtotime($oil_lng_coal_upload_datee)));exit(0); 
        // $upload_year = date('Y',strtotime($oil_lng_coal_upload_datee));     // 2022/03/17
        $upload_year = date('Y');       // 2022/03/18

        // exportに使う日付
        $date = DateTime::createFromFormat('Y年m月d日', $oil_lng_coal_upload_date);
        $export_date = $date->format('Ymd');


        // データの取得
        $sub_oil = ForwardSubCifOils::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_oil_data_list = [];
        $i = 0;
        foreach ($sub_oil as $data) {
            $sub_oil_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_oil_data_list[$i]['price'] = $data->price;
            // カレンダーに必要な日付
            if (strtotime('-1 month') < strtotime($data->fc_datetime)) { // 2016/03/31
                $oil_lng_coal_calender_date_list[$i] = date('Y-m-d', strtotime($data->fc_datetime));
            }

            $i++;
        }

        $oil_lng_coal_calender_query = Uploads::find(
                        array(
                            'deleted=0 AND upload_type=:type: AND target_date',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF
                            )
                        )
        );
        // ヒストリカルサブのカレンダーリスト
        foreach ($oil_lng_coal_calender_query as $value) {
            if ($auth['role'] == 9 || strtotime($value->target_date) > strtotime('-1 Month')) {  // 2016/04/03
                $oil_lng_coal_exist_upload_date[] = date('Y-m-d', strtotime($value->target_date));
            }
        }
        $oil_lng_coal_calender_date_list = array_unique($oil_lng_coal_calender_date_list);
        $oil_lng_coal_calender_date_list = array_merge($oil_lng_coal_calender_date_list);

        // 2022/07/11 石油追加調達
        $sub_oil_add_data_list = [];
        if($this->session->get(self::SV_SHOW202207))
        {
            $sub_oil = ForwardSubCifOilAdds::find(
                            array(
                                "upload_id = $latest_upload_id"
                            )
            );
            $i = 0;
            foreach ($sub_oil as $data) {
                $sub_oil_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
                $sub_oil_add_data_list[$i]['price'] = $data->price;

                $i++;
            }
        }

        // データの取得
        $sub_lng = ForwardSubCifLngs::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_lng_data_list = [];
        $i = 0;
        foreach ($sub_lng as $data) {
            $sub_lng_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_lng_data_list[$i]['price'] = $data->price;
            $i++;
        }

        // >>> 2022/03/17 202203-03
        // データの取得
        $sub_lng = ForwardSubCifLngAdds::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_lng_add_data_list = [];
        $i = 0;
        foreach ($sub_lng as $data) {
            $sub_lng_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_lng_add_data_list[$i]['price'] = $data->price;
            $i++;
        }
        // <<< 2022/03/17 202203-03

        // データの取得
        $sub_coal = ForwardSubCifCoals::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $sub_coal_data_list = [];
        $i = 0;
        foreach ($sub_coal as $data) {
            $sub_coal_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $sub_coal_data_list[$i]['price'] = $data->price;
            $i++;
        }

        // 2022/07/11 石炭追加調達
        $sub_coal_add_data_list = [];
        if($this->session->get(self::SV_SHOW202207))
        {
            $sub_coal = ForwardSubCifCoalAdds::find(
                            array(
                                "upload_id = $latest_upload_id"
                            )
            );
            $i = 0;
            foreach ($sub_coal as $data) {
                $sub_coal_add_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
                $sub_coal_add_data_list[$i]['price'] = $data->price;
                $i++;
            }
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'day' => '全履歴',
                    // 石油価格想定 LNG価格想定 石炭価格想定
                    'sub_oil_data_list' => $sub_oil_data_list,
                    'sub_oil_add_data_list' => $sub_oil_add_data_list,      // 2022/07/11
                    'sub_lng_data_list' => $sub_lng_data_list,
                    'sub_lng_add_data_list' => $sub_lng_add_data_list,      // 2022/03/17 202203-03
                    'sub_coal_data_list' => $sub_coal_data_list,
                    'sub_coal_add_data_list' => $sub_coal_add_data_list,    // 2022/07/11
                    'oil_lng_coal_calender_date_list' => $oil_lng_coal_calender_date_list,
                    'oil_lng_coal_upload_date' => $oil_lng_coal_upload_date,
                    'oil_lng_coal_upload_datee' => $oil_lng_coal_upload_datee,
                    'oil_lng_coal_exist_upload_date' => $oil_lng_coal_exist_upload_date,
                    'export_date' => $export_date,
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                    'upload_year' => $upload_year,  // 2022/03/17
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                // 燃料価格想定(石油価格想定, LNG価格想定, 石炭価格想定)
                ->addCss('css/chart_fuel.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/datePicker/jquery-ui.js')
                ;
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                ->addJs('js/datePicker/jquery.ui.datepicker-ja.js')
                ;
        }
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_fuelcif_oil.js')
                    ->addJs('js/chart_fuelcif_lng.js')
                    ->addJs('js/chart_fuelcif_lng_add.js')  // 2022/03/17 202203-03
                    ->addJs('js/chart_fuelcif_coal.js')
                    ;
            if($this->session->get(self::SV_SHOW202207))
            {   // 2022/07/21 202207-02
                $this->assets
                    ->addJs('js/chart_fuelcif_oil_add.js')  // 2022/07/11
                    ->addJs('js/chart_fuelcif_coal_add.js')  // 2022/07/11
                    ;
            }
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'dict' => "{'Price (円/kl)':'Price (円/kl)','Price (円/t)':'Price (円/t)', 'ダウンロード':'ダウンロード'}",
                )
        );
    }

    // 供給力想定
    public function capacityAction() {
        $this->view->en = '/prerequisite/capacitye';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
         
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // イベント情報取得(nuclear)
        $event_category = 'nuclear';
        $event = Events::find(
                        array(
                            'category=:category:',
                            'bind' => array(
                                'category' => $event_category
                            )
                        )
        );
        // イベントのデータの配列(nuclear)
        $event_data_list_for_nuclear = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_nuclear[$i]['id'] = $data->id;
            $event_data_list_for_nuclear[$i]['dt'] = $data->dt;
            $event_data_list_for_nuclear[$i]['area'] = $data->area;
            $event_data_list_for_nuclear[$i]['category'] = $data->category;
            $event_data_list_for_nuclear[$i]['event'] = $data->event;
            $event_data_list_for_nuclear[$i]['description'] = $data->description;
            $event_data_list_for_nuclear[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        
        // イベント情報取得(thermal)
        $event_category_oil = 'oil';
        $event_category_coal = 'coal';
        $event_category_lng = 'lng';
        $event = Events::find(
                        array(
                            'category=:category1: OR category=:category2: OR category=:category3:',
                            'bind' => array(
                                'category1' => $event_category_oil,
                                'category2' => $event_category_coal,
                                'category3' => $event_category_lng,
                            )
                        )
        );
        // イベントのデータの配列(thermal)
        $event_data_list_for_thermal = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_thermal[$i]['id'] = $data->id;
            $event_data_list_for_thermal[$i]['dt'] = $data->dt;
            $event_data_list_for_thermal[$i]['area'] = $data->area;
            $event_data_list_for_thermal[$i]['category'] = $data->category;
            $event_data_list_for_thermal[$i]['event'] = $data->event;
            $event_data_list_for_thermal[$i]['description'] = $data->description;
            $event_data_list_for_thermal[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        

        // 供給力　火力・原子力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY,
                            ),
                        )
        );
        $capacity_thermals_latest_upload_id = $upload->id;
        $capacity_nuclears_latest_upload_id = $upload->id;
        // 供給力想定日
        $supply_capacity_assumed_date = date('Y年m月d日', strtotime($upload->target_date));
        $supply_capacity_assumed_datee = date('F j, Y', strtotime($upload->target_date));       // 2020/02/02
        // exportに使う日付
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $capacity_thermals = CapacityThermals::find(
                        array(
                            "upload_id = $capacity_thermals_latest_upload_id"
                        )
        );

        $capacity_thermals_data_list = [];
        $i = 0;
        foreach ($capacity_thermals as $data) {
            $capacity_thermals_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_thermals_data_list[$i]['coal'] = $data->coal;
            $capacity_thermals_data_list[$i]['lng'] = $data->lng;
            $capacity_thermals_data_list[$i]['oil'] = $data->oil;
            $i++;
        }

        // データの取得
        $capacity_nuclears = CapacityNuclears::find(
                        array(
                            "upload_id = $capacity_nuclears_latest_upload_id"
                        )
        );

        $capacity_nuclears_data_list = [];
        $i = 0;
        foreach ($capacity_nuclears as $data) {
            $capacity_nuclears_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_nuclears_data_list[$i]['nuclear'] = $data->nuclear;
            $i++;
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = Prerequisites::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['wind'] = $data->wind;
            $demand_forecast_data_list[$i]['solar'] = $data->solar;
            $demand_forecast_data_list[$i]['geothermal'] = $data->geothermal;
            $demand_forecast_data_list[$i]['biomass'] = $data->biomass;
            $demand_forecast_data_list[$i]['hydro'] = $data->hydro;
            $demand_forecast_data_list[$i]['hydro_pump'] = $data->hydro_pump;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'capacity_thermals_data_list' => $capacity_thermals_data_list,
                    'capacity_nuclears_data_list' => $capacity_nuclears_data_list,
                    'event_data_list_for_thermal' => $event_data_list_for_thermal,
                    'event_data_list_for_nuclear' => $event_data_list_for_nuclear,
                    // 前提条件(需要,電力,太陽光)
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'supply_capacity_assumed_date' => $supply_capacity_assumed_date,
                    'supply_capacity_assumed_datee' => $supply_capacity_assumed_datee,
                    'export_date' => $export_date,
                    'filename_area' => '',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_capcity.css')
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
                // 前提条件(需要,電力,太陽光)
            $this->assets
                    ->addJs('js/chart_capacity_thermals.js')
                    ->addJs('js/chart_capacity_nuclears.js')
                    ->addJs('js/chart_solar.js')
                    ->addJs('js/chart_wind.js')
                    ->addJs('js/chart_hydro.js')
                    ->addJs('js/chart_hydro_pump.js')
                    ->addJs('js/chart_capacity_geothermal_power.js')
                    ->addJs('js/chart_capacity_biomass.js')
            ;
        }

        /*
          $this->view->setVars(
          array(
          'email' => $auth['user_id'],
          'role' => $auth['role']
          )
          );
         * 
         */
    }

    // 供給力想定 東エリア
    public function capacityeastAction() {
        $this->view->en = '/prerequisite/capacityeaste';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // イベント情報取得(nuclear)
        $event_category = 'nuclear';
        $event = Events::find(
                        array(
                            'area=:area: AND category=:category:',
                            'bind' => array(
                                'area' => 'East',
                                'category' => $event_category
                            )
                        )
        );
        // イベントのデータの配列(nuclear)
        $event_data_list_for_nuclear = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_nuclear[$i]['id'] = $data->id;
            $event_data_list_for_nuclear[$i]['dt'] = $data->dt;
            $event_data_list_for_nuclear[$i]['area'] = $data->area;
            $event_data_list_for_nuclear[$i]['category'] = $data->category;
            $event_data_list_for_nuclear[$i]['event'] = $data->event;
            $event_data_list_for_nuclear[$i]['description'] = $data->description;
            $event_data_list_for_nuclear[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        
        // イベント情報取得(thermal)
        $event_category_oil = 'oil';
        $event_category_coal = 'coal';
        $event_category_lng = 'lng';
        $event = Events::find(
                        array(
                            'area=:area: AND (category=:category1: OR category=:category2: OR category=:category3:)',
                            'bind' => array(
                                'area' => 'East',
                                'category1' => $event_category_oil,
                                'category2' => $event_category_coal,
                                'category3' => $event_category_lng,
                            )
                        )
        );
        // イベントのデータの配列(thermal)
        $event_data_list_for_thermal = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_thermal[$i]['id'] = $data->id;
            $event_data_list_for_thermal[$i]['dt'] = $data->dt;
            $event_data_list_for_thermal[$i]['area'] = $data->area;
            $event_data_list_for_thermal[$i]['category'] = $data->category;
            $event_data_list_for_thermal[$i]['event'] = $data->event;
            $event_data_list_for_thermal[$i]['description'] = $data->description;
            $event_data_list_for_thermal[$i]['upload_id'] = $data->upload_id;
            $i++;
        }

        // 供給力　火力・原子力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_E,
                            ),
                        )
        );
        $capacity_thermals_latest_upload_id = $upload->id;
        $capacity_nuclears_latest_upload_id = $upload->id;
        // 供給力想定日
        $supply_capacity_assumed_date = date('Y年m月d日', strtotime($upload->target_date));
        $supply_capacity_assumed_datee = date('F j, Y', strtotime($upload->target_date));       // 2020/02/02
        // exportに使う日付
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $capacity_thermals = CapacityThermalsEast::find(
                        array(
                            "upload_id = $capacity_thermals_latest_upload_id"
                        )
        );

        $capacity_thermals_data_list = [];
        $i = 0;
        foreach ($capacity_thermals as $data) {
            $capacity_thermals_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_thermals_data_list[$i]['coal'] = $data->coal;
            $capacity_thermals_data_list[$i]['lng'] = $data->lng;
            $capacity_thermals_data_list[$i]['oil'] = $data->oil;
            $i++;
        }

        // データの取得
        $capacity_nuclears = CapacityNuclearsEast::find(
                        array(
                            "upload_id = $capacity_nuclears_latest_upload_id"
                        )
        );

        $capacity_nuclears_data_list = [];
        $i = 0;
        foreach ($capacity_nuclears as $data) {
            $capacity_nuclears_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_nuclears_data_list[$i]['nuclear'] = $data->nuclear;
            $i++;
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_E,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesEast::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['wind'] = $data->wind;
            $demand_forecast_data_list[$i]['solar'] = $data->solar;
            $demand_forecast_data_list[$i]['geothermal'] = $data->geothermal;
            $demand_forecast_data_list[$i]['biomass'] = $data->biomass;
            $demand_forecast_data_list[$i]['hydro'] = $data->hydro;
            $demand_forecast_data_list[$i]['hydro_pump'] = $data->hydro_pump;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'capacity_thermals_data_list' => $capacity_thermals_data_list,
                    'capacity_nuclears_data_list' => $capacity_nuclears_data_list,
                    'event_data_list_for_thermal' => $event_data_list_for_thermal,
                    'event_data_list_for_nuclear' => $event_data_list_for_nuclear,
                    // 前提条件(需要,電力,太陽光)
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'supply_capacity_assumed_date' => $supply_capacity_assumed_date,
                    'supply_capacity_assumed_datee' => $supply_capacity_assumed_datee,
                    'export_date' => $export_date,
                    'filename_area' => '_east',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_capcity.css')
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_capacity_thermals.js')
                ->addJs('js/chart_capacity_nuclears.js')
                // 前提条件(需要,電力,太陽光)
                ->addJs('js/chart_solar.js')
                ->addJs('js/chart_wind.js')
                ->addJs('js/chart_hydro.js')
                ->addJs('js/chart_hydro_pump.js')
                ->addJs('js/chart_capacity_geothermal_power.js')
                ->addJs('js/chart_capacity_biomass.js')
        ;
    }

    // 供給力想定 北海道
    public function capacityhokkaidoAction() {
        $this->view->en = '/prerequisite/capacityhokkaidoe';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // イベント情報取得(nuclear)
        $event_category = 'nuclear';
        $event = Events::find(
                        array(
                            'area=:area: AND category=:category:',
                            'bind' => array(
                                'area' => 'Hokkaido',
                                'category' => $event_category
                            )
                        )
        );
        // イベントのデータの配列(nuclear)
        $event_data_list_for_nuclear = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_nuclear[$i]['id'] = $data->id;
            $event_data_list_for_nuclear[$i]['dt'] = $data->dt;
            $event_data_list_for_nuclear[$i]['area'] = $data->area;
            $event_data_list_for_nuclear[$i]['category'] = $data->category;
            $event_data_list_for_nuclear[$i]['event'] = $data->event;
            $event_data_list_for_nuclear[$i]['description'] = $data->description;
            $event_data_list_for_nuclear[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        
        // イベント情報取得(thermal)
        $event_category_oil = 'oil';
        $event_category_coal = 'coal';
        $event_category_lng = 'lng';
        $event = Events::find(
                        array(
                            'area=:area: AND (category=:category1: OR category=:category2: OR category=:category3:)',
                            'bind' => array(
                                'area' => 'Hokkaido',
                                'category1' => $event_category_oil,
                                'category2' => $event_category_coal,
                                'category3' => $event_category_lng,
                            )
                        )
        );
        // イベントのデータの配列(thermal)
        $event_data_list_for_thermal = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_thermal[$i]['id'] = $data->id;
            $event_data_list_for_thermal[$i]['dt'] = $data->dt;
            $event_data_list_for_thermal[$i]['area'] = $data->area;
            $event_data_list_for_thermal[$i]['category'] = $data->category;
            $event_data_list_for_thermal[$i]['event'] = $data->event;
            $event_data_list_for_thermal[$i]['description'] = $data->description;
            $event_data_list_for_thermal[$i]['upload_id'] = $data->upload_id;
            $i++;
        }

        // 供給力　火力・原子力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_H,
                            ),
                        )
        );
        $capacity_thermals_latest_upload_id = $upload->id;
        $capacity_nuclears_latest_upload_id = $upload->id;
        // 供給力想定日
        $supply_capacity_assumed_date = date('Y年m月d日', strtotime($upload->target_date));
        $supply_capacity_assumed_datee = date('F j, Y', strtotime($upload->target_date));       // 2020/02/02
        // exportに使う日付
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $capacity_thermals = CapacityThermalsHokkaido::find(
                        array(
                            "upload_id = $capacity_thermals_latest_upload_id"
                        )
        );

        $capacity_thermals_data_list = [];
        $i = 0;
        foreach ($capacity_thermals as $data) {
            $capacity_thermals_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_thermals_data_list[$i]['coal'] = $data->coal;
            $capacity_thermals_data_list[$i]['lng'] = $data->lng;
            $capacity_thermals_data_list[$i]['oil'] = $data->oil;
            $i++;
        }

        // データの取得
        $capacity_nuclears = CapacityNuclearsHokkaido::find(
                        array(
                            "upload_id = $capacity_nuclears_latest_upload_id"
                        )
        );

        $capacity_nuclears_data_list = [];
        $i = 0;
        foreach ($capacity_nuclears as $data) {
            $capacity_nuclears_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_nuclears_data_list[$i]['nuclear'] = $data->nuclear;
            $i++;
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_H,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesHokkaido::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['wind'] = $data->wind;
            $demand_forecast_data_list[$i]['solar'] = $data->solar;
            $demand_forecast_data_list[$i]['geothermal'] = $data->geothermal;
            $demand_forecast_data_list[$i]['biomass'] = $data->biomass;
            $demand_forecast_data_list[$i]['hydro'] = $data->hydro;
            $demand_forecast_data_list[$i]['hydro_pump'] = $data->hydro_pump;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'capacity_thermals_data_list' => $capacity_thermals_data_list,
                    'capacity_nuclears_data_list' => $capacity_nuclears_data_list,
                    'event_data_list_for_thermal' => $event_data_list_for_thermal,
                    'event_data_list_for_nuclear' => $event_data_list_for_nuclear,
                    // 前提条件(需要,電力,太陽光)
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'supply_capacity_assumed_date' => $supply_capacity_assumed_date,
                    'supply_capacity_assumed_datee' => $supply_capacity_assumed_datee,
                    'export_date' => $export_date,
                    'filename_area' => '_hokkaido',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_capcity.css')
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_capacity_thermals.js')
                ->addJs('js/chart_capacity_nuclears.js')
                // 前提条件(需要,電力,太陽光)
                ->addJs('js/chart_solar.js')
                ->addJs('js/chart_wind.js')
                ->addJs('js/chart_hydro.js')
                ->addJs('js/chart_hydro_pump.js')
                ->addJs('js/chart_capacity_geothermal_power.js')
                ->addJs('js/chart_capacity_biomass.js')
        ;
    }

    // 供給力想定 九州
    public function capacitykyushuAction() {
        $this->view->en = '/prerequisite/capacitykyushue';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // イベント情報取得(nuclear)
        $event_category = 'nuclear';
        $event = Events::find(
                        array(
                            'area=:area: AND category=:category:',
                            'bind' => array(
                                'area' => 'Kyushu',
                                'category' => $event_category
                            )
                        )
        );
        // イベントのデータの配列(nuclear)
        $event_data_list_for_nuclear = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_nuclear[$i]['id'] = $data->id;
            $event_data_list_for_nuclear[$i]['dt'] = $data->dt;
            $event_data_list_for_nuclear[$i]['area'] = $data->area;
            $event_data_list_for_nuclear[$i]['category'] = $data->category;
            $event_data_list_for_nuclear[$i]['event'] = $data->event;
            $event_data_list_for_nuclear[$i]['description'] = $data->description;
            $event_data_list_for_nuclear[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        
        // イベント情報取得(thermal)
        $event_category_oil = 'oil';
        $event_category_coal = 'coal';
        $event_category_lng = 'lng';
        $event = Events::find(
                        array(
                            'area=:area: AND (category=:category1: OR category=:category2: OR category=:category3:)',
                            'bind' => array(
                                'area' => 'Kyushu',
                                'category1' => $event_category_oil,
                                'category2' => $event_category_coal,
                                'category3' => $event_category_lng,
                            )
                        )
        );
        // イベントのデータの配列(thermal)
        $event_data_list_for_thermal = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_thermal[$i]['id'] = $data->id;
            $event_data_list_for_thermal[$i]['dt'] = $data->dt;
            $event_data_list_for_thermal[$i]['area'] = $data->area;
            $event_data_list_for_thermal[$i]['category'] = $data->category;
            $event_data_list_for_thermal[$i]['event'] = $data->event;
            $event_data_list_for_thermal[$i]['description'] = $data->description;
            $event_data_list_for_thermal[$i]['upload_id'] = $data->upload_id;
            $i++;
        }

        // 供給力　火力・原子力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_K,
                            ),
                        )
        );
        $capacity_thermals_latest_upload_id = $upload->id;
        $capacity_nuclears_latest_upload_id = $upload->id;
        // 供給力想定日
        $supply_capacity_assumed_date = date('Y年m月d日', strtotime($upload->target_date));
        $supply_capacity_assumed_datee = date('F j, Y', strtotime($upload->target_date));       // 2020/02/02
        // exportに使う日付
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $capacity_thermals = CapacityThermalsKyushu::find(
                        array(
                            "upload_id = $capacity_thermals_latest_upload_id"
                        )
        );

        $capacity_thermals_data_list = [];
        $i = 0;
        foreach ($capacity_thermals as $data) {
            $capacity_thermals_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_thermals_data_list[$i]['coal'] = $data->coal;
            $capacity_thermals_data_list[$i]['lng'] = $data->lng;
            $capacity_thermals_data_list[$i]['oil'] = $data->oil;
            $i++;
        }

        // データの取得
        $capacity_nuclears = CapacityNuclearsKyushu::find(
                        array(
                            "upload_id = $capacity_nuclears_latest_upload_id"
                        )
        );

        $capacity_nuclears_data_list = [];
        $i = 0;
        foreach ($capacity_nuclears as $data) {
            $capacity_nuclears_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_nuclears_data_list[$i]['nuclear'] = $data->nuclear;
            $i++;
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_K,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesKyushu::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['wind'] = $data->wind;
            $demand_forecast_data_list[$i]['solar'] = $data->solar;
            $demand_forecast_data_list[$i]['geothermal'] = $data->geothermal;
            $demand_forecast_data_list[$i]['biomass'] = $data->biomass;
            $demand_forecast_data_list[$i]['hydro'] = $data->hydro;
            $demand_forecast_data_list[$i]['hydro_pump'] = $data->hydro_pump;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'capacity_thermals_data_list' => $capacity_thermals_data_list,
                    'capacity_nuclears_data_list' => $capacity_nuclears_data_list,
                    'event_data_list_for_thermal' => $event_data_list_for_thermal,
                    'event_data_list_for_nuclear' => $event_data_list_for_nuclear,
                    // 前提条件(需要,電力,太陽光)
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'supply_capacity_assumed_date' => $supply_capacity_assumed_date,
                    'supply_capacity_assumed_datee' => $supply_capacity_assumed_datee,
                    'export_date' => $export_date,
                    'filename_area' => '_kyushu',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_capcity.css')
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_capacity_thermals.js')
                ->addJs('js/chart_capacity_nuclears.js')
                // 前提条件(需要,電力,太陽光)
                ->addJs('js/chart_solar.js')
                ->addJs('js/chart_wind.js')
                ->addJs('js/chart_hydro.js')
                ->addJs('js/chart_hydro_pump.js')
                ->addJs('js/chart_capacity_geothermal_power.js')
                ->addJs('js/chart_capacity_biomass.js')
        ;
    }

    // 供給力想定 西エリア
    public function capacitywestAction() {
        $this->view->en = '/prerequisite/capacityweste';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // イベント情報取得(nuclear)
        $event_category = 'nuclear';
        $event = Events::find(
                        array(
                            'area=:area: AND category=:category:',
                            'bind' => array(
                                'area' => 'West',
                                'category' => $event_category
                            )
                        )
        );
        // イベントのデータの配列(nuclear)
        $event_data_list_for_nuclear = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_nuclear[$i]['id'] = $data->id;
            $event_data_list_for_nuclear[$i]['dt'] = $data->dt;
            $event_data_list_for_nuclear[$i]['area'] = $data->area;
            $event_data_list_for_nuclear[$i]['category'] = $data->category;
            $event_data_list_for_nuclear[$i]['event'] = $data->event;
            $event_data_list_for_nuclear[$i]['description'] = $data->description;
            $event_data_list_for_nuclear[$i]['upload_id'] = $data->upload_id;
            $i++;
        }
        
        // イベント情報取得(thermal)
        $event_category_oil = 'oil';
        $event_category_coal = 'coal';
        $event_category_lng = 'lng';
        $event = Events::find(
                        array(
                            'area=:area: AND (category=:category1: OR category=:category2: OR category=:category3:)',
                            'bind' => array(
                                'area' => 'West',
                                'category1' => $event_category_oil,
                                'category2' => $event_category_coal,
                                'category3' => $event_category_lng,
                            )
                        )
        );
        // イベントのデータの配列(thermal)
        $event_data_list_for_thermal = [];
        $i = 0;
        foreach ($event as $data) {
            $event_data_list_for_thermal[$i]['id'] = $data->id;
            $event_data_list_for_thermal[$i]['dt'] = $data->dt;
            $event_data_list_for_thermal[$i]['area'] = $data->area;
            $event_data_list_for_thermal[$i]['category'] = $data->category;
            $event_data_list_for_thermal[$i]['event'] = $data->event;
            $event_data_list_for_thermal[$i]['description'] = $data->description;
            $event_data_list_for_thermal[$i]['upload_id'] = $data->upload_id;
            $i++;
        }

        // 供給力　火力・原子力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_W,
                            ),
                        )
        );
        $capacity_thermals_latest_upload_id = $upload->id;
        $capacity_nuclears_latest_upload_id = $upload->id;
        // 供給力想定日
        $supply_capacity_assumed_date = date('Y年m月d日', strtotime($upload->target_date));
        $supply_capacity_assumed_datee = date('F j, Y', strtotime($upload->target_date));       // 2020/02/02
        // exportに使う日付
        $export_date = date('Ymd', strtotime($upload->target_date));

        // データの取得
        $capacity_thermals = CapacityThermalsWest::find(
                        array(
                            "upload_id = $capacity_thermals_latest_upload_id"
                        )
        );

        $capacity_thermals_data_list = [];
        $i = 0;
        foreach ($capacity_thermals as $data) {
            $capacity_thermals_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_thermals_data_list[$i]['coal'] = $data->coal;
            $capacity_thermals_data_list[$i]['lng'] = $data->lng;
            $capacity_thermals_data_list[$i]['oil'] = $data->oil;
            $i++;
        }

        // データの取得
        $capacity_nuclears = CapacityNuclearsWest::find(
                        array(
                            "upload_id = $capacity_nuclears_latest_upload_id"
                        )
        );

        $capacity_nuclears_data_list = [];
        $i = 0;
        foreach ($capacity_nuclears as $data) {
            $capacity_nuclears_data_list[$i]['dt'] = date('Y/m/d', strtotime($data->dt));
            $capacity_nuclears_data_list[$i]['nuclear'] = $data->nuclear;
            $i++;
        }

        // 需要 太陽光 風力
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_W,
                            ),
                        // 'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $demand_forecast = PrerequisitesWest::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $demand_forecast_data_list = [];
        $i = 0;
        foreach ($demand_forecast as $data) {
            $demand_forecast_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:00', strtotime($data->fc_datetime));
            $demand_forecast_data_list[$i]['load'] = $data->load;
            $demand_forecast_data_list[$i]['wind'] = $data->wind;
            $demand_forecast_data_list[$i]['solar'] = $data->solar;
            $demand_forecast_data_list[$i]['geothermal'] = $data->geothermal;
            $demand_forecast_data_list[$i]['biomass'] = $data->biomass;
            $demand_forecast_data_list[$i]['hydro'] = $data->hydro;
            $demand_forecast_data_list[$i]['hydro_pump'] = $data->hydro_pump;
            $demand_forecast_data_list[$i]['reside_load'] = $data->reside_load;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'capacity_thermals_data_list' => $capacity_thermals_data_list,
                    'capacity_nuclears_data_list' => $capacity_nuclears_data_list,
                    'event_data_list_for_thermal' => $event_data_list_for_thermal,
                    'event_data_list_for_nuclear' => $event_data_list_for_nuclear,
                    // 前提条件(需要,電力,太陽光)
                    'demand_forecast_data_list' => $demand_forecast_data_list,
                    'supply_capacity_assumed_date' => $supply_capacity_assumed_date,
                    'supply_capacity_assumed_datee' => $supply_capacity_assumed_datee,
                    'export_date' => $export_date,
                    'filename_area' => '_west',      // 2017/01/02
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_capcity.css')
                // 前提条件(需要,電力,太陽光)
                ->addCss('css/chart_demandandrenewableenergy.css')
        ;

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_capacity_thermals.js')
                ->addJs('js/chart_capacity_nuclears.js')
                // 前提条件(需要,電力,太陽光)
                ->addJs('js/chart_solar.js')
                ->addJs('js/chart_wind.js')
                ->addJs('js/chart_hydro.js')
                ->addJs('js/chart_hydro_pump.js')
                ->addJs('js/chart_capacity_geothermal_power.js')
                ->addJs('js/chart_capacity_biomass.js')
        ;
    }

    // 需要実績
    public function historicaldemandAction() {
        $this->view->en = '/prerequisite/historicaldemande';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $upload_id = HistoricalDemands::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );


        $latest_upload_id = $this->getLatestUploadId($upload_id);

        // データの取得
        $hst_demands = HistoricalDemands::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                            ),
                        )
        );

        $hst_demands_data_list = [];
        $i = 0;
        foreach ($hst_demands as $data) {
            $hst_demands_data_list[$i]['dt'] = date('Y/m/d H:i:00', strtotime($data->dt));
            $hst_demands_data_list[$i]['demand'] = $data->demand;
            $hst_demands_data_list[$i]['east'] = $data->east;
            $hst_demands_data_list[$i]['west'] = $data->west;
            $hst_demands_data_list[$i]['hokkaido'] = $data->hokkaido;       // 2017/02/19
            $hst_demands_data_list[$i]['kyushu'] = $data->kyushu;
            $i++;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'hst_demands_data_list' => $hst_demands_data_list,
                    
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_historicaldemand.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_hst_demands.js');
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                )
        );
    }

    // 連系線潮流
    public function interconnectAction() {
        $this->view->en = '/prerequisite/interconnecte';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_CONNECT']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $interconnect = Interconnect::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)", // 2016/05/28
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );

        $interconnect_data_list = [];
        $i = 0;
        foreach ($interconnect as $data) {
            $interconnect_data_list[$i]['dt'] = date('Y/m/d H:i:00', strtotime($data->dt));
            $interconnect_data_list[$i]['forward'] = $data->forward;
            $interconnect_data_list[$i]['reverse'] = $data->reverse;
            $i++;
        }

        // viewにデータを渡す ----------------------------------------------------------------
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'interconnect_data_list' => $interconnect_data_list,
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_interconnect.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_interconnect.js')
                    ;
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'export_file' => 'FC_',
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']), // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),          // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
    }

    // 2017/02/23 北本
    public function interconnectkitahonAction() {
        $this->view->en = '/prerequisite/interconnectkitahone';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_CONNECT']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT_H,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $interconnect = InterconnectsKitahon::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)", // 2016/05/28
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );

        $interconnect_data_list = [];
        $i = 0;
        foreach ($interconnect as $data) {
            $interconnect_data_list[$i]['dt'] = date('Y/m/d H:i:00', strtotime($data->dt));
            $interconnect_data_list[$i]['forward'] = $data->forward;
            $interconnect_data_list[$i]['reverse'] = $data->reverse;
            $i++;
        }

        // viewにデータを渡す ----------------------------------------------------------------
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'interconnect_data_list' => $interconnect_data_list,
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_interconnect.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_interconnect.js')
                    ;
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'export_file' => 'Kitahon_',
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']), // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
    }

    // 2017/02/23
    public function interconnectkanmonAction() {
        $this->view->en = '/prerequisite/interconnectkanmone';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_CONNECT']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT_K,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        $latest_upload_id = $upload->id;

        // データの取得
        $interconnect = InterconnectsKanmon::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)", // 2016/05/28
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );

        $interconnect_data_list = [];
        $i = 0;
        foreach ($interconnect as $data) {
            $interconnect_data_list[$i]['dt'] = date('Y/m/d H:i:00', strtotime($data->dt));
            $interconnect_data_list[$i]['forward'] = $data->forward;
            $interconnect_data_list[$i]['reverse'] = $data->reverse;
            $i++;
        }

        // viewにデータを渡す ----------------------------------------------------------------
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'interconnect_data_list' => $interconnect_data_list,
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_interconnect.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_interconnect.js')
                    ;
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role'],
                    'export_file' => 'Kanmon_',
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']), // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );
    }

    // 受渡月別価格推移
    public function deliverymonthlyAction() {
        $this->view->en = '/prerequisite/deliverymonthlye';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DELIVERY']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // $this->view->setMainView('index2'); 2017/07/08 // 2016/07/22 

        // idと配信日を取得
        $sStartDate = date('Y-m-d', strtotime('-1 year'));  // 2017/3/31
        $uploads = Uploads::find(
                        array(
                            // "deleted=0 AND upload_type=:type:",
                            // "deleted=0 AND upload_type=:type: AND target_date>='2016-01-29'",   // 2016/07/26
                            "deleted=0 AND upload_type=:type: AND target_date>=:sdate:",   // 2017/03/29
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                'sdate' => $sStartDate,
                            ),
                            'order' => 'target_date',   // 2016/07/22
                        )
        );

        $i = 0;
        foreach ($uploads as $data) {
            $forward_curve[$i]['id'] = $data->id;
            $forward_curve[$i]['target_date'] = date('Y-m-d', strtotime($data->target_date));
            $i++;
        }
//        echo '<pre>';
//        print_r($forward_curve);
//        echo '</pre>';exit;
        $monthlyData = array();
        // インデクス（＝受渡年月）初期設定; 当月から始まる15カ月分の1日日付がインデクス
        // 2017/08/31 毎月末日は来月から始まる15ヶ月分の1日日付
        $thisMonth1 = date('Y/m/1');     // 当月1日
        $nextMonth1 = date('Y/m/d', strtotime('+1 month', strtotime($thisMonth1)));     // 翌月1日
        $thisMonthLast = date('Y/m/d', strtotime('-1 day', strtotime($nextMonth1)));     // 当月末尾
        $startMonth1 = ($thisMonthLast == date('Y/m/d')) ? $nextMonth1 : $thisMonth1;   // 最初のインデクス日付
        // var_dump($nextMonth1);
        // var_dump($thisMonthLast);
        // var_dump($startMonth1);
        for($ofs = 0; $ofs < 15; $ofs++) {
            // $monthlyData[date('Y/m/01', strtotime('+' . $ofs . ' month'))] = array();    2017/08/31
            // $monthlyData[date('Y/m/d', strtotime('+' . $ofs . ' month', strtotime($startMonth1)))] = array();
            $monthlyData[date($this->session->has(self::FLG_LANGOVERRIDE) ? 'M d, Y' : 'Y/m/d', strtotime('+' . $ofs . ' month', strtotime($startMonth1)))] = array();
        }
        // アップロードされている電力フォーワード マンスリーを全部読む
        // $beyondDate = date('Y/m/01', strtotime('+15 month'));      // 2017/07/02
        $beyondDate = date('Y/m/d', strtotime('+15 month', strtotime($startMonth1)));      // 2017/08/31
        foreach ($forward_curve as $value) {
            $upload_id = $value['id'];
            $monthly = ForwardMainMonths::find(
                            array(
                                // 'upload_id=:uploadId: AND :currentDate:<=fc_datetime',
                                'upload_id=:uploadId: AND :currentDate:<=fc_datetime AND fc_datetime<:beyondDate:',
                                'bind' => array(
                                    'uploadId' => $upload_id,
                                    // 'currentDate' => date('Y-m-01'),    // 当月の一日 2017/08/31
                                    'currentDate' => $startMonth1,    // 当月の一日
                                    'beyondDate' => $beyondDate         // 期間の翌日
                                ),
                                'order' => 'fc_datetime',
                                // 'limit' => 15
                            )
            );
            // $i = 0;
            foreach ($monthly as $rec) {
                // $fc_datetime = date('Y/m/01', strtotime($rec->fc_datetime));
                $fc_datetime = date($this->session->has(self::FLG_LANGOVERRIDE) ? 'M 01, Y' : 'Y/m/01', strtotime($rec->fc_datetime));
                if(isset($monthlyData[$fc_datetime])) {
                    $monthlyData[$fc_datetime][] = [
                        'target_date' => $value['target_date'],
                        'price_base' => $rec->price_base,
//                      'price_offpeak' => $rec->price_offpeak,
//                      'price_peak' => $rec->price_peak,
                    ];
                }
                // $i++;
            }
        }
//        
//        echo '<pre>';
//        print_r($monthlyData);
//        echo '</pre>';
//        exit;


        $monthlyJason = json_encode($monthlyData);
//        echo '<pre>';print_r($monthlyJason);
//        echo '</pre>';exit;
        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'delivery_monthly_data_list' => $monthlyJason,
                    
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_historicaldemand.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_delivery_monthly.js');
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
    }

    // 受渡月別価格分布
    public function deliverymonthlydistributionAction() {
        $this->view->en = '/prerequisite/deliverymonthlydistributione';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];     // 2016/10/19
            $auth_bits = $auth['auth_bits'];    // 2018/09/28
        }
        // if ($auth['role'] < 3) {    // PlanB 以上
        if(($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']) == 0)
        {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }
        
        // $this->view->setMainView('index2'); 2017/07/08 // 2016/07/22 

        // プルダウンメニューに表示する年月を取得
        $now_date = date('Y-m'); // 現在の月日
        $now_timestamp = strtotime($now_date); // 現在の月日のタイムスタンプ
        // プルダウンメニューに表示する年月の配列
        $select_date_list = array();
        // 当月から15ヶ月（当月含む）を配列に代入
        // $select_date_list[] = $now_date; // 当月        
        $select_date_list[] = $this->session->has(self::FLG_LANGOVERRIDE) ? date('M Y') : $now_date; // 当月        
        // 14ヶ月
        for ($i = 1; $i <= 14; $i++) {
            // $select_date_list[] = date('Y-m', strtotime("+$i month", $now_timestamp));
            $key = date('Y-m', strtotime("+$i month", $now_timestamp));
            $select_date_list[$key] = $this->session->has(self::FLG_LANGOVERRIDE) ? date('M Y', strtotime("+$i month", $now_timestamp)) : $key;      // 2020/02/12
        }
        // var_dmp($select_date_list);exit(0);

        // グラフに使用する日付(デフォルトは当月)
        $select_date = date('Y-m');
        // POSTされたデータがある場合、その日付をグラフに使用
        $post_data_list = $this->request->getPost();
        // if ($post_data_list['select_date'] != '') {  2018/10/19
        if (!empty($post_data_list['select_date'])) {
            $select_date = $post_data_list['select_date'];
            $selected_select_date = $select_date; // 選択された日付がメニューで選択(selected)されているようにするための日付
        }
        else    // 2018/10/19
        {
            // $select_date = $select_date_list[0];
            $select_date = date('Y-m'); // 2020/02/12
            $selected_select_date = $select_date;
        }

        // グラフのタイトル(受渡月別価格分布)の横に表示する年月
        $select_date_str = date('Y年m月', strtotime($select_date));
        $select_date_stre = date('F, Y', strtotime($select_date));       // 2020/02/02

        $select_date = $select_date . '-01';

        $targetDate = $select_date . ' ' . '00:00:00';
        
        $p_5_6 = 0;
        $p_5_8 = 0;
        $p_6_0 = 0;
        $p_6_2 = 0;
        $p_6_4 = 0;
        $p_6_6 = 0;
        $p_6_8 = 0;
        $p_7_0 = 0;
        $p_7_2 = 0;
        $p_7_4 = 0;
        $p_7_6 = 0;
        $p_7_8 = 0;
        $p_8_0 = 0;
        $p_8_2 = 0;
        $p_8_4 = 0;
        $p_8_6 = 0;
        $p_8_8 = 0;
        $p_9_0 = 0;
        $p_9_2 = 0;
        $p_9_4 = 0;
        $p_9_6 = 0;
        $p_9_8 = 0;
        $p_10_0 = 0;
        $p_10_2 = 0;
        $p_10_4 = 0;
        $p_10_6 = 0;
        $p_10_8 = 0;
        $p_11_0 = 0;
        $p_11_2 = 0;
        $p_11_4 = 0;
        $p_11_6 = 0;
        $p_11_8 = 0;
        $p_12_0 = 0;
        $p_12_2 = 0;
        $p_12_4 = 0;
        $p_12_6 = 0;
        $p_12_8 = 0;
        $p_13_0 = 0;
        $p_13_2 = 0;
        $p_13_4 = 0;
        $p_13_6 = 0;
        $p_13_8 = 0;
        $p_14_0 = 0;
        $p_14_2 = 0;
        $p_14_4 = 0;

        // idと配信日を取得 2016/07/26
        $sStartDate = date('Y-m-d', strtotime('-1 year'));  // 2017/3/31
        $uploads = Uploads::find(
                        array(
                            // "deleted=0 AND upload_type=:type: AND target_date>='2016-01-29'",
                            "deleted=0 AND upload_type=:type: AND target_date>=:sdate:",        // 2017/3/31
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                                'sdate' => $sStartDate,
                            ),
                            'order' => 'target_date',   // 2016/07/22
                        )
        );
        // var_dump(count($uploads));exit(0);
        foreach($uploads as $upload) {
            $upload_id = $upload->id;
            
            $monthly = ForwardMainMonths::findFirst(
                            array(
                                'upload_id=:uploadId: AND fc_datetime=:targetDate:',
                                'bind' => array(
                                    'targetDate' => $targetDate,
                                    'uploadId' => $upload_id,
                                ),
                                // 'order' => 'fc_datetime'
                            )
            );
            if(empty($monthly)) {
                continue;
            }
            
            $price_base = round($monthly->price_base, 1);
            if (5.4 < $price_base && $price_base <= 5.6) {
                $p_5_6++;
            }
            if (5.6 < $price_base && $price_base <= 5.8) {
                $p_5_8++;
            }
            if (5.8 < $price_base && $price_base <= 6.0) {
                $p_6_0++;
            }
            if (6.0 < $price_base && $price_base <= 6.2) {
                $p_6_2++;
            }
            if (6.2 < $price_base && $price_base <= 6.4) {
                $p_6_4++;
            }
            if (6.4 < $price_base && $price_base <= 6.6) {
                $p_6_6++;
            }
            if (6.6 < $price_base && $price_base <= 6.8) {
                $p_6_8++;
            }
            if (6.8 < $price_base && $price_base <= 7.0) {
                $p_7_0++;
            }
            if (7.0 < $price_base && $price_base <= 7.2) {
                $p_7_2++;
            }
            if (7.2 < $price_base && $price_base <= 7.4) {
                $p_7_4++;
            }
            if (7.4 < $price_base && $price_base <= 7.6) {
                $p_7_6++;
            }
            if (7.6 < $price_base && $price_base <= 7.8) {
                $p_7_8++;
            }
            if (7.8 < $price_base && $price_base <= 8.0) {
                $p_8_0++;
            }
            if (8.0 < $price_base && $price_base <= 8.2) {
                $p_8_2++;
            }
            if (8.2 < $price_base && $price_base <= 8.4) {
                $p_8_4++;
            }
            if (8.4 < $price_base && $price_base <= 8.6) {
                $p_8_6++;
            }
            if (8.6 < $price_base && $price_base <= 8.8) {
                $p_8_8++;
            }
            if (8.8 < $price_base && $price_base <= 9.0) {
                $p_9_0++;
            }
            if (9.0 < $price_base && $price_base <= 9.2) {
                $p_9_2++;
            }
            if (9.2 < $price_base && $price_base <= 9.4) {
                $p_9_4++;
            }
            if (9.4 < $price_base && $price_base <= 9.6) {
                $p_9_6++;
            }
            if (9.6 < $price_base && $price_base <= 9.8) {
                $p_9_8++;
            }
            if (9.8 < $price_base && $price_base <= 10.0) {
                $p_10_0++;
            }
            if (10.0 < $price_base && $price_base <= 10.2) {
                $p_10_2++;
            }
            if (10.2 < $price_base && $price_base <= 10.4) {
                $p_10_4++;
            }
            if (10.4 < $price_base && $price_base <= 10.6) {
                $p_10_6++;
            }
            if (10.6 < $price_base && $price_base <= 10.8) {
                $p_10_8++;
            }
            if (10.8 < $price_base && $price_base <= 11.0) {
                $p_11_0++;
            }
            if (11.0 < $price_base && $price_base <= 11.2) {
                $p_11_2++;
            }
            if (11.2 < $price_base && $price_base <= 11.4) {
                $p_11_4++;
            }
            if (11.4 < $price_base && $price_base <= 11.6) {
                $p_11_6++;
            }
            if (11.6 < $price_base && $price_base <= 11.8) {
                $p_11_8++;
            }
            if (11.8 < $price_base && $price_base <= 12.0) {
                $p_12_0++;
            }
            if (12.0 < $price_base && $price_base <= 12.2) {
                $p_12_2++;
            }
            if (12.2 < $price_base && $price_base <= 12.4) {
                $p_12_4++;
            }
            if (12.4 < $price_base && $price_base <= 12.6) {
                $p_12_6++;
            }
            if (12.6 < $price_base && $price_base <= 12.8) {
                $p_12_8++;
            }
            if (12.8 < $price_base && $price_base <= 13.0) {
                $p_13_0++;
            }
            if (13.0 < $price_base && $price_base <= 13.2) {
                $p_13_2++;
            }
            if (13.2 < $price_base && $price_base <= 13.4) {
                $p_13_4++;
            }
            if (13.4 < $price_base && $price_base <= 13.6) {
                $p_13_6++;
            }
            if (13.6 < $price_base && $price_base <= 13.8) {
                $p_13_8++;
            }
            if (13.8 < $price_base && $price_base <= 14.0) {
                $p_14_0++;
            }
            if (14.0 < $price_base && $price_base <= 14.2) {
                $p_14_2++;
            }
            if (14.2 < $price_base && $price_base <= 14.4) {
                $p_14_4++;
            }
        }
        
        $delivery_monthly = array();
        $delivery_monthly[0]["country"] = "5.6";
        $delivery_monthly[0]["visits"] = $p_5_6;
        $delivery_monthly[1]["country"] = "5.8";
        $delivery_monthly[1]["visits"] = $p_5_8;
        $delivery_monthly[2]["country"] = "6.0";
        $delivery_monthly[2]["visits"] = $p_6_0;
        $delivery_monthly[3]["country"] = "6.2";
        $delivery_monthly[3]["visits"] = $p_6_2;
        $delivery_monthly[4]["country"] = "6.4";
        $delivery_monthly[4]["visits"] = $p_6_4;
        $delivery_monthly[5]["country"] = "6.6";
        $delivery_monthly[5]["visits"] = $p_6_6;
        $delivery_monthly[6]["country"] = "6.8";
        $delivery_monthly[6]["visits"] = $p_6_8;
        $delivery_monthly[7]["country"] = "7.0";
        $delivery_monthly[7]["visits"] = $p_7_0;
        $delivery_monthly[8]["country"] = "7.2";
        $delivery_monthly[8]["visits"] = $p_7_2;
        $delivery_monthly[9]["country"] = "7.4";
        $delivery_monthly[9]["visits"] = $p_7_4;
        $delivery_monthly[10]["country"] = "7.6";
        $delivery_monthly[10]["visits"] = $p_7_6;
        $delivery_monthly[11]["country"] = "7.8";
        $delivery_monthly[11]["visits"] = $p_7_8;
        $delivery_monthly[12]["country"] = "8.0";
        $delivery_monthly[12]["visits"] = $p_8_0;
        $delivery_monthly[13]["country"] = "8.2";
        $delivery_monthly[13]["visits"] = $p_8_2;
        $delivery_monthly[14]["country"] = "8.4";
        $delivery_monthly[14]["visits"] = $p_8_4;
        $delivery_monthly[15]["country"] = "8.6";
        $delivery_monthly[15]["visits"] = $p_8_6;
        $delivery_monthly[16]["country"] = "8.8";
        $delivery_monthly[16]["visits"] = $p_8_8;
        $delivery_monthly[17]["country"] = "9.0";
        $delivery_monthly[17]["visits"] = $p_9_0;
        $delivery_monthly[18]["country"] = "9.2";
        $delivery_monthly[18]["visits"] = $p_9_2;
        $delivery_monthly[19]["country"] = "9.4";
        $delivery_monthly[19]["visits"] = $p_9_4;
        $delivery_monthly[20]["country"] = "9.6";
        $delivery_monthly[20]["visits"] = $p_9_6;
        $delivery_monthly[21]["country"] = "9.8";
        $delivery_monthly[21]["visits"] = $p_9_8;
        $delivery_monthly[22]["country"] = "10.0";
        $delivery_monthly[22]["visits"] = $p_10_0;
        $delivery_monthly[23]["country"] = "10.2";
        $delivery_monthly[23]["visits"] = $p_10_2;
        $delivery_monthly[24]["country"] = "10.4";
        $delivery_monthly[24]["visits"] = $p_10_4;
        $delivery_monthly[25]["country"] = "10.6";
        $delivery_monthly[25]["visits"] = $p_10_6;
        $delivery_monthly[26]["country"] = "10.8";
        $delivery_monthly[26]["visits"] = $p_10_8;
        $delivery_monthly[27]["country"] = "10.8";
        $delivery_monthly[27]["visits"] = $p_10_8;
        $delivery_monthly[28]["country"] = "11.0";
        $delivery_monthly[28]["visits"] = $p_11_0;
        $delivery_monthly[29]["country"] = "11.2";
        $delivery_monthly[29]["visits"] = $p_11_2;
        $delivery_monthly[30]["country"] = "11.4";
        $delivery_monthly[30]["visits"] = $p_11_4;
        $delivery_monthly[31]["country"] = "11.6";
        $delivery_monthly[31]["visits"] = $p_11_6;
        $delivery_monthly[32]["country"] = "11.8";
        $delivery_monthly[32]["visits"] = $p_11_8;
        $delivery_monthly[33]["country"] = "12.0";
        $delivery_monthly[33]["visits"] = $p_12_0;
        $delivery_monthly[34]["country"] = "12.2";
        $delivery_monthly[34]["visits"] = $p_12_2;
        $delivery_monthly[35]["country"] = "12.4";
        $delivery_monthly[35]["visits"] = $p_12_4;
        $delivery_monthly[36]["country"] = "12.6";
        $delivery_monthly[36]["visits"] = $p_12_6;
        $delivery_monthly[37]["country"] = "12.8";
        $delivery_monthly[37]["visits"] = $p_12_8;
        $delivery_monthly[38]["country"] = "13.0";
        $delivery_monthly[38]["visits"] = $p_13_0;
        $delivery_monthly[39]["country"] = "13.2";
        $delivery_monthly[39]["visits"] = $p_13_2;
        $delivery_monthly[40]["country"] = "13.4";
        $delivery_monthly[40]["visits"] = $p_13_4;
        $delivery_monthly[41]["country"] = "13.6";
        $delivery_monthly[41]["visits"] = $p_13_6;
        $delivery_monthly[42]["country"] = "13.8";
        $delivery_monthly[42]["visits"] = $p_13_8;
        $delivery_monthly[43]["country"] = "14.0";
        $delivery_monthly[43]["visits"] = $p_14_0;
        $delivery_monthly[44]["country"] = "14.2";
        $delivery_monthly[44]["visits"] = $p_14_2;

        $monthlyJason = json_encode($delivery_monthly);

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'delivery_monthly_data_list' => $monthlyJason,
                    'select_date_list' => $select_date_list, // プルダウンメニューに使用する日付リスト
                    'selected_select_date' => $selected_select_date, // 選択された日付がメニューで選択(selected)されているようにするための日付
                    'select_date_str' => $select_date_str, // グラフのタイトル(受渡月別価格分布)の横に表示する年月
                    'select_date_stre' => $select_date_stre, // グラフのタイトル(受渡月別価格分布)の横に表示する年月
                    
                    'enable_fuel_exchange_menu' => ($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']),  // 2018/10/06
                    'enable_fuel_menu' => ($auth_bits & $this->authority['PRE_FUEL']),
                    'enable_fuel_cif_menu' => ($auth_bits & $this->authority['PRE_FUEL_CIF']),      // 2019/02/08
                    'enable_demand_menu' => ($auth_bits & ($this->authority['PRE_DEMAND'] | $this->authority['PRE_DEMAND_ALL'])),
                    'enable_capacity_menu' => ($auth_bits & ($this->authority['PRE_CAPACITY'] | $this->authority['PRE_CAPACITY_ALL'])),
                    'enable_capacity_all_menu' => ($auth_bits & $this->authority['PRE_CAPACITY_ALL']),
                    'enable_capacity_hydro_menu' => ($auth_bits & $this->authority['PRE_CAPACITY']),
                    'enable_connect_menu' => ($auth_bits & $this->authority['PRE_CONNECT']),
                    'enable_jepx_menu' => ($auth_bits & $this->authority['PRE_JEPX']),
                    'enable_historical_demand_menu' => ($auth_bits & $this->authority['PRE_HISTORICAL_DEMAND']),
                    'enable_delivery_menu' => ($auth_bits & $this->authority['PRE_DELIVERY']),
                    'enable_delivery_distribution_menu' => ($auth_bits & $this->authority['PRE_DELIVERY_DISTRIBUTION']),
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_historicaldemand.css');

        // JavaScriptのローカルリソースを追加します
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_delivery_monthly_distribution.js');
        }

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
    }

    // 原子力供給
    public function nuclearsupplyAction() {
        $this->view->en = '/prerequisite/nuclearsupplye';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if ($auth['role'] < 9) {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
//                    'delivery_monthly_data_list' => $monthlyJason,
//                    'select_date_list' => $select_date_list, // プルダウンメニューに使用する日付リスト
//                    'selected_select_date' => $selected_select_date, // 選択された日付がメニューで選択(selected)されているようにするための日付
//                    'select_date_str' => $select_date_str // グラフのタイトル(受渡月別価格分布)の横に表示する年月
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_historicaldemand.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_nuclear_supply.js');

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
    }

    // JEPXスポット短期予想
    public function shortjepxAction() {
        $this->view->en = '/prerequisite/shortjepxe';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');

        $auth = $this->session->get('auth'); // 2016/03/31
        if ($auth['role'] < 9) {
            // return $this->response->redirect("/");
            return $this->response->redirect(($this->isOvr()) ? '/index/e' : '/');  // 2020/03/01
        }

        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                        )
        );
        $upload_id = $upload->id;

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

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'short_data_list' => $short_data_list
                )
        );

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_historicaldemand.css');

        // JavaScriptのローカルリソースを追加します
        $this->assets
                ->addJs('js/chart_short_jepx.js');

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
    }

    // 2020/01/31
    public function  enAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->indexAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
            // ヒストリカルデータ(スポット,スポット全履歴,JEPXインデックス,原油先物,石炭先物,為替)
            ->addJs('js/chart_spot_alle.js')
            ->addJs('js/chart_indexe.js');
}
    
    public function  fuelandexchangeeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->fuelandexchangeAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/fuelandexchange';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->subs_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'Settlement_Price (円/$)':'Settlement_Price (JPY/$)','ダウンロード':'Download'}";
        $this->assets
                // ->addJs('js/chart_hst_oile.js')  2022/03/17 202203-02
                // ->addJs('js/chart_hst_coale.js')
                ->addJs('js/chart_hst_exchangee.js');
    }
    
    public function  demandandrenewableenergyeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->demandandrenewableenergyAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/demandandrenewableenergy';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_demand_forecaste.js')
                ->addJs('js/chart_residual_loade.js')
        ;
   }
    
    public function  demandandrenewableenergyeasteAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->demandandrenewableenergyeastAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/demandandrenewableenergyeast';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_demand_forecaste.js')
                ->addJs('js/chart_residual_loade.js')
        ;
    }
    
    public function  demandandrenewableenergywesteAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->demandandrenewableenergywestAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/demandandrenewableenergywest';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_demand_forecaste.js')
                ->addJs('js/chart_residual_loade.js')
        ;
    }
    
    public function  demandandrenewableenergyheAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->demandandrenewableenergyhAction();
        $this->view->setMainView('indexe');        
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->ja = '/prerequisite/demandandrenewableenergyh';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_demand_forecaste.js')
                ->addJs('js/chart_residual_loade.js')
        ;
    }
    
    public function  demandandrenewableenergykeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->demandandrenewableenergykAction();
        $this->view->setMainView('indexe');        
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->ja = '/prerequisite/demandandrenewableenergyk';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_demand_forecaste.js')
                ->addJs('js/chart_residual_loade.js')
        ;
    }
    
    public function  fueleAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->fuelAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/fuel';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->dict = "{'Price (千円/MWh)':'Price (1,000JPY/MWh)','ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_sub_oile.js')
                ->addJs('js/chart_sub_lnge.js')
                ->addJs('js/chart_sub_lng_adde.js')
                ->addJs('js/chart_sub_coale.js')
                ;
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $this->assets
                    ->addJs('js/chart_sub_oil_adde.js')     // 2022/07/11
                    ->addJs('js/chart_sub_coal_adde.js')    // 2022/07/11
                    ;
        }
    }
    
    public function  fuelcifeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->fuelcifAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/fuelcif';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->dict = "{'Price (円/t)':'Price (JPY/t)','Price (円/kl)':'Price (JPY/kl)', 'ダウンロード':'Download'}";
        $this->assets
                ->addJs('js/chart_fuelcif_oile.js')
                ->addJs('js/chart_fuelcif_lnge.js')
                ->addJs('js/chart_fuelcif_lng_adde.js')  // 2022/03/17 202203-03
                ->addJs('js/chart_fuelcif_coale.js')
                ;
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $this->assets
                ->addJs('js/chart_fuelcif_oil_adde.js')     // 2022/07/11
                ->addJs('js/chart_fuelcif_coal_adde.js')
                ;
        }
    }
    
    public function  capacityeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->capacityAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/capacity';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_capacity_thermalse.js')
                ->addJs('js/chart_capacity_nuclearse.js')
                ->addJs('js/chart_solare.js')
                ->addJs('js/chart_winde.js')
                ->addJs('js/chart_hydroe.js')
                ->addJs('js/chart_hydro_pumpe.js')
                ->addJs('js/chart_capacity_geothermal_powere.js')
                ->addJs('js/chart_capacity_biomasse.js')
        ;
    }
    
    public function  capacityeasteAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->capacityeastAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/capacityeast';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_capacity_thermalse.js')
                ->addJs('js/chart_capacity_nuclearse.js')
                ->addJs('js/chart_solare.js')
                ->addJs('js/chart_winde.js')
                ->addJs('js/chart_hydroe.js')
                ->addJs('js/chart_hydro_pumpe.js')
                ->addJs('js/chart_capacity_geothermal_powere.js')
                ->addJs('js/chart_capacity_biomasse.js')
                ;
    }
    
    public function  capacitywesteAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->capacitywestAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/capacitywest';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_capacity_thermalse.js')
                ->addJs('js/chart_capacity_nuclearse.js')
                ->addJs('js/chart_solare.js')
                ->addJs('js/chart_winde.js')
                ->addJs('js/chart_hydroe.js')
                ->addJs('js/chart_hydro_pumpe.js')
                ->addJs('js/chart_capacity_geothermal_powere.js')
                ->addJs('js/chart_capacity_biomasse.js')
                ;
    }
    
    public function  capacityhokkaidoeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->capacityhokkaidoAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/capacityhokkaido';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_capacity_thermalse.js')
                ->addJs('js/chart_capacity_nuclearse.js')
                ->addJs('js/chart_solare.js')
                ->addJs('js/chart_winde.js')
                ->addJs('js/chart_hydroe.js')
                ->addJs('js/chart_hydro_pumpe.js')
                ->addJs('js/chart_capacity_geothermal_powere.js')
                ->addJs('js/chart_capacity_biomasse.js')
                ;
    }
    
    public function  capacitykyushueAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->capacitykyushuAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/capacitykyushu';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_capacity_thermalse.js')
                ->addJs('js/chart_capacity_nuclearse.js')
                ->addJs('js/chart_solare.js')
                ->addJs('js/chart_winde.js')
                ->addJs('js/chart_hydroe.js')
                ->addJs('js/chart_hydro_pumpe.js')
                ->addJs('js/chart_capacity_geothermal_powere.js')
                ->addJs('js/chart_capacity_biomasse.js')
                ;
    }
    
    public function  historicaldemandeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->historicaldemandAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/historicaldemand';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_hst_demandse.js');
    }
    
    public function  interconnecteAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->interconnectAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/interconnect';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_interconnecte.js')
                ;
    }
    
    public function  interconnectkitahoneAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->interconnectkitahonAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/interconnectkitahon';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_interconnecte.js')
                ;
    }
    
    public function  interconnectkanmoneAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->interconnectkanmonAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/interconnectkanmon';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
                ->addJs('js/chart_interconnecte.js')
                ;
    }
    
    public function  deliverymonthlyeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->deliverymonthlyAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/deliverymonthly';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
               ->addJs('js/chart_delivery_monthlye.js');
   }
    
    public function  deliverymonthlydistributioneAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->deliverymonthlydistributionAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/deliverymonthlydistribution';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->assets
               ->addJs('js/chart_delivery_monthly_distributione.js');
    }
    
    public function  nuclearsupplyeAction()
    {
        $this->nuclearsupplyAction();
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/nuclearsupply';   // 日本語ページへのリンク
    }
    
    public function  shortjepxeAction()
    {
        $this->shortjepxAction();
        $this->view->setMainView('indexe');        
        $this->view->ja = '/prerequisite/shortjepx';   // 日本語ページへのリンク
    }
}
