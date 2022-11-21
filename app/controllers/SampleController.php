<?php

class SampleController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->setMainView('sample'); // 2016/05/10

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: indexAction()', array());
        
        // サンプルデータの upload_id は、システム設定テーブルを参照 2015/12/17
        $latest_upload_id = $this->sysSetting['SAMPLE_UPLOAD_ID'][0];
        $upload = Uploads::findFirst($latest_upload_id);
        
        $daily_upload_date = date('Y年m月d日', strtotime($upload->target_date));
        $half_hourly_upload_date = $daily_upload_date;
        $monthly_upload_date = $daily_upload_date;

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: determine upload id', array());
        
        // データの取得
        // half_hourlyのデータ --------------------------------
        $hHourly = GraphData::findFirst(
                        array(
                            '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
                            'bind' => array(
                                'graph_type' => UploadController::GRAPH_FORWARD_POWER_HHOUR,
                                'upload_id' => $latest_upload_id,
                            )
                        )
        );

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: read half hourly data', array());
        
        $hHourlyJason = $hHourly->graph_data;

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: load half hourly data', array());
        
        $daily = ForwardMainDays::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        $dailyData = array();
        foreach($daily as $rec) {
            $dailyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price' => $rec->price,
            );
        }
        $dailyJason = json_encode($dailyData);

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: load daily data', array());
        
        $monthly = ForwardMainMonths::find(
                        array(
                            '(upload_id=:uploadId:)',
                            'bind' => array(
                                'uploadId' => $latest_upload_id,
                            ),
                            'order' => 'fc_datetime',
                        )
        );
        $monthlyData = array();
        foreach($monthly as $rec) {
            $monthlyData[] = array(
                'fc_datetime' => date('Y/m/d', strtotime($rec->fc_datetime)),
                'price_base' => $rec->price_base,
                'price_offpeak' => $rec->price_offpeak,
                'price_peak' => $rec->price_peak,
            );
        }
        $monthlyJason = json_encode($monthlyData);

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: load monthly data', array());
        
        // viewにデータを渡す
        $this->assets->addCss('css/chart_forwardcurve.css');
        $this->assets->addJs('js/chart_common.js')
                ->addJs('js/sample_monthly.js')
                ->addJs('js/sample_daily.js')
                ->addJs('js/sample_half_hourly.js')
                ;
        
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_forwardcurve' => 'active',
                    'half_hourly_sample_data' => $hHourlyJason,
                    'half_hourly_upload_date' => $half_hourly_upload_date,
                    'daily_sample_data' => $dailyJason,
                    'daily_upload_date' => $daily_upload_date,
                    'monthly_sample_data' => $monthlyJason,
                    'monthly_upload_date' => $monthly_upload_date,
                    'day' => "3年間"
                )
        );
        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, 'Sample: end indexAction()', array());
    }

}
