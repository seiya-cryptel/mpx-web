<?php

class UploadController extends ControllerBase
{

    // 2015/12/06 SN
    const DATA_FORWARDMAIN = 'Forward Power';
    const DATA_FORWARDMAIN_E = 'Forward Power East';    // 2016/05/16
    const DATA_FORWARDMAIN_W = 'Forward Power West';
    const DATA_FORWARDMAIN_H = 'Forward Power Hokkaido';    // 2017/02/16
    const DATA_FORWARDMAIN_K = 'Forward Power Kyushu';      // 2017/02/16
    const DATA_FORWARDSUB = 'Forward Fuel';
    const DATA_FORWARDSUB_CIF = 'Forward Fuel CIF';         // 2019/02/07
    const DATA_HISTORICALMAIN = 'JEPX';
    const DATA_HISTORICALSUB = 'CME';
    const DATA_HISTORICALDEMAND = 'Historical Demand';    // 2016/03/17
    const DATA_PREREQUISITE = 'Prerequisite';
    const DATA_PREREQUISITE_E = 'Prerequisite East';    // 2016/05/17
    const DATA_PREREQUISITE_W = 'Prerequisite West';
    const DATA_PREREQUISITE_H = 'Prerequisite Hokkaido';    // 2017/02/19
    const DATA_PREREQUISITE_K = 'Prerequisite Kyushu';
    const DATA_FORWARDSUPPLY = 'Forward Supply';    // 2016/03/01
    const DATA_CAPACITY = 'Capacity';    // 2016/03/17
    const DATA_CAPACITY_E = 'Capacity East';    // 2016/05/17
    const DATA_CAPACITY_W = 'Capacity West';
    const DATA_CAPACITY_H = 'Capacity Hokkaido';    // 2017/02/19
    const DATA_CAPACITY_K = 'Capacity Kyushu';
    const DATA_INTERCONNECT = 'Interconnect';   // 2016/05/22
    const DATA_INTERCONNECT_H = 'Interconnec Kitahon';   // 207/02/23
    const DATA_INTERCONNECT_K = 'Interconnect Kanmon';
    const DATA_EVENT = 'Event';     // 2016/06/20
    const DATA_JEPX_SHORT   = 'JEPX Short'; // 2016/06/20
    const DATA_JEPX_SHORT_E   = 'JEPX Short East'; // 2016/07/01
    const DATA_JEPX_SHORT_W   = 'JEPX Short West';
    const DATA_JEPX_SHORT_H   = 'JEPX Short Hokkaido';      // 2017/02/17
    const DATA_JEPX_SHORT_K   = 'JEPX Short Kyushu';
    const DATA_RESIDUAL_LOAD = 'Residual Load';     // 2018/02/16
    const DATA_HYDRO_PUMP = 'Hydro Pump';
    const DATA_ASP = 'ASP';         // 2018/02/26
    // 2019/11/11; 2019/10/21
    const DATA_FWD_D_S_BALANCE = 'Forward Demand Supply Balance';         
    
    // 2016/01/16
    const GRAPH_FORWARD_POWER_HHOUR     = 'Forward Power Half Hour';
    const GRAPH_FORWARD_POWER_HHOUR_E     = 'Forward Power Half Hour East'; // 2016/12/12
    const GRAPH_FORWARD_POWER_HHOUR_W     = 'Forward Power Half Hour West';
    const GRAPH_FORWARD_POWER_HHOUR_H     = 'Forward Power Half Hour Hokkaido';     // 2017/02/26
    const GRAPH_FORWARD_POWER_HHOUR_K     = 'Forward Power Half Hour Kyushu';
    const GRAPH_FORWARD_POWER_HOUR      = 'Forward Power Hour';         // 2016/03/17
    const GRAPH_FORWARD_POWER_HOUR_E    = 'Forward Power Hour East';         // 2018/03/11
    const GRAPH_FORWARD_POWER_HOUR_W    = 'Forward Power Hour West';
    const GRAPH_FORWARD_POWER_HOUR_H    = 'Forward Power Hour Hokkaido';
    const GRAPH_FORWARD_POWER_HOUR_K    = 'Forward Power Hour Kyushu';
    const GRAPH_FORWARD_POWER_DAY       = 'Forward Power Daily';
    const GRAPH_FORWARD_POWER_DAY_E     = 'Forward Power Daily East';   // 2016/12/12
    const GRAPH_FORWARD_POWER_DAY_W     = 'Forward Power Daily West';
    const GRAPH_FORWARD_POWER_DAY_H     = 'Forward Power Daily Hokkaido';   // 2017/02/26
    const GRAPH_FORWARD_POWER_DAY_K     = 'Forward Power Daily Kyushu';
    const GRAPH_FORWARD_POWER_MONTH     = 'Forward Power Monthly';
    const GRAPH_FORWARD_POWER_MONTH_E   = 'Forward Power Monthly East'; // 2016/12/12 2016/06/17
    const GRAPH_FORWARD_POWER_MONTH_W   = 'Forward Power Monthly West';
    const GRAPH_FORWARD_POWER_MONTH_H   = 'Forward Power Monthly Hokkaido';     // 2017/02/26
    const GRAPH_FORWARD_POWER_MONTH_K   = 'Forward Power Monthly Kyushu';

    const GRAPH_FORWARD_FUEL_OIL            = 'Forward Fuel Oil';
    const GRAPH_FORWARD_FUEL_OIL_ADD        = 'Forward Fuel Oil Additional';        // 2022/07/10
    const GRAPH_FORWARD_FUEL_COAL           = 'Forward Fuel Coal';
    const GRAPH_FORWARD_FUEL_COAL_ADD       = 'Forward Fuel Coal Additional';       // 2022/07/10
    const GRAPH_FORWARD_FUEL_LNG            = 'Forward Fuel LNG';
    const GRAPH_FORWARD_FUEL_LNG_ADD        = 'Forward Fuel LNG Additional';        // 2022/03/17
    const GRAPH_FORWARD_FUEL_CIF_OIL        = 'Forward Fuel CIF Oil';               // 2019/02/07
    const GRAPH_FORWARD_FUEL_CIF_OIL_ADD    = 'Forward Fuel CIF Oil Additional';    // 2022/07/10
    const GRAPH_FORWARD_FUEL_CIF_COAL       = 'Forward Fuel CIF Coal';
    const GRAPH_FORWARD_FUEL_CIF_COAL_ADD   = 'Forward Fuel CIF Coal Additional';   // 2022/07/10
    const GRAPH_FORWARD_FUEL_CIF_LNG        = 'Forward Fuel CIF LNG';
    const GRAPH_FORWARD_FUEL_CIF_LNG_ADD    = 'Forward Fuel CIF LNG Additional';    // 2022/03/17
    
    const GRAPH_HISTORY_JEPX_SPOT       = 'Historical JEPX Spot';
    const GRAPH_HISTORY_JEPX_INDEX      = 'Historical JEPX Index';
    const GRAPH_HISTORY_CME             = 'Historical CME';
    
    const GRAPH_PREREQUISITE            = 'Prerequisite';
    
    const GRAPH_FORWARD_DEMAND          = 'Forward Demand';     // 2016/12/12 2016/06/17
    const GRAPH_FORWARD_DEMAND_E        = 'Forward Demand East';
    const GRAPH_FORWARD_DEMAND_W        = 'Forward Demand West';
    const GRAPH_FORWARD_DEMAND_H        = 'Forward Demand Hokkaido';    // 2017/02/26
    const GRAPH_FORWARD_DEMAND_K        = 'Forward Demand Kyushu';
    
    const GRAPH_HISTORY_DEMAND          = 'Historical Demand';  // 2016/03/17
    
    const GRAPH_CAPACITY_THERMAL        = 'Capacity Thermal';   // 2016/03/17
    const GRAPH_CAPACITY_THERMAL_E      = 'Capacity Thermal East';      // 2016/12/12 2016/06/17
    const GRAPH_CAPACITY_THERMAL_W      = 'Capacity Thermal West';
    const GRAPH_CAPACITY_THERMAL_H      = 'Capacity Thermal Hokkaido';
    const GRAPH_CAPACITY_THERMAL_K      = 'Capacity Thermal Kyushu';
    const GRAPH_CAPACITY_NUCLEAR        = 'Capacity Nuclear';   // 2016/03/17
    const GRAPH_CAPACITY_NUCLEAR_E      = 'Capacity Nuclear East';  // 2016/12/12
    const GRAPH_CAPACITY_NUCLEAR_W      = 'Capacity Nuclear West';
    const GRAPH_CAPACITY_NUCLEAR_H      = 'Capacity Nuclear Hokkaido';
    const GRAPH_CAPACITY_NUCLEAR_K      = 'Capacity Nuclear Kyushu';
    const GRAPH_CAPACITY_RENEWABLE      = 'Capacity Renewable';     // 2016/12/12
    const GRAPH_CAPACITY_RENEWABLE_E    = 'Capacity Renewable East';
    const GRAPH_CAPACITY_RENEWABLE_W    = 'Capacity Renewable West';
    const GRAPH_CAPACITY_RENEWABLE_H    = 'Capacity Renewable Hokkaido';    // 2017/02/26
    const GRAPH_CAPACITY_RENEWABLE_K    = 'Capacity Renewable Kyushu';
    
    const GRAPH_INTERCONNECT            = 'Interconnect';    // 2016/12/12 2016/06/17
    const GRAPH_INTERCONNECT_H          = 'Interconnect Kitahon';   // 2017/02/26
    const GRAPH_INTERCONNECT_K          = 'Interconnect Kanmon';

    const GRAPH_FW_JEPX_SHORT       = 'JEPX Forecast Spot';          // 2016/12/13
    const GRAPH_FW_JEPX_SHORT_E     = 'JEPX Forecast Spot East';
    const GRAPH_FW_JEPX_SHORT_W     = 'JEPX Forecast Spot West';
    const GRAPH_FW_JEPX_SHORT_H     = 'JEPX Forecast Spot Hokkaido';
    const GRAPH_FW_JEPX_SHORT_K     = 'JEPX Forecast Spot Kyushu';
    
    const GRAPH_PRICE_DISTRIBUTION      = 'One Month Price';    // 2019/11/13
    const GRAPH_PRICE_DISTRIBUTION_E    = 'One Month Price East';
    const GRAPH_PRICE_DISTRIBUTION_W    = 'One Month Price West';
    const GRAPH_PRICE_DISTRIBUTION_H    = 'One Month Price Hokkaido';
    const GRAPH_PRICE_DISTRIBUTION_K    = 'One Month Price Kyushu';
    
    const FILENAME_FW_HHOUR         = 'PowerForward_%s/half hourly.csv';
    const FILENAME_FW_HHOUR_E       = 'PowerForward_East_%s/half hourly.csv';     // 2016/05/17
    const FILENAME_FW_HHOUR_W       = 'PowerForward_West_%s/half hourly.csv';
    const FILENAME_FW_HHOUR_H       = 'PowerForward_Hokkaido_%s/half hourly.csv';   // 2017/02/16
    const FILENAME_FW_HHOUR_K       = 'PowerForward_Kyushu_%s/half hourly.csv';
    const FILENAME_FW_HOUR          = 'PowerForward_%s/hourly.csv';      // 2016/03/16
    const FILENAME_FW_HOUR_E        = 'PowerForward_East_%s/hourly.csv';      // 2016/03/16
    const FILENAME_FW_HOUR_W        = 'PowerForward_West_%s/hourly.csv';      // 2016/03/16
    const FILENAME_FW_HOUR_H        = 'PowerForward_Hokkaido_%s/hourly.csv';
    const FILENAME_FW_HOUR_K        = 'PowerForward_Kyushu_%s/hourly.csv';
    const FILENAME_FW_DAY           = 'PowerForward_%s/daily.csv';
    const FILENAME_FW_DAY_E         = 'PowerForward_East_%s/daily.csv';
    const FILENAME_FW_DAY_W         = 'PowerForward_West_%s/daily.csv';
    const FILENAME_FW_DAY_H         = 'PowerForward_Hokkaido_%s/daily.csv';
    const FILENAME_FW_DAY_K         = 'PowerForward_Kyushu_%s/daily.csv';
    const FILENAME_FW_MONTHBASE     = 'PowerForward_%s/monthly baseload.csv';
    const FILENAME_FW_MONTHBASE_E   = 'PowerForward_East_%s/monthly baseload.csv';
    const FILENAME_FW_MONTHBASE_W   = 'PowerForward_West_%s/monthly baseload.csv';
    const FILENAME_FW_MONTHBASE_H   = 'PowerForward_Hokkaido_%s/monthly baseload.csv';
    const FILENAME_FW_MONTHBASE_K   = 'PowerForward_Kyushu_%s/monthly baseload.csv';
    const FILENAME_FW_MONTHPEAK     = 'PowerForward_%s/monthly peakload.csv';
    const FILENAME_FW_MONTHPEAK_E   = 'PowerForward_East_%s/monthly peakload.csv';
    const FILENAME_FW_MONTHPEAK_W   = 'PowerForward_West_%s/monthly peakload.csv';
    const FILENAME_FW_MONTHPEAK_H   = 'PowerForward_Hokkaido_%s/monthly peakload.csv';
    const FILENAME_FW_MONTHPEAK_K   = 'PowerForward_Kyushu_%s/monthly peakload.csv';
    const FILENAME_FW_MONTHOFF      = 'PowerForward_%s/monthly offpeak.csv';
    const FILENAME_FW_MONTHOFF_E    = 'PowerForward_East_%s/monthly offpeak.csv';
    const FILENAME_FW_MONTHOFF_W    = 'PowerForward_West_%s/monthly offpeak.csv';
    const FILENAME_FW_MONTHOFF_H    = 'PowerForward_Hokkaido_%s/monthly offpeak.csv';
    const FILENAME_FW_MONTHOFF_K    = 'PowerForward_Kyushu_%s/monthly offpeak.csv';
    
    const FILENAME_FW_SUBOIL = 'FuelForward_%s/PriceData_oil.csv';
    const FILENAME_FW_SUBOIL_ADD = 'FuelForward_%s/PriceData_oil_add.csv';      // 2022/07/09
    const FILENAME_FW_SUBCOAL = 'FuelForward_%s/PriceData_coal.csv';
    const FILENAME_FW_SUBCOAL_ADD = 'FuelForward_%s/PriceData_coal_add.csv';    // 2022/07/09
    const FILENAME_FW_SUBLNG = 'FuelForward_%s/PriceData_lng.csv';
    const FILENAME_FW_SUBLNG_ADD = 'FuelForward_%s/PriceData_lng_add.csv';      // 2022/03/16
    // >>> 2019/02/08
    const FILENAME_FW_SUBCIFOIL = 'CIFForward_%s/PriceDataCIF_oil.csv';
    const FILENAME_FW_SUBCIFOIL_ADD = 'CIFForward_%s/PriceDataCIF_oil_add.csv';     // 2022/07/09
    const FILENAME_FW_SUBCIFCOAL = 'CIFForward_%s/PriceDataCIF_coal.csv';
    const FILENAME_FW_SUBCIFCOAL_ADD = 'CIFForward_%s/PriceDataCIF_coal_add.csv';   // 2022/07/09
    const FILENAME_FW_SUBCIFLNG = 'CIFForward_%s/PriceDataCIF_lng.csv';
    const FILENAME_FW_SUBCIFLNG_ADD = 'CIFForward_%s/PriceDataCIF_lng_add.csv'; // 2022/03/16
    // <<<
    const FILENAME_HST_SPOT = 'JEPX_%s/PriceData_spot.csv';
    const FILENAME_HST_INDEX = 'JEPX_%s/PriceData_Index.csv';
    const FILENAME_HST_SUBOIL = 'CME_%s/PriceData_oil.csv';
    const FILENAME_HST_SUBCOAL = 'CME_%s/PriceData_coal.csv';
    const FILENAME_HST_SUBEXC = 'CME_%s/PriceData_exchange.csv';
    const FILENAME_PREREQUISITE = 'Demand_Renewable_%s/Demand_Renewable.csv';            // 2016/01/15
    const FILENAME_PREREQUISITE_E = 'Demand_Renewable_East_%s/Demand_Renewable.csv';            // 2016/05/17
    const FILENAME_PREREQUISITE_W = 'Demand_Renewable_West_%s/Demand_Renewable.csv';
    const FILENAME_PREREQUISITE_H = 'Demand_Renewable_Hokkaido_%s/Demand_Renewable.csv';        // 2017/02/19
    const FILENAME_PREREQUISITE_K = 'Demand_Renewable_Kyushu_%s/Demand_Renewable.csv';
    const FILENAME_HST_DEMAND = 'HistoricalDemandM_%s/HistoricalDemandM_%s.csv';        // 2016/03/30
    const FILENAME_CAPACITYTHERMAL = 'Capacity_%s/ThermalCapacity_%s.csv';
    const FILENAME_CAPACITYTHERMAL_E = 'Capacity_East_%s/ThermalCapacity_%s.csv';       // 2016/05/17
    const FILENAME_CAPACITYTHERMAL_W = 'Capacity_West_%s/ThermalCapacity_%s.csv';
    const FILENAME_CAPACITYTHERMAL_H = 'Capacity_Hokkaido_%s/ThermalCapacity_%s.csv';   // 2017/02/19
    const FILENAME_CAPACITYTHERMAL_K = 'Capacity_Kyushu_%s/ThermalCapacity_%s.csv';
    const FILENAME_CAPACITYNUCLEAR = 'Capacity_%s/NuclearCapacity_%s.csv';
    const FILENAME_CAPACITYNUCLEAR_E = 'Capacity_East_%s/NuclearCapacity_%s.csv';       // 2016/05/17
    const FILENAME_CAPACITYNUCLEAR_W = 'Capacity_West_%s/NuclearCapacity_%s.csv';
    const FILENAME_CAPACITYNUCLEAR_H = 'Capacity_Hokkaido_%s/NuclearCapacity_%s.csv';   // 2017/02/19
    const FILENAME_CAPACITYNUCLEAR_K = 'Capacity_Kyushu_%s/NuclearCapacity_%s.csv';
    const FILENAME_INTERCONNECT = 'Interconnection_%s/Interconnection.csv';             // 2016/05/22
    const FILENAME_INTERCONNECT_H = 'Interconnection_Kitahon_%s/Interconnection_Kitahon.csv';   // 2017/02/23
    const FILENAME_INTERCONNECT_K = 'Interconnection_Kanmon_%s/Interconnection_Kanmon.csv';
    const FILENAME_EVENT = 'Event_%d.csv';                    // 2016/06/20
    const FILENAME_FW_JEPX_SHORT = 'Jepx_Forecast_%s/Jepx_Forecast_%s.csv';
    const FILENAME_FW_JEPX_SHORT_E = 'Jepx_Forecast_East_%s/Jepx_Forecast_East_%s.csv'; // 2016/07/01
    const FILENAME_FW_JEPX_SHORT_W = 'Jepx_Forecast_West_%s/Jepx_Forecast_West_%s.csv';
    const FILENAME_FW_JEPX_SHORT_H = 'Jepx_Forecast_Hokkaido_%s/Jepx_Forecast_Hokkaido_%s.csv';     // 2017/02/19
    const FILENAME_FW_JEPX_SHORT_K = 'Jepx_Forecast_Kyushu_%s/Jepx_Forecast_Kyushu_%s.csv';
    const FILENAME_RESIDUAL_LOAD = 'Residual-Load_%s/Residual-Load.csv';             // 2018/02/17
    const FILENAME_HYDRO_PUMP = 'Hydro-Pump_%s/Hydro-Pump.csv'; 
    // 2019/11/11; 2019/10/21
    const FILENAME_D_S_BALANCE = 'OneMonth_%s/%s_OneMonth_Supply-Demand_System.csv'; 
    const FILENAME_D_S_BALANCE_E = 'OneMonth_%s/%s_OneMonth_Supply-Demand_East.csv'; 
    const FILENAME_D_S_BALANCE_W = 'OneMonth_%s/%s_OneMonth_Supply-Demand_West.csv'; 
    const FILENAME_D_S_BALANCE_H = 'OneMonth_%s/%s_OneMonth_Supply-Demand_Hokkaido.csv'; 
    const FILENAME_D_S_BALANCE_K = 'OneMonth_%s/%s_OneMonth_Supply-Demand_Kyushu.csv'; 
    const FILENAME_PRICE_DISTRIBUTION = 'OneMonth_%s/%s_OneMonth_price_System.csv'; 
    const FILENAME_PRICE_DISTRIBUTION_E = 'OneMonth_%s/%s_OneMonth_price_East.csv'; 
    const FILENAME_PRICE_DISTRIBUTION_W = 'OneMonth_%s/%s_OneMonth_price_West.csv'; 
    const FILENAME_PRICE_DISTRIBUTION_H = 'OneMonth_%s/%s_OneMonth_price_Hokkaido.csv'; 
    const FILENAME_PRICE_DISTRIBUTION_K = 'OneMonth_%s/%s_OneMonth_price_Kyushu.csv'; 

    // 電力フォワード DB 登録
    private function _forwardPower(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area)
    {        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 10 start', array());
        
        // 既存データ削除
        if ($oldUploadId) {
            $models = array();
            switch($area) {
                case "East":
                    $models = array("ForwardMainHHoursEast", "ForwardMainHoursEast", "ForwardMainDaysEast", "ForwardMainMonthsEast");
                    break;
                case "West":
                    $models = array("ForwardMainHHoursWest", "ForwardMainHoursWest", "ForwardMainDaysWest", "ForwardMainMonthsWest");
                    break;
                case "Hokaido":     // 2017/02/16
                    $models = array("ForwardMainHHoursHokkaido", "ForwardMainHoursHokkaido", "ForwardMainDaysHokkaido", "ForwardMainMonthsHokkaido");
                    break;
                case "Kyushu":
                    $models = array("ForwardMainHHoursKyushu", "ForwardMainHoursKyushu", "ForwardMainDaysKyushu", "ForwardMainMonthsKyushu");
                    break;
                default:
                    $models = array("ForwardMainHHours", "ForwardMainHours", "ForwardMainDays", "ForwardMainMonths");
                    break;
            }
            foreach($models as $model) {
                $query = $this->modelsManager->createQuery('DELETE FROM ' . $model . ' WHERE upload_id=:uploadId:');    // 2018/03/19
                $query->execute(['uploadId' => $oldUploadId]);
            }
        }
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 29 delete oldUploadId: %s', array($oldUploadId));

        // 30 分データ
        switch($area) {
            case "East":
                $strZipFile = sprintf(self::FILENAME_FW_HHOUR_E, $yyyymmdd);
                break;
            case "West":
                $strZipFile = sprintf(self::FILENAME_FW_HHOUR_W, $yyyymmdd);
                break;
            case "Hokkaido":        // 2017/02/16
                $strZipFile = sprintf(self::FILENAME_FW_HHOUR_H, $yyyymmdd);
                break;
            case "Kyushu":
                $strZipFile = sprintf(self::FILENAME_FW_HHOUR_K, $yyyymmdd);
                break;
            default:
                $strZipFile = sprintf(self::FILENAME_FW_HHOUR, $yyyymmdd);
                break;
        }
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new ForwardMainHHoursEast();
                    break;
                case "West":
                    $rec = new ForwardMainHHoursWest();
                    break;
                case "Hokkaido":        // 2017/02/16
                    $rec = new ForwardMainHHoursHokkaido();
                    break;
                case "Kyushu":
                    $rec = new ForwardMainHHoursKyushu();
                    break;
                default:
                    $rec = new ForwardMainHHours();
                    break;
            }
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1]));
            $rec->price = trim(str_replace(',', '', $fields[2]));
            $rec->save();
        }
        fclose($FH);
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 39 end half hourly', array());

        // 1 時間データ 2016/03/17
        switch($area) {
            case "East":
                $strZipFile = sprintf(self::FILENAME_FW_HOUR_E, $yyyymmdd);
                break;
            case "West":
                $strZipFile = sprintf(self::FILENAME_FW_HOUR_W, $yyyymmdd);
                break;
            case "Hokkaido":        // 2017/02/16
                $strZipFile = sprintf(self::FILENAME_FW_HOUR_H, $yyyymmdd);
                break;
            case "Kyushu":
                $strZipFile = sprintf(self::FILENAME_FW_HOUR_K, $yyyymmdd);
                break;
            default:
                $strZipFile = sprintf(self::FILENAME_FW_HOUR, $yyyymmdd);
                break;
        }
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new ForwardMainHoursEast();
                    break;
                case "West":
                    $rec = new ForwardMainHoursWest();
                    break;
                case "Hokkaido":        // 2017/02/16
                    $rec = new ForwardMainHoursHokkaido();
                    break;
                case "Kyushu":
                    $rec = new ForwardMainHoursKyushu();
                    break;
                default:
                    $rec = new ForwardMainHours();
                    break;
            }
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00'));
            $rec->pr = trim(str_replace(',', '', $fields[2]));
            $rec->save();
        }
        fclose($FH);
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 49 end hour', array());

        // 日時
        switch($area) {
            case "East":
                $strZipFile = sprintf(self::FILENAME_FW_DAY_E, $yyyymmdd);
                break;
            case "West":
                $strZipFile = sprintf(self::FILENAME_FW_DAY_W, $yyyymmdd);
                break;
            case "Hokkaido":        // 2017/02/16
                $strZipFile = sprintf(self::FILENAME_FW_DAY_H, $yyyymmdd);
                break;
            case "Kyushu":
                $strZipFile = sprintf(self::FILENAME_FW_DAY_K, $yyyymmdd);
                break;
            default:
                $strZipFile = sprintf(self::FILENAME_FW_DAY, $yyyymmdd);
                break;
        }
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new ForwardMainDaysEast();
                    break;
                case "West":
                    $rec = new ForwardMainDaysWest();
                    break;
                case "Hokkaido":        // 2017/02/16
                    $rec = new ForwardMainDaysHokkaido();
                    break;
                case "Kyushu":
                    $rec = new ForwardMainDaysKyushu();
                    break;
                default:
                    $rec = new ForwardMainDays();
                    break;
            }
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0]));
            $rec->price = trim(str_replace(',', '', $fields[1]));
            $rec->save();
        }
        fclose($FH);
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 59 end daily', array());

        // 月次
        $monthlyData = array();
        switch($area) {
            case "East":
                $strZipFiles = array(
                    sprintf(self::FILENAME_FW_MONTHBASE_E, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHPEAK_E, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHOFF_E, $yyyymmdd),
                    );
                break;
            case "West":
                $strZipFiles = array(
                    sprintf(self::FILENAME_FW_MONTHBASE_W, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHPEAK_W, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHOFF_W, $yyyymmdd),
                    );
                break;
            case "Hokkaido":        // 2017/02/16
                $strZipFiles = array(
                    sprintf(self::FILENAME_FW_MONTHBASE_H, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHPEAK_H, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHOFF_H, $yyyymmdd),
                    );
                break;
            case "Kyushu":
                $strZipFiles = array(
                    sprintf(self::FILENAME_FW_MONTHBASE_K, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHPEAK_K, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHOFF_K, $yyyymmdd),
                    );
                break;
            default:
                $strZipFiles = array(
                    sprintf(self::FILENAME_FW_MONTHBASE, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHPEAK, $yyyymmdd),
                    sprintf(self::FILENAME_FW_MONTHOFF, $yyyymmdd),
                    );
                break;
        }
        $FH = $zip->getStream($strZipFiles[0]);
        if (!$FH) {
            $this->flash->error($strZipFiles[0] . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = $fields[0];
            $fieldPrice = trim(str_replace(',', '', $fields[1]));
            $monthlyData[$fieldDate]['Base'] = $fieldPrice;
        }
        fclose($FH);
        // Peak
        $FH = $zip->getStream($strZipFiles[1]);
        if (!$FH) {
            $this->flash->error($strZipFiles[1] . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = $fields[0];
            $fieldPrice = trim(str_replace(',', '', $fields[1]));
            $monthlyData[$fieldDate]['Peak'] = $fieldPrice;
        }
        fclose($FH);
        // Offpeak
        $FH = $zip->getStream($strZipFiles[2]);
        if (!$FH) {
            $this->flash->error($strZipFiles[2] . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = $fields[0];
            $fieldPrice = trim(str_replace(',', '', $fields[1]));
            $monthlyData[$fieldDate]['Offpeak'] = $fieldPrice;
        }
        fclose($FH);
        // write
        foreach ($monthlyData as $d => $m) {
            switch($area) {
                case "East":
                    $rec = new ForwardMainMonthsEast();
                    break;
                case "West":
                    $rec = new ForwardMainMonthsWest();
                    break;
                case "Hokkaido":        // 2017/02/16
                    $rec = new ForwardMainMonthsHokkaido();
                    break;
                case "Kyushu":
                    $rec = new ForwardMainMonthsKyushu();
                    break;
                default:
                    $rec = new ForwardMainMonths();
                    break;
            }
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = $d;
            if (isset($m['Base'])) {
                $rec->price_base = $m['Base'];
            }
            if (isset($m['Peak'])) {
                $rec->price_peak = $m['Peak'];
            }
            if (isset($m['Offpeak'])) {
                $rec->price_offpeak = $m['Offpeak'];
            }
            $rec->save();
        }
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' 69 end monthly', array());
        return true;
    }

    private function _forwardFuel(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        if ($oldUploadId) {
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCoals WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubOils WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubLngs WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            // 2022/03/16
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubLngAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            // 2022/07/09
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCoalAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubOilAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
        }

        // Coal
        $strZipFile = sprintf(self::FILENAME_FW_SUBCOAL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubCoals();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubCoals();
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        
        // 2022/07/09 Coal Add
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $strZipFile = sprintf(self::FILENAME_FW_SUBCOAL_ADD, $yyyymmdd);
            $FH = $zip->getStream($strZipFile);
            if (!$FH) {
                $this->flash->error($strZipFile . ' が見つかりません。');
                return false;
            }
            $inst = new ForwardSubCoalAdds();
            $inst->fromCSVStream($FH, $uploadId);
            fclose($FH);
            // $this->flash->error($strZipFile . ' デバッグ ' . $uploadId);
            // return false;
        }
        
        // Oil
        $strZipFile = sprintf(self::FILENAME_FW_SUBOIL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubOils();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubOils();
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        
        // Oil Adds 2022/07/10
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $strZipFile = sprintf(self::FILENAME_FW_SUBOIL_ADD, $yyyymmdd);
            $FH = $zip->getStream($strZipFile);
            if (!$FH) {
                $this->flash->error($strZipFile . ' が見つかりません。');
                return false;
            }
            $inst = new ForwardSubOilAdds();
            $inst->fromCSVStream($FH, $uploadId);
            fclose($FH);
        }

        // LNG
        $strZipFile = sprintf(self::FILENAME_FW_SUBLNG, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubLngs();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubLngs();
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);

        // >>> 2022/03/16
        // LNG Add
        $strZipFile = sprintf(self::FILENAME_FW_SUBLNG_ADD, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubLngAdds();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubLngAdds();
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        // <<< 2022/03/16

        return true;
    }

    // 2019/02/08 燃料CIF価格想定
    private function _forwardFuelCIF(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        if ($oldUploadId) {
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifCoals WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifOils WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifLngs WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            // 2022/03/16
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifLngAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            // 2022/07/09
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifCoalAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
            $query = $this->modelsManager->createQuery('DELETE FROM ForwardSubCifOilAdds WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
        }

        // Coal
        $strZipFile = sprintf(self::FILENAME_FW_SUBCIFCOAL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubCifCoals();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubCifCoals();
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        
        // Coal Adds 2022/07/10
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $strZipFile = sprintf(self::FILENAME_FW_SUBCIFCOAL_ADD, $yyyymmdd);
            $FH = $zip->getStream($strZipFile);
            if (!$FH) {
                $this->flash->error($strZipFile . ' が見つかりません。');
                return false;
            }
            $inst = new ForwardSubCifCoalAdds();
            $inst->fromCSVStream($FH, $uploadId);
            fclose($FH);
        }

        // Oil
        $strZipFile = sprintf(self::FILENAME_FW_SUBCIFOIL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubCifOils();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubCifOils();
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        
        // Oil Adds 2022/07/10
        if($this->session->get(self::SV_SHOW202207))
        {   // 2022/07/21 202207-02
            $strZipFile = sprintf(self::FILENAME_FW_SUBCIFOIL_ADD, $yyyymmdd);
            $FH = $zip->getStream($strZipFile);
            if (!$FH) {
                $this->flash->error($strZipFile . ' が見つかりません。');
                return false;
            }
            $inst = new ForwardSubCifOilAdds();
            $inst->fromCSVStream($FH, $uploadId);
            fclose($FH);
        }

        // LNG
        $strZipFile = sprintf(self::FILENAME_FW_SUBCIFLNG, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubCifLngs();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubCifLngs();
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);

        // >>> 2022/03/16
        // LNG Add
        $strZipFile = sprintf(self::FILENAME_FW_SUBCIFLNG_ADD, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        $inst = new ForwardSubCifLngAdds();
        $inst->fromCSVStream($FH, $uploadId);
        /*
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new ForwardSubCifLngAdds();
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $rec->price = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
         * 
         */
        fclose($FH);
        // <<< 2022/03/16

        return true;
    }

    private function _JEPX(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        // delete old records
        // $query = $this->modelsManager->createQuery('DELETE FROM HistoricalMainSpots');
        // $query->execute();
        // $query = $this->modelsManager->createQuery('DELETE FROM HistoricalMainIndexes');
        // $query->execute();
 
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' uploadId: %s, oldUploadId: %s, yyyymmdd: %s', array($uploadId, $oldUploadId, $yyyymmdd));   // 2018/10/21

        // Change upload_id to new one 2016/06/28
        $query = $this->modelsManager->createQuery('UPDATE HistoricalMainSpots SET upload_id=' . $uploadId);
        $query->execute();
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' tt51_hst_jepx_spot uploadId updated %s', array($uploadId));   // 2018/10/21
        $query = $this->modelsManager->createQuery('UPDATE HistoricalMainIndexes SET upload_id=' . $uploadId);
        $query->execute();
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' tt52_hst_jepx_index uploadId updated %s', array($uploadId));   // 2018/10/21

        // Spot
        $strZipFile = sprintf(self::FILENAME_HST_SPOT, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $hour = floor(($fields[1] - 1) * 30 / 60);
            $min = (($fields[1] - 1) * 30) % 60;

            // 日付をキーとして更新、または挿入 2016/06/28
            $keyDateTime = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $hour . ':' . $min));
            $rec = HistoricalMainSpots::findFirst(array(
                        'conditions' => 'hst_datetime = :dataType:',
                        'bind' => ['dataType' => $keyDateTime],
            ));
            if($rec === false) {
                $rec = new HistoricalMainSpots();
            }

            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            // $rec->hst_datetime = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $hour . ':' . $min));
            $rec->hst_datetime = $keyDateTime;
            $rec->sale = trim(str_replace(',', '', $fields[2]));
            $rec->buy = trim(str_replace(',', '', $fields[3]));
            $rec->contract = trim(str_replace(',', '', $fields[4]));
            $rec->price_system = trim(str_replace(',', '', $fields[5]));
            $rec->price_area_01 = trim(str_replace(',', '', $fields[6]));
            $rec->price_area_02 = trim(str_replace(',', '', $fields[7]));
            $rec->price_area_03 = trim(str_replace(',', '', $fields[8]));
            $rec->price_area_04 = trim(str_replace(',', '', $fields[9]));
            $rec->price_area_05 = trim(str_replace(',', '', $fields[10]));
            $rec->price_area_06 = trim(str_replace(',', '', $fields[11]));
            $rec->price_area_07 = trim(str_replace(',', '', $fields[12]));
            $rec->price_area_08 = trim(str_replace(',', '', $fields[13]));
            $rec->price_area_09 = trim(str_replace(',', '', $fields[14]));
            $rec->save();
        }
        fclose($FH);
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' tt52_hst_jepx_spot updated', array());   // 2018/10/21

        // Index
        $strZipFile = sprintf(self::FILENAME_HST_INDEX, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            // 日付をキーとして更新、または挿入 2016/06/28
            $keyDateTime = date('Y-m-d H:i:s', strtotime($fields[0]));
            $rec = HistoricalMainIndexes::findFirst(array(
                        'conditions' => 'hst_datetime = :dataType:',
                        'bind' => ['dataType' => $keyDateTime],
            ));
            if($rec === false) {
                $rec = new HistoricalMainIndexes();
            }
            
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            // $rec->hst_datetime = date('Y-m-d H:i:s', strtotime($fields[0]));
            $rec->hst_datetime = $keyDateTime;
            $rec->da_24 = trim(str_replace(',', '', $fields[1]));
            $rec->da_dt = trim(str_replace(',', '', $fields[2]));
            $rec->da_pt = trim(str_replace(',', '', $fields[3]));
            $rec->ttv = trim(str_replace(',', '', $fields[4]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _CME(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        // delete old records
        if ($oldUploadId) {
            $query = $this->modelsManager->createQuery('DELETE FROM HistoricalSubs WHERE upload_id=:uploadId:');
            $query->execute(['uploadId' => $oldUploadId]);
        }
        // delete old records
        // $query = $this->modelsManager->createQuery('DELETE FROM HistoricalSubs');
        // $query->execute();

        // Sub
        $subData = array();
        // Coal
        $strZipFile = sprintf(self::FILENAME_HST_SUBCOAL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $fieldPrice = trim(str_replace(',', '', $fields[3]));
            $subData[$fieldDate]['Coal'] = $fieldPrice;
        }
        fclose($FH);
        // oil
        $strZipFile = sprintf(self::FILENAME_HST_SUBOIL, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $fieldPrice = trim(str_replace(',', '', $fields[3]));
            $subData[$fieldDate]['Oil'] = $fieldPrice;
        }
        fclose($FH);
        // exchange
        $strZipFile = sprintf(self::FILENAME_HST_SUBEXC, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $fieldDate = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $fieldPrice = trim(str_replace(',', '', $fields[3]));
            $subData[$fieldDate]['Exchange'] = $fieldPrice;
        }
        fclose($FH);
        // write
        foreach ($subData as $d => $m) {
            $rec = new HistoricalSubs();
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->hst_datetime = $d;
            if (isset($m['Coal'])) {
                $rec->coal = $m['Coal'];
            }
            if (isset($m['Oil'])) {
                $rec->oil = $m['Oil'];
            }
            if (isset($m['Exchange'])) {
                $rec->exchange = $m['Exchange'];
            }
            if($rec->save() == false) {
                return false;
            }
        }

        return true;
    }

    private function _prerequisite(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area)
    {
        // Prerequisite
        switch($area) {
            case "East":
                $strModel = 'PrerequisitesEast';
                $strZipFile = sprintf(self::FILENAME_PREREQUISITE_E, $yyyymmdd);
                break;
            case "West":
                $strModel = 'PrerequisitesWest';
                $strZipFile = sprintf(self::FILENAME_PREREQUISITE_W, $yyyymmdd);
                break;
            case "Hokkaido":        // 2017/02/19
                $strModel = 'PrerequisitesHokkaido';
                $strZipFile = sprintf(self::FILENAME_PREREQUISITE_H, $yyyymmdd);
                break;
            case "Kyushu":
                $strModel = 'PrerequisitesKyushu';
                $strZipFile = sprintf(self::FILENAME_PREREQUISITE_K, $yyyymmdd);
                break;
            default :
                $strModel = 'Prerequisites';
                $strZipFile = sprintf(self::FILENAME_PREREQUISITE, $yyyymmdd);
                break;
        }
        // delete old records
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModel);
        $query->execute();

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new PrerequisitesEast();
                    break;
                case "West":
                    $rec = new PrerequisitesWest();
                    break;
                case "Hokkaido":        // 2017/02/19
                    $rec = new PrerequisitesHokkaido();
                    break;
                case "Kyushu":
                    $rec = new PrerequisitesKyushu();
                    break;
                default :
                    $rec = new Prerequisites();
                    break;
            }
            $rec->upload_id = $uploadId;
            // $rec->load_date = $strTargetDate;
            $rec->fc_datetime = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00:00'));
            $rec->load = trim(str_replace(',', '', $fields[2]));
            $rec->wind = trim(str_replace(',', '', $fields[3]));
            $rec->solar = trim(str_replace(',', '', $fields[4]));
            $rec->geothermal = trim(str_replace(',', '', $fields[5]));  // 2016/04/27
            $rec->biomass = trim(str_replace(',', '', $fields[6]));
            $rec->hydro = trim(str_replace(',', '', $fields[7]));       // 2016/03/17
            $rec->hydro_pump = trim(str_replace(',', '', $fields[8]));
            $rec->reside_load = trim(str_replace(',', '', $fields[9]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _historicalDemand(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        // delete old records
        $query = $this->modelsManager->createQuery('DELETE FROM HistoricalDemands');
        $query->execute();

        $strZipFile = sprintf(self::FILENAME_HST_DEMAND, $yyyymmdd, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new HistoricalDemands();
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00'));
            $rec->hokkaido = trim(str_replace(',', '', $fields[2]));        // 2017/2/19
            $rec->east = trim(str_replace(',', '', $fields[3]));    // 2016/03/18
            $rec->west = trim(str_replace(',', '', $fields[4]));
            $rec->kyushu = trim(str_replace(',', '', $fields[5]));      // 2017/2/19
            $rec->demand = trim(str_replace(',', '', $fields[6]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _capacity(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area)
    {
        switch($area) {
            case "East":
                $strModelThermals = 'CapacityThermalsEast';
                $strModelNuclears = 'CapacityNuclearsEast';
                $strZipFile = sprintf(self::FILENAME_CAPACITYTHERMAL_E, $yyyymmdd, $yyyymmdd);
                break;
            case "West":
                $strModelThermals = 'CapacityThermalsWest';
                $strModelNuclears = 'CapacityNuclearsWest';
                $strZipFile = sprintf(self::FILENAME_CAPACITYTHERMAL_W, $yyyymmdd, $yyyymmdd);
                break;
            case "Hokkaido":        // 2017/02/19
                $strModelThermals = 'CapacityThermalsHokkaido';
                $strModelNuclears = 'CapacityNuclearsHokkaido';
                $strZipFile = sprintf(self::FILENAME_CAPACITYTHERMAL_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kyushu":
                $strModelThermals = 'CapacityThermalsKyushu';
                $strModelNuclears = 'CapacityNuclearsKyushu';
                $strZipFile = sprintf(self::FILENAME_CAPACITYTHERMAL_K, $yyyymmdd, $yyyymmdd);
                break;
            default:
                $strModelThermals = 'CapacityThermals';
                $strModelNuclears = 'CapacityNuclears';
                $strZipFile = sprintf(self::FILENAME_CAPACITYTHERMAL, $yyyymmdd, $yyyymmdd);
                break;
        }
        // delete old records 2016/05/26
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModelNuclears);
        $query->execute();
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModelThermals);
        $query->execute();
        
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new CapacityThermalsEast();
                    break;
                case "West":
                    $rec = new CapacityThermalsWest();
                    break;
                case "Hokkaido":        // 2017/02/19
                    $rec = new CapacityThermalsHokkaido();
                    break;
                case "Kyushu":
                    $rec = new CapacityThermalsKyushu();
                    break;
                default:
                    $rec = new CapacityThermals();
                    break;
            }
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0]));
            $rec->coal = trim(str_replace(',', '', $fields[1]));
            $rec->lng = trim(str_replace(',', '', $fields[2]));
            $rec->oil = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
        fclose($FH);

        switch($area) {
            case "East":
                $strZipFile = sprintf(self::FILENAME_CAPACITYNUCLEAR_E, $yyyymmdd, $yyyymmdd);
                break;
            case "West":
                $strZipFile = sprintf(self::FILENAME_CAPACITYNUCLEAR_W, $yyyymmdd, $yyyymmdd);
                break;
            case "Hokkaido":    // 2017/02/19
                $strZipFile = sprintf(self::FILENAME_CAPACITYNUCLEAR_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kyushu":
                $strZipFile = sprintf(self::FILENAME_CAPACITYNUCLEAR_K, $yyyymmdd, $yyyymmdd);
                break;
            default:
                $strZipFile = sprintf(self::FILENAME_CAPACITYNUCLEAR, $yyyymmdd, $yyyymmdd);
                break;
        }
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "East":
                    $rec = new CapacityNuclearsEast();
                    break;
                case "West":
                    $rec = new CapacityNuclearsWest();
                    break;
                case "Hokkaido":        // 2017/02/19
                    $rec = new CapacityNuclearsHokkaido();
                    break;
                case "Kyushu":
                    $rec = new CapacityNuclearsKyushu();
                    break;
                default:
                    $rec = new CapacityNuclears();
                    break;
            }
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0]));
            $rec->nuclear = trim(str_replace(',', '', $fields[1]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _interconnect(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area)
    {
        // 旧レコード削除
        switch($area) {
            case "Kitahon":
                $strModel = 'InterconnectsKitahon';
                $strZipFile = sprintf(self::FILENAME_INTERCONNECT_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kanmon":
                $strModel = 'InterconnectsKanmon';
                $strZipFile = sprintf(self::FILENAME_INTERCONNECT_K, $yyyymmdd, $yyyymmdd);
                break;
            default:
                $strModel = 'Interconnects';
                $strZipFile = sprintf(self::FILENAME_INTERCONNECT, $yyyymmdd, $yyyymmdd);
                break;
        }
        // delete old records 2016/05/26
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModel);
        $query->execute();

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch($area) {
                case "Kitahon":
                    $rec = new InterconnectsKitahon();
                    break;
                case "Kanmon":
                    $rec = new InterconnectsKanmon();
                    break;
                default:
                    $rec = new Interconnects();
                    break;
            }
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00'));
            $rec->forward = trim(str_replace(',', '', $fields[2]));
            $rec->reverse = trim(str_replace(',', '', $fields[3]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _event(&$zip, $uploadId, $oldUploadId, $yyyymmdd)
    {
        // delete old records
        $query = $this->modelsManager->createQuery('DELETE FROM Events');
        $query->execute();

        $strZipFile = sprintf(self::FILENAME_EVENT, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $rec = new Events();
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0]));
            $rec->area = $fields[1];
            $rec->category = $fields[2];
            //$rec->event = mb_convert_encoding($fields[3],"UTF-8","SJIS");         2018/09/28
            // $rec->description = mb_convert_encoding($fields[4],"UTF-8","SJIS");
            $rec->event = mb_convert_encoding($fields[3],"UTF-8","SJIS-win");
            $rec->description = mb_convert_encoding($fields[4],"UTF-8","SJIS-win");
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    private function _JEPX_Short(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area)
    {
         switch($area) {    // 2016/07/01
            case "East":
                $strModel = 'JEPXShortsEast';
                $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT_E, $yyyymmdd, $yyyymmdd);
                break;
            case "West":
                $strModel = 'JEPXShortsWest';
                $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT_W, $yyyymmdd, $yyyymmdd);
                break;
            case "Hokkaido":    // 2017/02/19 
                $strModel = 'JEPXShortsHokkaido';
                $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kyushu":
                $strModel = 'JEPXShortsKyushu';
                $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT_K, $yyyymmdd, $yyyymmdd);
                break;
            default :
                $strModel = 'JEPXShorts';
                $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT, $yyyymmdd, $yyyymmdd);
                break;
        }
        
        // delete old records
        // $query = $this->modelsManager->createQuery('DELETE FROM JEPXShorts');
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModel);
        $query->execute();

        // $strZipFile = sprintf(self::FILENAME_FW_JEPX_SHORT, $yyyymmdd, $yyyymmdd);
        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch ($area) {
            case 'East':
                $rec = new JEPXShortsEast();
                break;
            case 'West':
                $rec = new JEPXShortsWest();
                break;
            case 'Hokkaido':        // 2017/02/19
                $rec = new JEPXShortsHokkaido();
                break;
            case 'Kyushu':
                $rec = new JEPXShortsKyushu();
                break;
            default:
                $rec = new JEPXShorts();
                break;
            }
            $rec->upload_id = $uploadId;
            $rec->dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1]));
            $rec->spot = trim(str_replace(',', '', $fields[2]));
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    // 残余需要
    private function _Residual_Load($zip, $yyyymmdd)
    {
        $strZipFile = sprintf(self::FILENAME_RESIDUAL_LOAD, $yyyymmdd);

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00'));
            // System
            $rec = Prerequisites::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->reside_load = $fields[2];
                $rec->save();
            }
            // East
            $rec = PrerequisitesEast::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->reside_load = $fields[3];
                $rec->save();
            }
            // West
            $rec = PrerequisitesWest::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->reside_load = $fields[4];
                $rec->save();
            }
            // Hokkaido
            $rec = PrerequisitesHokkaido::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->reside_load = $fields[5];
                $rec->save();
            }
            // Kyushu
            $rec = PrerequisitesKyushu::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->reside_load = $fields[6];
                $rec->save();
            }
        }
        fclose($FH);

        return true;
    }

    // 揚水
    private function _Hydro_Pump($zip, $yyyymmdd)
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' start ', array($email, $name, $userName));
        $strZipFile = sprintf(self::FILENAME_HYDRO_PUMP, $yyyymmdd);

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            $dt = date('Y-m-d H:i:s', strtotime($fields[0] . ' ' . $fields[1] . ':00'));
            // System
            $rec = Prerequisites::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->hydro_pump = $fields[2];
                $rec->save();
            }
            // East
            $rec = PrerequisitesEast::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->hydro_pump = $fields[3];
                $rec->save();
            }
            // West
            $rec = PrerequisitesWest::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->hydro_pump = $fields[4];
                $rec->save();
            }
            // Hokkaido
            $rec = PrerequisitesHokkaido::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->hydro_pump = $fields[5];
                $rec->save();
            }
            // Kyushu
            $rec = PrerequisitesKyushu::findFirst(array(
                        'conditions' => 'fc_datetime=:fcDatetime:',
                        'bind' => ['fcDatetime' => $dt],
            ));
            if($rec)
            {
                $rec->hydro_pump = $fields[6];
                $rec->save();
            }
        }
        fclose($FH);

        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' end ', array($email, $name, $userName));
        return true;
    }
    
    // ASP
    private function _ASP($zip)
    {
        // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . '::' . __FUNCTION__ . ' start ', array());
        // $zip->extractTo(AspController::FolderRoot);  2018/04/29
        $zip->extractTo($this->config->application->uploadDir . 'folder/');
        $saveTopName = '';
        for($n = 0; $n < $zip->numFiles; $n++)
        {
            $ary = explode('/', $zip->getNameIndex($n));
            // $this->chmodrf(AspController::FolderRoot . $ary[0], 0660 );  2018/04/29
            $this->chmodrf($this->config->application->uploadDir . 'folder/' . $ary[0], 0660 );
        }
        return true;
    }

    // 2019/10/22 FWD_D_S_Balance 需給バランス予測
    private function _Fwd_D_S_Balance(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area = 'System')
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' Target Date: %s, Area: %s', array($yyyymmdd, $area));
        switch($area) {
            case "East":
                $strModel = 'DSBalancesEast';
                $strZipFile = sprintf(self::FILENAME_D_S_BALANCE_E, $yyyymmdd, $yyyymmdd);
                break;
            case "West":
                $strModel = 'DSBalancesWest';
                $strZipFile = sprintf(self::FILENAME_D_S_BALANCE_W, $yyyymmdd, $yyyymmdd);
                break;
            case "Hokkaido":
                $strModel = 'DSBalancesHokkaido';
                $strZipFile = sprintf(self::FILENAME_D_S_BALANCE_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kyushu":
                $strModel = 'DSBalancesKyushu';
                $strZipFile = sprintf(self::FILENAME_D_S_BALANCE_K, $yyyymmdd, $yyyymmdd);
                break;
            default :
                $strModel = 'DSBalances';
                $strZipFile = sprintf(self::FILENAME_D_S_BALANCE, $yyyymmdd, $yyyymmdd);
                break;
        }
        
        // delete old records
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModel);
        $query->execute();

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch ($area) {
            case 'East':
                $rec = new DSBalancesEast();
                break;
            case 'West':
                $rec = new DSBalancesWest();
                break;
            case 'Hokkaido':
                $rec = new DSBalancesHokkaido();
                break;
            case 'Kyushu':
                $rec = new DSBalancesKyushu();
                break;
            default:
                $rec = new DSBalances();
                break;
            }
            $rec->upload_id = $uploadId;
            $rec->fc_datetime = date('Y-m-d H:i:s', strtotime($fields[0] . $fields[1] . ':00'));
            $rec->d_max = $fields[2];
            $rec->d_min = $fields[3];
            $rec->d_mean = $fields[4];
            $rec->s_nuclear = $fields[5];
            $rec->s_coal_usc = $fields[6];
            $rec->s_coal_sc = $fields[7];
            $rec->s_coal_misc = $fields[8];
            $rec->s_lng_macc2 = $fields[9];
            $rec->s_lng_macc = $fields[10];
            $rec->s_lng_acc = $fields[11];
            $rec->s_lng_cc = $fields[12];
            $rec->s_lng_misc = $fields[13];
            $rec->s_oil = $fields[14];
            $rec->save();
        }
        fclose($FH);

        return true;
    }

    // 2019/10/22 FWD_Price_Distribution 価格分布予測
    private function _Fwd_Price_Distribution(&$zip, $uploadId, $oldUploadId, $yyyymmdd, $area = 'System')
    {
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' Target Date: %s, Area: %s', array($yyyymmdd, $area));
        switch($area) {    // 2016/07/01
            case "East":
                $strModel = 'PriceDistributionsEast';
                $strZipFile = sprintf(self::FILENAME_PRICE_DISTRIBUTION_E, $yyyymmdd, $yyyymmdd);
                break;
            case "West":
                $strModel = 'PriceDistributionsWest';
                $strZipFile = sprintf(self::FILENAME_PRICE_DISTRIBUTION_W, $yyyymmdd, $yyyymmdd);
                break;
            case "Hokkaido":    // 2017/02/19 
                $strModel = 'PriceDistributionsHokkaido';
                $strZipFile = sprintf(self::FILENAME_PRICE_DISTRIBUTION_H, $yyyymmdd, $yyyymmdd);
                break;
            case "Kyushu":
                $strModel = 'PriceDistributionsKyushu';
                $strZipFile = sprintf(self::FILENAME_PRICE_DISTRIBUTION_K, $yyyymmdd, $yyyymmdd);
                break;
            default :
                $strModel = 'PriceDistributions';
                $strZipFile = sprintf(self::FILENAME_PRICE_DISTRIBUTION, $yyyymmdd, $yyyymmdd);
                break;
        }
        
        // delete old records
        $query = $this->modelsManager->createQuery('DELETE FROM ' . $strModel);
        $query->execute();

        $FH = $zip->getStream($strZipFile);
        if (!$FH) {
            $this->flash->error($strZipFile . ' が見つかりません。');
            return false;
        }
        fgetcsv($FH);
        while (($fields = fgetcsv($FH)) !== FALSE) {
            switch ($area) {
            case 'East':
                $rec = new PriceDistributionsEast();
                break;
            case 'West':
                $rec = new PriceDistributionsWest();
                break;
            case 'Hokkaido':        // 2017/02/19
                $rec = new PriceDistributionsHokkaido();
                break;
            case 'Kyushu':
                $rec = new PriceDistributionsKyushu();
                break;
            default:
                $rec = new PriceDistributions();
                break;
            }
            $rec->upload_id = $uploadId;
            $rec->price = $fields[0];
            $rec->w1_24h = $fields[1];
            $rec->w2_24h = $fields[2];
            $rec->w3_24h = $fields[3];
            $rec->w1_0818 = $fields[4];
            $rec->w2_0818 = $fields[5];
            $rec->w3_0818 = $fields[6];
            $rec->w1_0820 = $fields[7];
            $rec->w2_0820 = $fields[8];
            $rec->w3_0820 = $fields[9];
            $rec->w1_0822 = $fields[10];
            $rec->w2_0822 = $fields[11];
            $rec->w3_0822 = $fields[12];
            $rec->save();
        }
        fclose($FH);

        return true;
    }
    
    private function _graphData($uploadId, $uploadType) {
        
        switch ($uploadType) {
        case self::DATA_FORWARDMAIN:
            $half_hourly_data_list = $this->_readGraphForwardPowerHalfHourly($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_POWER_HHOUR);
            $graphData->graph_data = json_encode($half_hourly_data_list);
            $graphData->save();
            
            $hourly_data_list = $this->_readGraphForwardPowerHourly($uploadId); // 2016/03/17
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_POWER_HOUR);
            $graphData->graph_data = json_encode($hourly_data_list);
            $graphData->save();
            
            $daily_data_list = $this->_readGraphForwardPowerDaily($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_POWER_DAY);
            $graphData->graph_data = json_encode($daily_data_list);
            $graphData->save();
            
            $monthly_data_list=$this->_readGraphForwardPowerMonthly($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_POWER_MONTH);
            $graphData->graph_data = json_encode($monthly_data_list);
            $graphData->save();            
            break;
            
        case self::DATA_FORWARDSUB:
            $arrayData = $this->_readGraphForwardFuelOil($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_OIL);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            
            $arrayData = $this->_readGraphForwardFuelCoal($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_COAL);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            

            $arrayData = $this->_readGraphForwardFuelLNG($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_LNG);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;

        // >>> 2019/02/08 燃料CIF価格想定
        case self::DATA_FORWARDSUB_CIF:
            $arrayData = $this->_readGraphForwardFuelCifOil($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_CIF_OIL);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            
            $arrayData = $this->_readGraphForwardFuelCifCoal($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_CIF_COAL);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            

            $arrayData = $this->_readGraphForwardFuelCifLNG($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_FORWARD_FUEL_CIF_LNG);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;
        
        case self::DATA_HISTORICALMAIN:
            $arrayData = $this->_readGraphJEPXSpot($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_HISTORY_JEPX_SPOT);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            

            $arrayData = $this->_readGraphJEPXIndex($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_HISTORY_JEPX_INDEX);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;
        
        case self::DATA_HISTORICALSUB:
            $arrayData = $this->_readGraphCME($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_HISTORY_CME);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;
        
        case self::DATA_PREREQUISITE:
            $arrayData = $this->_readGraphPrerequisite($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_PREREQUISITE);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;
        
        case self::DATA_HISTORICALDEMAND:
            $arrayData = $this->_readGraphHistoricalDemand($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_HISTORY_DEMAND);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;
        
        case self::DATA_CAPACITY:
            $arrayData = $this->_readGraphCapacityThermal($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_CAPACITY_THERMAL);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            
            $arrayData = $this->_readGraphCapacityNuclear($uploadId);
            $graphData = $this->_prepareRecord($uploadId, $uploadType, self::GRAPH_CAPACITY_NUCLEAR);
            $graphData->graph_data = json_encode($arrayData);
            $graphData->save();            
            break;

        default:
            return false;
        }
        return true;
    }
    
    private function _uploadedFile($strTargetDate, $dataType, &$file)
    {
        $auth = $this->session->get('auth');
        $userId = $auth['user_id'];
       
        // ファイル名チェック
        if($dataType != self::DATA_ASP)
        {   // 2018/02/26
            // $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' File name: %s', array($file->getName()));
            // ファイル名から配信日付を取り出す
            $yyyymmdd = substr(substr($file->getName(), -12), 0, 8);
            if( ! preg_match('/^[0-9]+$/', $yyyymmdd) ) {
                $this->flash->error('ZIPファイル名から配信日が抽出できません。');
                return false;
            }
            $strTargetDate = substr($yyyymmdd, 0, 4) . '-' . substr($yyyymmdd, 4, 2) . '-' . substr($yyyymmdd, 6, 2);
            if( $strTargetDate != date('Y-m-d', strtotime($strTargetDate)) ) {
                $this->flash->error('ZIPファイル名の配信日が正しくありません。');
                return false;
            }
        }
        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' Target Date: %s, Data Type: %s', array($strTargetDate, $dataType));

        // 以前の Upload レコードを探す
        switch ($dataType) {
        case self::DATA_FORWARDMAIN:
        case self::DATA_FORWARDMAIN_E:  // 2016/05/17
        case self::DATA_FORWARDMAIN_W:
        case self::DATA_FORWARDMAIN_H:  // 2017/02/16
        case self::DATA_FORWARDMAIN_K:
        case self::DATA_FORWARDSUB:
        case self::DATA_FORWARDSUB_CIF:
        case self::DATA_HISTORICALSUB:  // 2016/01/31
            // 複数世代持つ 2015/12/25
            $oldUpload = Uploads::findFirst(array(
                        'conditions' => 'deleted=0 AND target_date = :targetDate: AND upload_type = :dataType:',
                        'bind' => ['targetDate' => $strTargetDate, 'dataType' => $dataType],
            ));
            if ($oldUpload === false) {
                $oldUploadId = null;
            } else {
                $oldUploadId = $oldUpload->id;
                $oldUpload->deleted = true;
                $oldUpload->save();
            }
            break;
        case self::DATA_RESIDUAL_LOAD:  // 2018/02/17
        case self::DATA_HYDRO_PUMP:
        case self::DATA_ASP:        // 2018/02/26
            // 残余需要と揚水のトランザクション、ASP には upload id を付与しない
            $oldUploadId = null;
            break;
        default:
            // １世代だけ持つ 2015/12/25
            $oldUpload = Uploads::findFirst(array(
                        'conditions' => 'deleted=0 AND upload_type = :dataType:',
                        'bind' => ['dataType' => $dataType],
            ));
            if ($oldUpload === false) {
                $oldUploadId = null;
            } else {
                $oldUploadId = $oldUpload->id;
                $oldUpload->deleted = true;
                $oldUpload->save();
            }
            break;
        }

        // Upload レコードを作る
        switch ($dataType) {
        case self::DATA_RESIDUAL_LOAD:  // 2018/02/17
        case self::DATA_HYDRO_PUMP:
        case self::DATA_ASP:        // 2018/02/26
            // 残余需要と揚水のトランザクション、ASP には upload id を付与しない
            $uploadId = null;
            break;
        default:
            $upload = new Uploads();
            $upload->user_id = $userId;
            $upload->target_date = $strTargetDate;
            $upload->upload_type = $dataType;
            $upload->create();
            $uploadId = $upload->id;
        }

        // Move the file into the application
        $tempFileName = 'temp/' . date('YmdHis') . $file->getName();
        $file->moveTo($tempFileName);
        $zip = new ZipArchive();
        $res = $zip->open($tempFileName);
        // if (!$res) {
        if ($res !== true) {    // 2022/03/16
            $this->flash->error('zip ファイルを開けません');
            return false;
        }
        switch ($dataType) {
            case self::DATA_FORWARDMAIN:
                $ret = $this->_forwardPower($zip, $uploadId, $oldUploadId, $yyyymmdd, "System");
                break;
            case self::DATA_FORWARDMAIN_E:
                $ret = $this->_forwardPower($zip, $uploadId, $oldUploadId, $yyyymmdd, "East");
                break;
            case self::DATA_FORWARDMAIN_W:
                $ret = $this->_forwardPower($zip, $uploadId, $oldUploadId, $yyyymmdd, "West");
                break;
            case self::DATA_FORWARDMAIN_H:      // 2017/02/16
                $ret = $this->_forwardPower($zip, $uploadId, $oldUploadId, $yyyymmdd, "Hokkaido");
                break;
            case self::DATA_FORWARDMAIN_K:
                $ret = $this->_forwardPower($zip, $uploadId, $oldUploadId, $yyyymmdd, "Kyushu");
                break;
            case self::DATA_FORWARDSUB:
                $ret = $this->_forwardFuel($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_FORWARDSUB_CIF:     // 2019/02/08
                $ret = $this->_forwardFuelCIF($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_HISTORICALMAIN:
                $ret = $this->_JEPX($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_HISTORICALSUB:
                $ret = $this->_CME($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_PREREQUISITE:
                $ret = $this->_prerequisite($zip, $uploadId, $oldUploadId, $yyyymmdd, "System");
                break;
            case self::DATA_PREREQUISITE_E:
                $ret = $this->_prerequisite($zip, $uploadId, $oldUploadId, $yyyymmdd, "East");
                break;
            case self::DATA_PREREQUISITE_W:
                $ret = $this->_prerequisite($zip, $uploadId, $oldUploadId, $yyyymmdd, "West");
                break;
            case self::DATA_PREREQUISITE_H:     // 2017/02/19
                $ret = $this->_prerequisite($zip, $uploadId, $oldUploadId, $yyyymmdd, "Hokkaido");
                break;
            case self::DATA_PREREQUISITE_K:
                $ret = $this->_prerequisite($zip, $uploadId, $oldUploadId, $yyyymmdd, "Kyushu");
                break;
            case self::DATA_HISTORICALDEMAND:     // 2016/03/17
                $ret = $this->_historicalDemand($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_CAPACITY:       // 2016/03/17
                $ret = $this->_capacity($zip, $uploadId, $oldUploadId, $yyyymmdd, "System");
                break;
            case self::DATA_CAPACITY_E:       // 2016/05/17
                $ret = $this->_capacity($zip, $uploadId, $oldUploadId, $yyyymmdd, "East");
                break;
            case self::DATA_CAPACITY_W:
                $ret = $this->_capacity($zip, $uploadId, $oldUploadId, $yyyymmdd, "West");
                break;
            case self::DATA_CAPACITY_H:     // 2017/02/19
                $ret = $this->_capacity($zip, $uploadId, $oldUploadId, $yyyymmdd, "Hokkaido");
                break;
            case self::DATA_CAPACITY_K:
                $ret = $this->_capacity($zip, $uploadId, $oldUploadId, $yyyymmdd, "Kyushu");
                break;
            case self::DATA_INTERCONNECT:
                $ret = $this->_interconnect($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Henkan');  // 2017/02/23
                break;
            case self::DATA_INTERCONNECT_H: 
                $ret = $this->_interconnect($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Kitahon');
                break;
            case self::DATA_INTERCONNECT_K:
                $ret = $this->_interconnect($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Kanmon');
                break;
            case self::DATA_EVENT:
                $ret = $this->_event($zip, $uploadId, $oldUploadId, $yyyymmdd);
                break;
            case self::DATA_JEPX_SHORT:
                $ret = $this->_JEPX_Short($zip, $uploadId, $oldUploadId, $yyyymmdd, 'System');
                break;
            case self::DATA_JEPX_SHORT_E:
                $ret = $this->_JEPX_Short($zip, $uploadId, $oldUploadId, $yyyymmdd, 'East');
                break;
            case self::DATA_JEPX_SHORT_W:
                $ret = $this->_JEPX_Short($zip, $uploadId, $oldUploadId, $yyyymmdd, 'West');
                break;
            case self::DATA_JEPX_SHORT_H:       // 2017/02/19
                $ret = $this->_JEPX_Short($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Hokkaido');
                break;
            case self::DATA_JEPX_SHORT_K:
                $ret = $this->_JEPX_Short($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Kyushu');
                break;
            case self::DATA_RESIDUAL_LOAD:      // 2018/02/17
                $ret = $this->_Residual_Load($zip, $yyyymmdd);
                break;
            case self::DATA_HYDRO_PUMP:
                $ret = $this->_Hydro_Pump($zip, $yyyymmdd);
                break;
            case self::DATA_ASP:        // 2018/02/26
                $ret = $this->_ASP($zip);
                break;
            // 2019/10/22
            case self::DATA_FWD_D_S_BALANCE:
                $ret = $this->_Fwd_D_S_Balance($zip, $uploadId, $oldUploadId, $yyyymmdd);
                $ret = $this->_Fwd_D_S_Balance($zip, $uploadId, $oldUploadId, $yyyymmdd, 'East');
                $ret = $this->_Fwd_D_S_Balance($zip, $uploadId, $oldUploadId, $yyyymmdd, 'West');
                $ret = $this->_Fwd_D_S_Balance($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Hokkaido');
                $ret = $this->_Fwd_D_S_Balance($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Kyushu');
                $ret = $this->_Fwd_Price_Distribution($zip, $uploadId, $oldUploadId, $yyyymmdd);
                $ret = $this->_Fwd_Price_Distribution($zip, $uploadId, $oldUploadId, $yyyymmdd, 'East');
                $ret = $this->_Fwd_Price_Distribution($zip, $uploadId, $oldUploadId, $yyyymmdd, 'West');
                $ret = $this->_Fwd_Price_Distribution($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Hokkaido');
                $ret = $this->_Fwd_Price_Distribution($zip, $uploadId, $oldUploadId, $yyyymmdd, 'Kyushu');
                break;
        }
        $zip->close();
        unlink($tempFileName);
        // $this->_graphData($uploadId, $dataType); 2016/04/18
        return $ret;
    }
    
    private function _readGraphForwardPowerHalfHourly($uploadId) {
        $half_hourly = ForwardMainHHours::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $half_hourly_data_list = array();
        $i = 0;
        foreach ($half_hourly as $data) {
            $half_hourly_data_list[$i]['fc_datetime'] = date('Y-m-d H:i', strtotime($data->fc_datetime));
            $half_hourly_data_list[$i]['price'] = $data->price;
            $i++;
        }
        return $half_hourly_data_list;
    }
    
    // 2016/03/17
    private function _readGraphForwardPowerHourly($uploadId) {
        $hourly = ForwardMainHours::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $hourly_data_list = array();
        $i = 0;
        foreach ($hourly as $data) {
            $hourly_data_list[$i]['dt'] = date('Y-m-d H:i', strtotime($data->dt));
            $hourly_data_list[$i]['pr'] = $data->pr;
            $i++;
        }
        return $hourly_data_list;
    }

    private function _readGraphForwardPowerDaily($uploadId) {
        $daily = ForwardMainDays::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $daily_data_list = array();
        $i = 0;
        foreach ($daily as $data) {
            $daily_data_list[$i]['fc_datetime'] = date('Y-m-d', strtotime($data->fc_datetime));
            $daily_data_list[$i]['price'] = $data->price;
            $i++;
        }
        return $daily_data_list;
    }
    
    private function _readGraphForwardPowerMonthly($uploadId) {
        $monthly = ForwardMainMonths::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $monthly_data_list = array();
        $i = 0;
        foreach ($monthly as $data) {
            $monthly_data_list[$i]['id'] = $data->id;
            $monthly_data_list[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $monthly_data_list[$i]['price_base'] = $data->price_base;
            $monthly_data_list[$i]['price_offpeak'] = $data->price_offpeak;
            $monthly_data_list[$i]['price_peak'] = $data->price_peak;
            $i++;
        }
        return $monthly_data_list;
    }
    
    private function _readGraphForwardFuelOil($uploadId) {
        $recs = ForwardSubOils::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphForwardFuelCoal($uploadId) {
        $recs = ForwardSubCoals::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphForwardFuelLNG($uploadId) {
        $recs = ForwardSubLngs::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }

    // >>> 2019/02/08 燃料CIF価格想定
    private function _readGraphForwardFuelCifOil($uploadId) {
        $recs = ForwardSubCifOils::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphForwardFuelCifCoal($uploadId) {
        $recs = ForwardSubCifCoals::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphForwardFuelCifLNG($uploadId) {
        $recs = ForwardSubCifLngs::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m', strtotime($data->fc_datetime));
            $arrayData[$i]['price'] = $data->price;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphJEPXSpot($uploadId) {
        $recs = HistoricalMainSpots::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['hst_datetime'] = date('Y-m-d H:i', strtotime($data->hst_datetime));
            $arrayData[$i]['sale'] = $data->sale;
            $arrayData[$i]['buy'] = $data->buy;
            $arrayData[$i]['contract'] = $data->contract;
            $arrayData[$i]['price_system'] = $data->price_system;
            $arrayData[$i]['price_area_01'] = $data->price_area_01;
            $arrayData[$i]['price_area_02'] = $data->price_area_02;
            $arrayData[$i]['price_area_03'] = $data->price_area_03;
            $arrayData[$i]['price_area_04'] = $data->price_area_04;
            $arrayData[$i]['price_area_05'] = $data->price_area_05;
            $arrayData[$i]['price_area_06'] = $data->price_area_06;
            $arrayData[$i]['price_area_07'] = $data->price_area_07;
            $arrayData[$i]['price_area_08'] = $data->price_area_08;
            $arrayData[$i]['price_area_09'] = $data->price_area_09;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphJEPXIndex($uploadId) {
        $recs = HistoricalMainIndexes::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['hst_datetime'] = date('Y-m-d', strtotime($data->hst_datetime));
            $arrayData[$i]['da_24'] = $data->da_24;
            $arrayData[$i]['da_dt'] = $data->da_dt;
            $arrayData[$i]['da_pt'] = $data->da_pt;
            $arrayData[$i]['ttv'] = $data->ttv;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphCME($uploadId) {
        $recs = HistoricalSubs::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['hst_datetime'] = date('Y-m-d', strtotime($data->hst_datetime));
            $arrayData[$i]['coal'] = $data->coal;
            $arrayData[$i]['oil'] = $data->oil;
            $arrayData[$i]['exchange'] = $data->exchange;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphPrerequisite($uploadId) {
        $recs = Prerequisites::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['fc_datetime'] = date('Y-m-d', strtotime($data->fc_datetime));
            $arrayData[$i]['load'] = $data->load;
            $arrayData[$i]['wind'] = $data->wind;
            $arrayData[$i]['solar'] = $data->solar;
            $arrayData[$i]['hydro'] = $data->hydro;     // 2016/03/17
            $arrayData[$i]['hydro_pump'] = $data->hydro_pump;
            $arrayData[$i]['reside_load'] = $data->reside_load;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphHistoricalDemand($uploadId) {
        $recs = HistoricalDemands::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['dt'] = date('Y-m-d', strtotime($data->dt));
            $arrayData[$i]['demand'] = $data->demand;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphCapacityThermal($uploadId) {
        $recs = CapacityThermals::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['dt'] = date('Y-m-d', strtotime($data->dt));
            $arrayData[$i]['coal'] = $data->coal;
            $arrayData[$i]['lng'] = $data->lng;
            $arrayData[$i]['oil'] = $data->oil;
            $i++;
        }
        return $arrayData;
    }
    
    private function _readGraphCapacityNuclear($uploadId) {
        $recs = CapacityNuclears::find(
                        array(
                            'upload_id=:upload_id:',
                            'bind' => array(
                                'upload_id' => $uploadId,
                            ),
                        )
        );
        $arrayData = array();
        $i = 0;
        foreach ($recs as $data) {
            $arrayData[$i]['dt'] = date('Y-m-d', strtotime($data->dt));
            $arrayData[$i]['nuclear'] = $data->nuclear;
            $i++;
        }
        return $arrayData;
    }
    
    private function _prepareRecord($uploadId, $uploadType, $graphType) {
        $graphData = GraphData::findFirst(
                        array(
                            '(upload_id=:upload_id:) AND (graph_type=:graph_type:)',
                            'bind' => array(
                                'upload_id' => $uploadId,
                                'graph_type' => $graphType,
                            ),
                        )
                );
        if($graphData == false) {
            $graphData = new GraphData();
            $graphData->id = null;
            $graphData->upload_id = $uploadId;
            $graphData->upload_type = $uploadType;
            $graphData->graph_type = $graphType;
        }
        return $graphData;
    }

    public function initialize()
    {
        // $this->tag->setTitle('アップロード');
        // $this->view->pageTitle = 'アップロード';
        parent::initialize();

        // 権限の設定
        $auth = $this->session->get('auth');
        $this->view->setVars(
                array(
                    'email' => $auth['user_id'],
                    'role' => $auth['role']
                )
        );

        // メニューをアクティブにする
        $this->view->setVars(
                array(
                    'active_apploafd' => 'active'
                )
        );
    }

    public function indexAction()
    {
        // フォワードカーブ・メインの画面
        return $this->response->redirect('upload/forwardPower');
    }
    
    // 2016/03/01 新しいアップロード画面
    public function anyAction()
    {
        $form = new UploadAnyForm();
        if ($this->request->isPost()) {
            $post = $this->request->getPost();
            
            if( ! $form->isValid($post) ) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
                return $this->response->redirect('upload/any');
            }
            
        }
        
        $this->view->form = $form;
    }

    // フォワードカーブ・メインの画面
    public function forwardPowerAction()
    {
        $this->view->description = '電力フォーワード';
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_FORWARDMAIN;
        $this->view->pick('upload/index');
    }

    // フォワードカーブ・サブの画面
    public function forwardFuelAction()
    {
        // $this->view->description = '燃料フォワード';
        $this->view->description = '燃料炉前価格想定';      // 2019/02/08
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_FORWARDSUB;
        $this->view->pick('upload/index');
    }

    // 2019/02/08 燃料CIF価格想定画面
    public function forwardFuelCifAction()
    {
        $this->view->description = '燃料CIF価格想定';
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_FORWARDSUB_CIF;
        $this->view->pick('upload/index');
    }

    // ヒストリカルデータ・メインの画面
    public function jepxAction()
    {
        $this->view->description = 'JEPX';
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_HISTORICALMAIN;
        $this->view->pick('upload/index');
    }

    // ヒストリカルデータ・メインの画面
    public function cmeAction()
    {
        $this->view->description = 'CME';
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_HISTORICALSUB;
        $this->view->pick('upload/index');
    }

    // 前提の画面
    public function prerequisiteAction()
    {
        $this->view->description = '需要・再エネ';  // 2016/01/27
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_PREREQUISITE;
        $this->view->pick('upload/index');
    }

    // 需要実績画面 2016/03/17
    public function historicaldemandAction()
    {
        $this->view->description = '需要実績';  // 2016/01/27
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_HISTORICALDEMAND;
        $this->view->pick('upload/index');
    }

    // 供給力画面 2016/03/17
    public function capacityAction()
    {
        $this->view->description = '供給力';  // 2016/01/27
        $this->view->targetDate = date('Y-m-d');
        $this->view->datatype = self::DATA_CAPACITY;
        $this->view->pick('upload/index');
    }

    // アップロードファイルの処理
    public function uploadAction()
    {
        // set_time_limit(600);    // 2018/02/17, 2017/02/23, 2016/03/17
        set_time_limit(1200);    // 2018/10/21
        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, __CLASS__ . ' ' . __FUNCTION__ . ' start', array());
        
        $dataType = $this->request->getPost("dataType");
        $targetDate = $this->request->getPost("targetDate");

        if ($this->request->hasFiles() == true) {
            $this->db->begin();
            try {
                foreach ($this->request->getUploadedFiles() as $file) {
                    if( ! $this->_uploadedFile($targetDate, $dataType, $file) ) {
                        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_UPLOAD, array($file->getName(), 'Fail'));
                        $this->db->rollback();
                        // return $next;
                        return $this->response->redirect('upload/any'); // 2016/03/27
                    }
                    $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_OPR, MyLogs::LOG_MSG_OPR_UPLOAD, array($file->getName(), 'Done'));
                    $this->flash->success($file->getName() . ' をアップロードしました。');
                }
                $this->db->commit();
                $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, MyLogs::LOG_MSG_OPR_UPLOAD, array($file->getName(), 'Commited'));   // 2018/10/21
            } catch (Exception $e) {
                $this->db->rollback();
                $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_ERROR, __CLASS__ . ' ' . __FUNCTION__ . ' error on %s ', array($e->getMessage()));
                // throw $e;
            }
            // return $next;
            return $this->response->redirect('upload/any'); // 2016/03/27
        }
        
        $this->_MyLog->WriteLog(MyLogs::LOG_TYPE_DEBUG, __CLASS__ . ' ' . __FUNCTION__ . ' end', array());
        return $this->response->redirect('/');
    }

    public function graphDataAction($uploadId) {
        $this->view->disable();
        
        $upload = Uploads::findFirst($uploadId);
        if($upload == false || $upload->deleted) {
            return false;
        }
        
        $this->_graphData($uploadId, $upload->upload_type);
        return true;
    }
}
