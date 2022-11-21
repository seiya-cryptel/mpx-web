<?php

class DownloadController extends ControllerBase
{
    // const WORK_DIR = '/usr/share/nginx/data/dlzip/';    // 2018/04/26 2017/07/04    

    public function initialize()
    {
        parent::initialize();
    }

    private function _powerFCMonthly() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainMonths::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                // 'price_base' => $rec->price_base,
                // 'price_offpeak' => $rec->price_offpeak,
                // 'price_peak' => $rec->price_peak,
                'monthly_base' => $rec->price_base,         // 2018/02/27
                'monthly_peak' => $rec->price_offpeak,     // 2018/02/26
                'monthly_daytime' => $rec->price_peak,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_MONTH,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCMonthlyEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainMonthsEast::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                // 'price_base' => $rec->price_base,
                // 'price_offpeak' => $rec->price_offpeak,
                // 'price_peak' => $rec->price_peak,
                'monthly_base' => $rec->price_base,         // 2018/02/27
                'monthly_peak' => $rec->price_offpeak,     // 2018/02/26
                'monthly_daytime' => $rec->price_peak,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_MONTH_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCMonthlyWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainMonthsWest::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                // 'price_base' => $rec->price_base,
                // 'price_offpeak' => $rec->price_offpeak,
                // 'price_peak' => $rec->price_peak,
                'monthly_base' => $rec->price_base,         // 2018/02/27
                'monthly_peak' => $rec->price_offpeak,     // 2018/02/26
                'monthly_daytime' => $rec->price_peak,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_MONTH_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCMonthlyHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainMonthsHokkaido::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                // 'price_base' => $rec->price_base,
                // 'price_offpeak' => $rec->price_offpeak,
                // 'price_peak' => $rec->price_peak,
                'monthly_base' => $rec->price_base,         // 2018/02/27
                'monthly_peak' => $rec->price_offpeak,     // 2018/02/26
                'monthly_daytime' => $rec->price_peak,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_MONTH_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCMonthlyKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainMonthsKyushu::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                // 'price_base' => $rec->price_base,
                // 'price_offpeak' => $rec->price_offpeak,
                // 'price_peak' => $rec->price_peak,
                'monthly_base' => $rec->price_base,         // 2018/02/27
                'monthly_peak' => $rec->price_offpeak,     // 2018/02/26
                'monthly_daytime' => $rec->price_peak,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_MONTH_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCDaily() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainDays::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_DAY,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCDailyEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainDaysEast::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_DAY_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCDailyWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainDaysWest::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_DAY_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCDailyHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainDaysHokkaido::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_DAY_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCDailyKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainDaysKyushu::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_DAY_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCHalfHourly() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHHours::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HHOUR,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCHalfHourlyEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHHoursEast::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HHOUR_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCHalfHourlyWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHHoursWest::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HHOUR_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCHalfHourlyHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHHoursHokkaido::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HHOUR_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _powerFCHalfHourlyKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHHoursKyushu::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HHOUR_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2018/03/11 --------------------------------------------------------------
    private function _powerFCHourly() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHours::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->dt,  // 2018/03/14
                'price' => $rec->pr,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HOUR,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _powerFCHourlyEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_E,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHoursEast::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->dt,  // 2018/03/14
                'price' => $rec->pr,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HOUR_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _powerFCHourlyWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_W,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHoursWest::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->dt,  // 2018/03/14
                'price' => $rec->pr,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HOUR_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _powerFCHourlyHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_H,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHoursHokkaido::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->dt,  // 2018/03/14
                'price' => $rec->pr,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HOUR_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _powerFCHourlyKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDMAIN_K,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardMainHoursKyushu::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->dt,  // 2018/03/14
                'price' => $rec->pr,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_POWER_HOUR_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _fuelFCOil() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubOils::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_OIL,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    // 2022/07/10
    private function _fuelFCOilAdd()
    {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubOilAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_OIL_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _fuelFCCoal() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCoals::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_COAL,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2022/07/10
    private function _fuelFCCoalAdd()
    {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCoalAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_COAL_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _fuelFCLNG() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubLngs::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_LNG,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2022/03/17 202203-05
    private function _fuelFCLNGAdd() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubLngAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_LNG_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    // 2019/02/07 燃料CIF価格想定 原油
    private function _fuelFCCifOil() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifOils::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_OIL,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    // 2022/07/10
    private function _fuelFCCifOilAdd() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifOilAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_OIL_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2019/02/07 燃料CIF価格想定 石炭
    private function _fuelFCCifCoal() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifCoals::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_COAL,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2022/07/10
    private function _fuelFCCifCoalAdd()
    {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifCoalAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_COAL_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2019/02/07 燃料CIF価格想定 LNG
    private function _fuelFCCifLNG() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifLngs::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_LNG,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    // 2022/03/17 202203-05
    private function _fuelFCCifLNGAdd() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FORWARDSUB_CIF,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = ForwardSubCifLngAdds::find(
                        array(
                            "(upload_id = :uploadId:)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => $rec->fc_datetime,
                'price' => $rec->price,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_FUEL_CIF_LNG_ADD,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    private function _CMEOil() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_HISTORICALSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = HistoricalSubs::find(
                        array(
                            "(upload_id = :uploadId:) AND (oil IS NOT NULL)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'hst_datetime' => $rec->hst_datetime,
                'price' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_HISTORY_CME . ' Oil',
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _CMECoal() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_HISTORICALSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = HistoricalSubs::find(
                        array(
                            "(upload_id = :uploadId:) AND (coal IS NOT NULL)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'hst_datetime' => $rec->hst_datetime,
                'price' => $rec->coal,
            );
        }
        return array(
            'model' => UploadController::GRAPH_HISTORY_CME . ' Coal',
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _CMEExchange() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_HISTORICALSUB,
                            ),
                            'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = HistoricalSubs::find(
                        array(
                            "(upload_id = :uploadId:) AND (exchange IS NOT NULL)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            )
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'hst_datetime' => $rec->hst_datetime,
                'price' => $rec->exchange,
            );
        }
        return array(
            'model' => UploadController::GRAPH_HISTORY_CME . ' Exchange',
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _forwardDemand() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = Prerequisites::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'load' => $rec->load,
                'reside load' => $rec->reside_load,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_DEMAND,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _forwardDemandEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_E,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesEast::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'load' => $rec->load,
                'reside load' => $rec->reside_load,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_DEMAND_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _forwardDemandWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_W,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesWest::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'load' => $rec->load,
                'reside load' => $rec->reside_load,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_DEMAND_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _forwardDemandHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesHokkaido::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'load' => $rec->load,
                'reside load' => $rec->reside_load,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_DEMAND_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _forwardDemandKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesKyushu::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'load' => $rec->load,
                'reside load' => $rec->reside_load,
            );
        }
        return array(
            'model' => UploadController::GRAPH_FORWARD_DEMAND_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityThermal() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityThermals::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'coal' => $rec->coal,
                'lng' => $rec->lng,
                'oil' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_THERMAL,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityThermalEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_E,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityThermalsEast::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'coal' => $rec->coal,
                'lng' => $rec->lng,
                'oil' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_THERMAL_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityThermalWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_W,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityThermalsWest::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'coal' => $rec->coal,
                'lng' => $rec->lng,
                'oil' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_THERMAL_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityThermalHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityThermalsHokkaido::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'coal' => $rec->coal,
                'lng' => $rec->lng,
                'oil' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_THERMAL_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityThermalKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityThermalsKyushu::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'coal' => $rec->coal,
                'lng' => $rec->lng,
                'oil' => $rec->oil,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_THERMAL_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityNuclear() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityNuclears::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'nuclear' => $rec->nuclear,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_NUCLEAR,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityNuclearEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_E,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityNuclearsEast::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'nuclear' => $rec->nuclear,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_NUCLEAR_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityNuclearWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_W,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityNuclearsWest::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'nuclear' => $rec->nuclear,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_NUCLEAR_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityNuclearHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityNuclearsHokkaido::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'nuclear' => $rec->nuclear,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_NUCLEAR_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityNuclearKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_CAPACITY_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = CapacityNuclearsKyushu::find(
                        array(
                            "upload_id = $uploadId"
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d', strtotime($rec->dt)),
                'nuclear' => $rec->nuclear,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_NUCLEAR_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityRenewable() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = Prerequisites::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'solar' => $rec->solar,
                'wind' => $rec->wind,
                'geothermal' => $rec->geothermal,
                'biomass' => $rec->biomass,
                'hydro' => $rec->hydro,
                'hydro_pump' => $rec->hydro_pump,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_RENEWABLE,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityRenewableEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_E,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesEast::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'solar' => $rec->solar,
                'wind' => $rec->wind,
                'geothermal' => $rec->geothermal,
                'biomass' => $rec->biomass,
                'hydro' => $rec->hydro,
                'hydro_pump' => $rec->hydro_pump,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_RENEWABLE_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityRenewableWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_W,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesWest::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'solar' => $rec->solar,
                'wind' => $rec->wind,
                'geothermal' => $rec->geothermal,
                'biomass' => $rec->biomass,
                'hydro' => $rec->hydro,
                'hydro_pump' => $rec->hydro_pump,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_RENEWABLE_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityRenewableHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesHokkaido::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'solar' => $rec->solar,
                'wind' => $rec->wind,
                'geothermal' => $rec->geothermal,
                'biomass' => $rec->biomass,
                'hydro' => $rec->hydro,
                'hydro_pump' => $rec->hydro_pump,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_RENEWABLE_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _capacityRenewableKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_PREREQUISITE_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PrerequisitesKyushu::find(
                        array(
                            'upload_id=:uploadId: AND fc_datetime>=:fcDatetime:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'fcDatetime' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'fc_datetime' => date('Y/m/d H:i:00', strtotime($rec->fc_datetime)),
                'solar' => $rec->solar,
                'wind' => $rec->wind,
                'geothermal' => $rec->geothermal,
                'biomass' => $rec->biomass,
                'hydro' => $rec->hydro,
                'hydro_pump' => $rec->hydro_pump,
            );
        }
        return array(
            'model' => UploadController::GRAPH_CAPACITY_RENEWABLE_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _historicalDemand() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_HISTORICALDEMAND,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = HistoricalDemands::find(
                        array(
                            'upload_id=:uploadId:',
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                'demand' => $rec->demand,
                'east' => $rec->east,
                'west' => $rec->west,
            );
        }
        return array(
            'model' => UploadController::GRAPH_HISTORY_DEMAND,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _interconnect() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = Interconnect::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                'forward' => $rec->forward,
                'reverse' => $rec->reverse,
            );
        }
        return array(
            'model' => UploadController::GRAPH_INTERCONNECT,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _interconnectKitahon() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = InterconnectsKitahon::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                'forward' => $rec->forward,
                'reverse' => $rec->reverse,
            );
        }
        return array(
            'model' => UploadController::GRAPH_INTERCONNECT_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _interconnectKanmon() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_INTERCONNECT_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = InterconnectsKanmon::find(
                        array(
                            // "(upload_id=:uploadId:) AND (dt>'1970-01-02')", // 不良データ対策
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        foreach($data as $rec) {
            $resData[] = array(
                'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                'forward' => $rec->forward,
                'reverse' => $rec->reverse,
            );
        }
        return array(
            'model' => UploadController::GRAPH_INTERCONNECT_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _jepxShort() {
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' ', array());
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = JEPXShorts::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                    'spot' => $rec->spot,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_FW_JEPX_SHORT,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _jepxShortEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_E,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = JEPXShortsEast::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                    'spot' => $rec->spot,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_FW_JEPX_SHORT_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _jepxShortWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_W,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = JEPXShortsWest::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                    'spot' => $rec->spot,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_FW_JEPX_SHORT_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _jepxShortHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_H,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = JEPXShortsHokkaido::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                    'spot' => $rec->spot,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_FW_JEPX_SHORT_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _jepxShortKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_JEPX_SHORT_K,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = JEPXShortsKyushu::find(
                        array(
                            "(upload_id=:uploadId:) AND (dt>=:currentDate:)",    // 2016/05/28
                            'bind' => array(
                                'uploadId' => $uploadId,
                                'currentDate' => date('Y-m-d'),
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'dt' => date('Y/m/d H:i:00', strtotime($rec->dt)),
                    'spot' => $rec->spot,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_FW_JEPX_SHORT_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _oneMonthPrice() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PriceDistributions::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>0)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'price' => $rec->price,
                    'w1_24h' => $rec->w1_24h,
                    'w1_0818' => $rec->w1_0818,
                    'w1_0820' => $rec->w1_0820,
                    'w1_0822' => $rec->w1_0822,
                    'w2_24h' => $rec->w2_24h,
                    'w2_0818' => $rec->w2_0818,
                    'w2_0820' => $rec->w2_0820,
                    'w2_0822' => $rec->w2_0822,
                    'w3_24h' => $rec->w3_24h,
                    'w3_0818' => $rec->w3_0818,
                    'w3_0820' => $rec->w3_0820,
                    'w3_0822' => $rec->w3_0822,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_PRICE_DISTRIBUTION,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _oneMonthPriceEast() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PriceDistributionsEast::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>0)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'price' => $rec->price,
                    'w1_24h' => $rec->w1_24h,
                    'w1_0818' => $rec->w1_0818,
                    'w1_0820' => $rec->w1_0820,
                    'w1_0822' => $rec->w1_0822,
                    'w2_24h' => $rec->w2_24h,
                    'w2_0818' => $rec->w2_0818,
                    'w2_0820' => $rec->w2_0820,
                    'w2_0822' => $rec->w2_0822,
                    'w3_24h' => $rec->w3_24h,
                    'w3_0818' => $rec->w3_0818,
                    'w3_0820' => $rec->w3_0820,
                    'w3_0822' => $rec->w3_0822,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_PRICE_DISTRIBUTION_E,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _oneMonthPriceWest() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PriceDistributionsWest::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>0)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'price' => $rec->price,
                    'w1_24h' => $rec->w1_24h,
                    'w1_0818' => $rec->w1_0818,
                    'w1_0820' => $rec->w1_0820,
                    'w1_0822' => $rec->w1_0822,
                    'w2_24h' => $rec->w2_24h,
                    'w2_0818' => $rec->w2_0818,
                    'w2_0820' => $rec->w2_0820,
                    'w2_0822' => $rec->w2_0822,
                    'w3_24h' => $rec->w3_24h,
                    'w3_0818' => $rec->w3_0818,
                    'w3_0820' => $rec->w3_0820,
                    'w3_0822' => $rec->w3_0822,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_PRICE_DISTRIBUTION_W,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _oneMonthPriceHokkaido() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PriceDistributionsHokkaido::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>0)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'price' => $rec->price,
                    'w1_24h' => $rec->w1_24h,
                    'w1_0818' => $rec->w1_0818,
                    'w1_0820' => $rec->w1_0820,
                    'w1_0822' => $rec->w1_0822,
                    'w2_24h' => $rec->w2_24h,
                    'w2_0818' => $rec->w2_0818,
                    'w2_0820' => $rec->w2_0820,
                    'w2_0822' => $rec->w2_0822,
                    'w3_24h' => $rec->w3_24h,
                    'w3_0818' => $rec->w3_0818,
                    'w3_0820' => $rec->w3_0820,
                    'w3_0822' => $rec->w3_0822,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_PRICE_DISTRIBUTION_H,
            'count' => count($resData),
            'data' => $resData,
        );
    }

    private function _oneMonthPriceKyushu() {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                            // 'order' => 'target_date DESC'
                        )
        );
        // 2022/03/17
        if($upload === false)
        {
            return ['data' => [],];
        }
        $uploadId = $upload->id;
        $data = PriceDistributionsKyushu::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>0)",
                            'bind' => array(
                                'uploadId' => $uploadId,
                            ),
                        )
        );
        $resData = array();
        if($data)
        {   // 2018/11/01
            foreach($data as $rec) {
                $resData[] = array(
                    'price' => $rec->price,
                    'w1_24h' => $rec->w1_24h,
                    'w1_0818' => $rec->w1_0818,
                    'w1_0820' => $rec->w1_0820,
                    'w1_0822' => $rec->w1_0822,
                    'w2_24h' => $rec->w2_24h,
                    'w2_0818' => $rec->w2_0818,
                    'w2_0820' => $rec->w2_0820,
                    'w2_0822' => $rec->w2_0822,
                    'w3_24h' => $rec->w3_24h,
                    'w3_0818' => $rec->w3_0818,
                    'w3_0820' => $rec->w3_0820,
                    'w3_0822' => $rec->w3_0822,
                );
            }
        }
        return array(
            'model' => UploadController::GRAPH_PRICE_DISTRIBUTION_K,
            'count' => count($resData),
            'data' => $resData,
        );
    }
    
    // ZIP ダウンロード用 CSV ファイル出力
    private function _save2CSV($psPath, $pData)
    {
        try
        {
            $FH = fopen($psPath, 'w');
            if(count($pData) < 1)
            {
                fclose($FH);
                return;
            }
            // ヘッダー
            $bComma = false;
            foreach($pData[0] as $key => $val)
            {
                if($bComma)
                {
                    fwrite($FH, ',');
                }
                else {
                    $bComma = true;
                }
                fwrite($FH, $key);
            }
            fwrite($FH, "\n");
            // データ
            foreach($pData as $one)
            {
                $bComma = false;
                foreach($one as $key => $val)
                {
                    if($bComma)
                    {
                        fwrite($FH, ',');
                    }
                    else {
                        $bComma = true;
                    }
                    fwrite($FH, $val);
                }
                fwrite($FH, "\n");
            }
        } catch (Exception $ex) {
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_ERROR, __CLASS__ . ' ' . __FUNCTION__ . ' error %s', array($ex->getMessage()));
       }
        finally {
            if(!empty($FH)) fclose($FH);
        }
    }

    // ZIP ファイル作成
    private function _makeZip($psZip, $psSrcDir)
    {
        $zip = new ZipArchive();
        $res = $zip->open($psZip, ZipArchive::CREATE);
        $lstFile = scandir($psSrcDir);
        foreach($lstFile as $sFileName)
        {
            if($sFileName === '.' || $sFileName === '..')   continue;
            if(is_file($psSrcDir . '/' . $sFileName))
            {
                $zip->addFile($psSrcDir . '/' . $sFileName, $sFileName);
            }
        }
        $zip->close();            
    }
    
    // ディレクトリ削除
    private function _deleteDir ( $psDir ) {
        $lstFile = scandir($psDir);
        foreach($lstFile as $sFileName)
        {
            if($sFileName === '.' || $sFileName === '..')   continue;
            if(is_dir($psDir . '/' . $sFileName))
            {
                $this->_deleteDir($psDir . '/' . $sFileName);
            }
            if(is_file($psDir . '/' . $sFileName))
            {
                unlink($psDir . '/' . $sFileName);
            }
        }
        rmdir($psDir);
    }    
    
    public function indexAction()
    {
        $this->view->disable();

        // レスポンスの初期値
        $res = json_encode(array(
            'Res' => 'Error',
            'Detail' => '本ダウンロードExcelツールはサービスを終了しました。「レポート／ツール ＞ データ一括ダウンロード」をご利用下さい。',
        ));

        ob_clean(); // 2018/10/19
       
    // lblResponse:
        $len = strlen($res);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/javascript");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($res);
        $response->send();
    }

    // 2017/05/22 additional data
    public function adAction()
    {
        $this->view->disable();

        // レスポンスの初期値
        $res = json_encode(array(
            'Res' => 'Error',
            'Detail' => 'Unknown error',
        ));

        try {
            if(! $this->request->isPost())
            {   // POST 確認
                throw new Exception('No data posted');
            }
        
            $post = $this->request->getPost();
            if(empty($post['id']) || empty($post['pwd']))
            {   // ID, Password 確認
                throw new Exception('ID and/or Password are missing');
            }

            // 認証       
            $user = Users::findFirst(
                            array(
                                "(isvalid=1) AND (id = :userId:)",
                                'bind' => array(
                                    'userId' => $post['id'],
                                )
                            )
            );
            if (($user == false) || (!$this->security->checkHash($post['pwd'], $user->pwd))) {
                throw new Exception('Valid user is not found');
            }
            $user_type = $user->user_type;

            $data = AdditionalData::find(
                           array(
                               "(isvalid=1)",
                           )
           );
            $resData = array();
            foreach($data as $rec) {
                $resData[] = array(
                    'data_name' => $rec->data_name,
                    'data_value' => $rec->data_value,
                );
            }
       
            $res = json_encode(array(
                'Res' => 'OK',
                'Detail' => 1,
                'Data' => array(
                    'dataset_1' => $resData,
                ),
            ));
        }
        catch (Exception $ex) {
            $res = json_encode(array(
                'Res' => 'Error',
                'Detail' => $ex->getMessage(),
            ));
        }

        ob_clean(); // 2018/10/19
        
    // lblResponse:
        $len = strlen($res);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/javascript");
        $response->setRawHeader("HTTP/1.1 200 OK");
        $response->setContent($res);
        $response->send();
    }
    
    // 2017/07/04 zip download
    public function dlzipAction()
    {
        $this->view->disable();
        
        // 認証確認
        if(! $this->auth)
        {
            exit(0);
        }
        $auth = $this->session->get('auth');
        $user_id = $auth['user_id'];
        $user_type = $auth['role'];
        // $fc_hourly = $auth['fc_hourly'];        // 2018/10/19, 2018/03/11
        $auth_bits = $auth['auth_bits'];    // 2018/10/07
        if($user_type < 1)
        {   // 2018/03/30
            exit(0);
        }
        
        set_time_limit(900);
        
        // 作業ディレクトリ
        $sWorkDir = $user_id . '_'. date('YmdHis');
        // $sWorkPath = self::WORK_DIR . $sWorkDir; 2018/04/26
        $sWorkPath = $this->config->application->uploadDir . 'dlzip/' . $sWorkDir;
        $sZipPath = $sWorkPath . '.zip';
        try
        {
            mkdir($sWorkPath);
            
            // Forward Power Monthly ----------------------------------------------------------------
            if(($auth_bits & $this->authority['FC_SYS_MONTHLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCMonthly();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_MONTH . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [2, 4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCMonthlyEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_MONTH_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [2, 4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCMonthlyWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_MONTH_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [2, 4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCMonthlyHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_MONTH_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [2, 4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_MONTHLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCMonthlyKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_MONTH_K . '.csv', $dat['data']);
            }
            
            // Forward Power Daily ---------------------------------------------
            // if (in_array($user_type, [5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['FC_SYS_DAILY']))    // 2018/10/07
            {
                $dat = $this->_powerFCDaily();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_DAY . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_DAILY']))    // 2018/10/07
            {
                $dat = $this->_powerFCDailyEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_DAY_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_DAILY']))    // 2018/10/07
            {
                $dat = $this->_powerFCDailyWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_DAY_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_DAILY']))    // 2018/10/07
            {
                $dat = $this->_powerFCDailyHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_DAY_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_DAILY']))    // 2018/10/07
            {
                $dat = $this->_powerFCDailyKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_DAY_K . '.csv', $dat['data']);
            }
            
            // Forward Power Half Hourly ----------------------------------------------------------------
            // if (in_array($user_type, [7, 8, 9])) {
            if(($auth_bits & $this->authority['FC_SYS_HALFHOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHalfHourly();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HHOUR . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHalfHourlyEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HHOUR_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHalfHourlyWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HHOUR_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHalfHourlyHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HHOUR_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [8, 9])) {
            if(($auth_bits & $this->authority['FC_5AREA_HALFHOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHalfHourlyKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HHOUR_K . '.csv', $dat['data']);
            }
            // Forward Power Hourly 2018/03/11 ---------------------------------
            // if($user_type > 8 || $fc_hourly) 2018/04/17
            // if($user_type > 8 || $fc_hourly)
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' %s %s ', array($this->authority['FC_SYS_HOURLY'], $auth_bits));
            if(($auth_bits & $this->authority['FC_SYS_HOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHourly();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HOUR . '.csv', $dat['data']);
            }
            // if($user_type > 8 
            // || ($fc_hourly && in_array($user_type, [2, 4, 6, 8])))
            if(($auth_bits & $this->authority['FC_5AREA_HOURLY']))    // 2018/10/07
            {
                $dat = $this->_powerFCHourlyEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HOUR_E . '.csv', $dat['data']);
                $dat = $this->_powerFCHourlyWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HOUR_W . '.csv', $dat['data']);
                $dat = $this->_powerFCHourlyHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HOUR_H . '.csv', $dat['data']);
                $dat = $this->_powerFCHourlyKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_POWER_HOUR_K . '.csv', $dat['data']);
            }
            
            /* >>> 2022/03/18
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']))    // 2018/10/07
            {
                $dat = $this->_CMEOil();
                // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_HISTORY_CME . ' Oil' . '.csv', $dat['data']);
                $this->_save2CSV($sWorkPath . '/' . 'CME Oil' . '.csv', $dat['data']);
            }
             * 
             */
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            // if(($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']))    // 2018/10/07
            // {
            //    $dat = $this->_CMECoal();
            //    // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_HISTORY_CME . ' Coal' . '.csv', $dat['data']);
            //    $this->_save2CSV($sWorkPath . '/' . 'CME Coal' . '.csv', $dat['data']);
            // }
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_FUEL_EXCHANGE']))    // 2018/10/07
            {
                $dat = $this->_CMEExchange();
                // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_HISTORY_CME . ' Exchange' . '.csv', $dat['data']);
                $this->_save2CSV($sWorkPath . '/' . 'CME Exchange' . '.csv', $dat['data']);
            }
            
            // Forard Demand ---------------------------------------------------
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_DEMAND']))    // 2018/10/07
            {
                $dat = $this->_forwardDemand();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_DEMAND . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_DEMAND_ALL']))    // 2018/10/07
            {
                $dat = $this->_forwardDemandEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_DEMAND_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_DEMAND_ALL']))    // 2018/10/07
            {
                $dat = $this->_forwardDemandWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_DEMAND_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_DEMAND_ALL']))    // 2018/10/07
            {
                $dat = $this->_forwardDemandHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_DEMAND_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_DEMAND_ALL']))    // 2018/10/07
            {
                $dat = $this->_forwardDemandKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_DEMAND_K . '.csv', $dat['data']);
            }

            // 2019/02/07 燃料炉前価格想定            
            if(($auth_bits & $this->authority['PRE_FUEL']))    // 2018/10/07
            {
                $dat = $this->_fuelFCOil();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_OIL . '.csv', $dat['data']);
                $dat = $this->_fuelFCCoal();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_COAL . '.csv', $dat['data']);
                $dat = $this->_fuelFCLNG();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_LNG . '.csv', $dat['data']);
                // 2022/03/17 202203-05
                $dat = $this->_fuelFCLNGAdd();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_LNG_ADD . '.csv', $dat['data']);
                // 2022/07/10
                // if(!empty($this->config->application->show202207) && $this->config->application->show202207)
                if($this->session->get(self::SV_SHOW202207))
                {
                    $dat = $this->_fuelFCOilAdd();
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_OIL_ADD . '.csv', $dat['data']);
                    $dat = $this->_fuelFCCoalAdd();
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_COAL_ADD . '.csv', $dat['data']);
                }
            }

            // >>> 2019/02/07 燃料CIF価格想定
            if(($auth_bits & $this->authority['PRE_FUEL_CIF']))
            {
                $dat = $this->_fuelFCCifOil();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_OIL . '.csv', $dat['data']);
                $dat = $this->_fuelFCCifCoal();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_COAL . '.csv', $dat['data']);
                $dat = $this->_fuelFCCifLNG();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_LNG . '.csv', $dat['data']);
                // 2022/03/17 202203-05
                $dat = $this->_fuelFCCifLNGAdd();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_LNG_ADD . '.csv', $dat['data']);
                // 2022/07/10
                // if(!empty($this->config->application->show202207) && $this->config->application->show202207)
                if($this->session->get(self::SV_SHOW202207))
                {
                    $dat = $this->_fuelFCCifOilAdd();
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_OIL_ADD . '.csv', $dat['data']);
                    $dat = $this->_fuelFCCifCoalAdd();
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FORWARD_FUEL_CIF_COAL_ADD . '.csv', $dat['data']);
                }
            }
            // <<< 2019/02/07
            
            // Capacity Thermal ----------------------------------------------------------------
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY']))    // 2018/10/07
            {
                $dat = $this->_capacityThermal();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_THERMAL . '.csv', $dat['data']);
            }
            // throw new Exception('Debug ' . __LINE__);
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityThermalEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_THERMAL_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityThermalWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_THERMAL_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityThermalHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_THERMAL_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityThermalKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_THERMAL_K . '.csv', $dat['data']);
            }
            
            // Capacity Nuclear ----------------------------------------------------------------
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY']))    // 2018/10/07
            {
                $dat = $this->_capacityNuclear();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_NUCLEAR . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityNuclearEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_NUCLEAR_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityNuclearWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_NUCLEAR_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityNuclearHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_NUCLEAR_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityNuclearKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_NUCLEAR_K . '.csv', $dat['data']);
            }

            // Capacity Renewable ----------------------------------------------------------------
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY']))    // 2018/10/07
            {
                $dat = $this->_capacityRenewable();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_RENEWABLE . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityRenewableEast();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_RENEWABLE_E . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityRenewableWest();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_RENEWABLE_W . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityRenewableHokkaido();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_RENEWABLE_H . '.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CAPACITY_ALL']))    // 2018/10/07
            {
                $dat = $this->_capacityRenewableKyushu();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_CAPACITY_RENEWABLE_K . '.csv', $dat['data']);
            }
            
            // if (in_array($user_type, [9])) {
            if(($auth_bits & $this->authority['ADMIN']))    // 2018/10/07
            {
                $dat = $this->_historicalDemand();
                $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_HISTORY_DEMAND . '.csv', $dat['data']);
            }
            
            // Interconnect ----------------------------------------------------------------
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CONNECT']))    // 2018/10/07
            {
                $dat = $this->_interconnect();
                // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_INTERCONNECT . '.csv', $dat['data']);
                $this->_save2CSV($sWorkPath . '/' . 'Interconnection FC.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CONNECT']))    // 2018/10/07
            {
                $dat = $this->_interconnectKitahon();
                // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_INTERCONNECT_H . '.csv', $dat['data']);
                $this->_save2CSV($sWorkPath . '/' . 'Interconnection Kitahon.csv', $dat['data']);
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['PRE_CONNECT']))    // 2018/10/07
            {
                $dat = $this->_interconnectKanmon();
                // $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_INTERCONNECT_K . '.csv', $dat['data']);
                $this->_save2CSV($sWorkPath . '/' . 'Interconnection Kanmon.csv', $dat['data']);
            }
            
            // Forward JEPX Short ----------------------------------------------------------------
            // if (in_array($user_type, [3, 4, 5, 6, 7, 8, 9])) {
            if(($auth_bits & $this->authority['FC_JEPX_SYS']))    // 2018/10/07
            {
                $dat = $this->_jepxShort();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FW_JEPX_SHORT . '.csv', $dat['data']);
                }
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_JEPX_5AREA']))    // 2018/10/07
            {
                $dat = $this->_jepxShortEast();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FW_JEPX_SHORT_E . '.csv', $dat['data']);
                }
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_JEPX_5AREA']))    // 2018/10/07
            {
                $dat = $this->_jepxShortWest();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FW_JEPX_SHORT_W . '.csv', $dat['data']);
                }
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_JEPX_5AREA']))    // 2018/10/07
            {
                $dat = $this->_jepxShortHokkaido();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FW_JEPX_SHORT_H . '.csv', $dat['data']);
                }
            }
            // if (in_array($user_type, [4, 6, 8, 9])) {
            if(($auth_bits & $this->authority['FC_JEPX_5AREA']))    // 2018/10/07
            {
                $dat = $this->_jepxShortKyushu();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_FW_JEPX_SHORT_K . '.csv', $dat['data']);
                }
            }
            
            // OneMonth  -------------------------------------------------------
            if(($auth_bits & $this->authority['FWD_DEMAND_SUPPLY_BALANCE']))    // 2019/11/13
            {
                $dat = $this->_oneMonthPrice();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_PRICE_DISTRIBUTION . '.csv', $dat['data']);
                }
                $dat = $this->_oneMonthPriceEast();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_PRICE_DISTRIBUTION_E . '.csv', $dat['data']);
                }
                $dat = $this->_oneMonthPriceWest();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_PRICE_DISTRIBUTION_W . '.csv', $dat['data']);
                }
                $dat = $this->_oneMonthPriceHokkaido();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_PRICE_DISTRIBUTION_H . '.csv', $dat['data']);
                }
                $dat = $this->_oneMonthPriceKyushu();
                if($dat['count'] > 0)
                {   // 2018/11/01
                    $this->_save2CSV($sWorkPath . '/' . UploadController::GRAPH_PRICE_DISTRIBUTION_K . '.csv', $dat['data']);
                }
            }
            
            // make zip
            $this->_makeZip($sZipPath, $sWorkPath);
            
            // remove work dir
            $this->_deleteDir($sWorkPath);
        } catch (Exception $ex) {
            $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_ERROR, 'dlzip error %s', array($ex->getMessage()));
        }

        ob_clean(); // 2018/10/19
        
        // var_dump($sZipPath);exit(0);
        // $res = file_get_contents($sZipPath);
        $response = new \Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/zip");
        $response->setRawHeader("HTTP/1.1 200 OK");
        // $response->setContent($res);
        $response->setFileToSend($sZipPath, date('Ymd') . '.zip');
        $response->send();
        unlink($sZipPath);
        exit(0);
    }
    
}
