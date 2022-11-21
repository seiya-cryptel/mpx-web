<?php

class HistoricaldataController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    /*
    // 管理IDや利用者IDを覚えておくためのセッション変数名です。
    const SV_THISID = 'SessionsControllerConfSID';  // 重複ログイン管理用セッションID
    const SV_CONFID = 'SessionsControllerConfUID';  // 重複ログインが検出された利用者ID

    // コンストラクタ

    public function onConstruct()
    {
        // 現在のセッションとDBのsessionがちがった場合
        // ログイン画面に戻す
        $auth = $this->session->get('auth');
        $session = Session::findFirst(
                        array(
                            'user_id=:user_id:',
                            'bind' => array(
                                'user_id' => $auth['user_id'],
                            )
                        )
        );

        // 現在のsession
        $my_session_id = $this->session->getId();
        // DBのsession
        $db_session_id = $session->id;

        if ($my_session_id != $db_session_id) {
            $auth = $this->session->get('auth');
            if ($auth) {
                $userId = $auth['user_id'];
                $session = Session::findFirst(
                                array(
                                    'user_id=:user_id:',
                                    'bind' => array(
                                        'user_id' => $userId,
                                    )
                                )
                );
                if ($session) {
                    $session->delete();
                }
                $this->session->remove('auth');
                $this->session->remove(self::SV_THISID);
            }

            // ログイン後画面へ
            $this->flash->error('セッションの有効期限が切れました。お手数ですが再度ログインしてください。');
            return $this->response->redirect('/');
        }
    }
     * 
     */

    /**
     * 時間の時分秒を取り除く YYYY-MM-DD H:i:sからH:i:sを取り除く
     * @param string $date_str YYYY-MM-DD H:i:s
     * @return string $yyyy_mm_dd YYYY-MM-DD
     */
    public function removeDataHis($date_str)
    {
        $date_list = explode(' ', $date_str);
        $yyyy_mm_dd = $date_list[0];
        return $yyyy_mm_dd;
    }

    /**
     * 時間の秒を取り除く h:i:sのsを取り除く
     * @param string $date_str YYYY-MM-DD H:i:s
     * @return string $yyyy_mm_dd_h_i YYYY-MM-DD H:i
     */
    public function removeDateSeconds($date_str)
    {
        $date_list = explode(' ', $date_str);
        $yyyy_mm_dd = $date_list[0];
        $hh_mm = rtrim($date_list[1], "0");
        $hh_mm = rtrim($hh_mm, ":");
        $yyyy_mm_dd_h_i = $yyyy_mm_dd . ' ' . $hh_mm;
        return $yyyy_mm_dd_h_i;
    }

    /**
     * 最新のupload_idを取得
     * @param int $upload_id
     * @param int $latest_upload_id
     */
    public function getLatestUploadId($upload_id)
    {
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
    private function formatUploadDate($latest_upload_id)
    {
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

    public function indexAction()
    {
        // POSTされたデータ取得
        $post_data_list = $this->request->getPost();

        // 2015/12/25 SN
        if ($this->request->isPost()) {
            $strDisplayDate = date('Y-m-d', strtotime($post_data_list['day']));
        }
        else {
            $strDisplayDate = HistoricalMainSpots::maximum(
                    array(
                        'column' => 'hst_datetime',
                        )
            );
            $strDisplayDate = date('Y-m-d', strtotime($strDisplayDate));
        }
        $strDisplayDateUntil = date('Y-m-d', strtotime('+1 day', strtotime($strDisplayDate)));
        // dailyの配信日(アップロードされた日)
        $spot_upload_date = date('Y年m月d日', strtotime($strDisplayDate));
        
        // データの取得
        $spot = HistoricalMainSpots::find(
                array(
                        'hst_datetime>=:date1: AND hst_datetime<:date2:',
                        'bind' => array(
                            'date1' => $strDisplayDate,
                            'date2' => $strDisplayDateUntil,
                        ),
                    )
        );

        /*        
        // DBのヒストリカルデータ(spot)を取得
        if (0 < count($post_data_list)) {
            
            // ヒストリカルデータ
            $upload_id = HistoricalMainSpots::find(
                            array(
                                "limit" => 1,
                                "group" => "upload_id",
                                "order" => "id DESC"
                            )
            );
            $latest_upload_id = $this->getLatestUploadId($upload_id);
            // dailyの配信日(アップロードされた日)
            $spot_upload_date = $this->formatUploadDate($latest_upload_id);

            // データの取得
            $spot = HistoricalMainSpots::find(
                            array(
                                "hst_datetime" . " LIKE '%" . $post_data_list['day'] . "%'",
                                "upload_id = $latest_upload_id",
                                
                            )
            );


        } else {
            // ヒストリカルデータ
            $upload_id = HistoricalMainSpots::find(
                            array(
                                "limit" => 1,
                                "group" => "upload_id",
                                "order" => "id DESC"
                            )
            );
            $latest_upload_id = $this->getLatestUploadId($upload_id);
            // dailyの配信日(アップロードされた日)
            $spot_upload_date = $this->formatUploadDate($latest_upload_id);

            // データの取得
            $spot = HistoricalMainSpots::find(
                            array(
                                "upload_id = $latest_upload_id"
                            )
            );
        }
         * 
         */

        $spot_data_list = [];
        $i = 0;
        foreach ($spot as $data) {
            // 年月日
            $spot_data_list[$i]['hst_datetime'] = $this->removeDateSeconds($data->hst_datetime);
            // 売り入札量(kWh)
            $spot_data_list[$i]['sale'] = $data->sale;
            // 買い入札量(kWh)
            $spot_data_list[$i]['buy'] = $data->buy;
            // 約定総量(kWh)
            $spot_data_list[$i]['contract'] = $data->contract;
            // システムプライス(円/kWh)
            $spot_data_list[$i]['price_system'] = $data->price_system;
            // エリアプライス北海道(円/kWh)
            $spot_data_list[$i]['price_area_01'] = $data->price_area_01;
            // エリアプライス東北(円/kWh)
            $spot_data_list[$i]['price_area_02'] = $data->price_area_02;
            // エリアプライス東京(円/kWh)
            $spot_data_list[$i]['price_area_03'] = $data->price_area_03;
            // エリアプライス中部(円/kWh)
            $spot_data_list[$i]['price_area_04'] = $data->price_area_04;
            // エリアプライス北陸(円/kWh)
            $spot_data_list[$i]['price_area_05'] = $data->price_area_05;
            // エリアプライス関西(円/kWh)
            $spot_data_list[$i]['price_area_06'] = $data->price_area_06;
            // エリアプライス中国(円/kWh)
            $spot_data_list[$i]['price_area_07'] = $data->price_area_07;
            // エリアプライス四国(円/kWh)
            $spot_data_list[$i]['price_area_08'] = $data->price_area_08;
            // エリアプライス九州(円/kWh)
            $spot_data_list[$i]['price_area_09'] = $data->price_area_09;
            $i++;
        }

        // 全履歴
        /*
        $upload_id = HistoricalMainSpots::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );
        $latest_upload_id = $this->getLatestUploadId($upload_id);
        // dailyの配信日(アップロードされた日)
        $spot_upload_date = $this->formatUploadDate($latest_upload_id);

        // データの取得
        $spot_all = HistoricalMainSpots::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
         * 
         */
        $spot_all = HistoricalMainSpots::find();
        
        $spot_all_data_list = [];
        $i = 0;
        foreach ($spot_all as $data) {
            // 年月日
            $spot_all_data_list[$i]['hst_datetime'] = $this->removeDateSeconds($data->hst_datetime);
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
            $i++;
        }

        // JEPXインデックス
        $upload_id = HistoricalMainIndexes::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );
        $latest_upload_id = $this->getLatestUploadId($upload_id);
        // dailyの配信日(アップロードされた日)
        $index_upload_date = $this->formatUploadDate($latest_upload_id);

        // データの取得
        $index = HistoricalMainIndexes::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $index_data_list = [];
        $i = 0;
        foreach ($index as $data) {
            // 年月日
            $index_data_list[$i]['hst_datetime'] = $this->removeDataHis($data->hst_datetime);
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

        // 原油先物 石炭先物 為替
        $upload_id = HistoricalSubs::find(
                        array(
                            "limit" => 1,
                            "group" => "upload_id",
                            "order" => "id DESC"
                        )
        );
        $latest_upload_id = $this->getLatestUploadId($upload_id);
        // dailyの配信日(アップロードされた日)
        $subs_upload_date = $this->formatUploadDate($latest_upload_id);
        // データの取得
        $subs = HistoricalSubs::find(
                        array(
                            "upload_id = $latest_upload_id"
                        )
        );
        $subs_data_list = [];
        $i = 0;
        foreach ($subs as $data) {
            // 年月日
            $subs_data_list[$i]['hst_datetime'] = $this->removeDataHis($data->hst_datetime);
            // 石炭先物
            $subs_data_list[$i]['coal'] = $data->coal;
            // 原油先物
            $subs_data_list[$i]['oil'] = $data->oil;
            // 為替
            $subs_data_list[$i]['exchange'] = $data->exchange;
            $i++;
        }



        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_historicaldata' => 'active',
                    'day' => '全履歴',
                    'spot_data_list' => $spot_data_list,
                    'spot_upload_date' => $spot_upload_date,
                    'spot_all_data_list' => $spot_all_data_list,
                    'index_data_list' => $index_data_list,
                    'index_upload_date' => $spot_upload_date,
                    // 石炭先物 原油先物 為替
                    'subs_data_list' => $subs_data_list,
                    'subs_upload_date' => $subs_upload_date
                )
        );
        // 権限の設定
        $auth = $this->session->get('auth');

        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );
//        if (0 < count($post_data_list)) {
//
//            // SELECTメニューから日付を選択した場合
//            if (array_key_exists('day', $post_data_list)) {
//
//                // viewに渡すデータのdayを選択した日付にする
//                $this->view->setVars(
//                        array(
//                            'day' => $date
//                        )
//                );
//            }
//        }
    }

}
