<?php

// 2019/10/31
class dspriceController extends ControllerBase
{
    const MIN_PRICE = '0.0001';
    
    protected function _enable($auth_bit)
    {
        $ret = (
                    $auth_bit & 
                    (
                        $this->authority['FWD_DEMAND_SUPPLY_BALANCE']
                    )
                );
        return $ret;
    }
    
    protected function _findUpload()
    {
        $upload = Uploads::findFirst(
                        array(
                            'deleted=0 AND upload_type=:type:',
                            'bind' => array(
                                'type' => UploadController::DATA_FWD_D_S_BALANCE,
                            ),
                        )
        );
        return $upload;
    }

    protected function _loadDSBalance(&$rec)
    {
        $ds_data_list = [];
        $i = 0;
        foreach ($rec as $data) {
            $ds_data_list[$i]['fc_datetime'] = date('Y/m/d H:i:s', strtotime($data->fc_datetime));
            $ds_data_list[$i]['d_max'] = $data->d_max;
            $ds_data_list[$i]['d_min'] = $data->d_min;
            $ds_data_list[$i]['d_mean'] = $data->d_mean;
            $ds_data_list[$i]['s_nuclear'] = $data->s_nuclear;
            $ds_data_list[$i]['s_coal_usc'] = $data->s_coal_usc;
            $ds_data_list[$i]['s_coal_sc'] = $data->s_coal_sc;
            $ds_data_list[$i]['s_coal_misc'] = $data->s_coal_misc;
            $ds_data_list[$i]['s_lng_macc2'] = $data->s_lng_macc2;
            $ds_data_list[$i]['s_lng_macc'] = $data->s_lng_macc;
            $ds_data_list[$i]['s_lng_acc'] = $data->s_lng_acc;
            $ds_data_list[$i]['s_lng_cc'] = $data->s_lng_cc;
            $ds_data_list[$i]['s_lng_misc'] = $data->s_lng_misc;
            $ds_data_list[$i]['s_oil'] = $data->s_oil;
            $i++;
        }
        return $ds_data_list;
    }
    
    protected function _legendDates($strTargetDate)
    {
        $dtTarget = strtotime($strTargetDate);
        // 2020/02/12
        $strDateFormat = ($this->session->has(self::FLG_LANGOVERRIDE)) ? 'M d, Y' : 'Y/m/d';
        /*
        $strWeekDates[] = date('Y/m/d', strtotime('+9 day', $dtTarget));
        $strWeekDates[] = date('Y/m/d', strtotime('+15 day', $dtTarget));
        $strWeekDates[] = date('Y/m/d', strtotime('+16 day', $dtTarget));
        $strWeekDates[] = date('Y/m/d', strtotime('+22 day', $dtTarget));
        $strWeekDates[] = date('Y/m/d', strtotime('+23 day', $dtTarget));
        $strWeekDates[] = date('Y/m/d', strtotime('+29 day', $dtTarget));
         * 
         */
        $strWeekDates[] = date($strDateFormat, strtotime('+9 day', $dtTarget));
        $strWeekDates[] = date($strDateFormat, strtotime('+15 day', $dtTarget));
        $strWeekDates[] = date($strDateFormat, strtotime('+16 day', $dtTarget));
        $strWeekDates[] = date($strDateFormat, strtotime('+22 day', $dtTarget));
        $strWeekDates[] = date($strDateFormat, strtotime('+23 day', $dtTarget));
        $strWeekDates[] = date($strDateFormat, strtotime('+29 day', $dtTarget));
        return $strWeekDates;
    }
    
    // 集計
    protected function _summaryData($price_data)
    {
        // 初期化
        $w = [
            '5percents' => null,
            '25percents' => null,
            '50percents' => null,
            '75percents' => null,
            '95percents' => null,
            'mode' => null,
            'average' => null,
            ];
        
        $cAry = [
            'w1_24h' => $w,
            'w1_0818' => $w,
            'w2_24h' => $w,
            'w2_0818' => $w,
            'w3_24h' => $w,
            'w3_0818' => $w,
            ];
        
        $ttl = [
            'w1_24h' => 0,
            'w1_0818' => 0,
            'w2_24h' => 0,
            'w2_0818' => 0,
            'w3_24h' => 0,
            'w3_0818' => 0,
            ];
        
        foreach ($price_data as $data) {
            $ttl['w1_24h'] = $ttl['w1_24h'] + ($data->w1_24h / 100);
            $ttl['w1_0818'] = $ttl['w1_0818'] + ($data->w1_0818 / 100);
            $ttl['w2_24h'] = $ttl['w2_24h'] + ($data->w2_24h / 100);
            $ttl['w2_0818'] = $ttl['w2_0818'] + ($data->w2_0818 / 100);
            $ttl['w3_24h'] = $ttl['w3_24h'] + ($data->w3_24h / 100);
            $ttl['w3_0818'] = $ttl['w3_0818'] + ($data->w3_0818 / 100);

            if($cAry['w1_24h']['5percents'] === null && $ttl['w1_24h'] >= 0.05) {$cAry['w1_24h']['5percents'] = number_format($data->price, 2);}
            if($cAry['w1_24h']['25percents'] === null && $ttl['w1_24h'] >= 0.25) {$cAry['w1_24h']['25percents'] = number_format($data->price, 2);}
            if($cAry['w1_24h']['50percents'] === null && $ttl['w1_24h'] >= 0.50) {$cAry['w1_24h']['50percents'] = number_format($data->price, 2);}
            if($cAry['w1_24h']['75percents'] === null && $ttl['w1_24h'] >= 0.75) {$cAry['w1_24h']['75percents'] = number_format($data->price, 2);}
            if($cAry['w1_24h']['95percents'] === null && $ttl['w1_24h'] >= 0.95) {$cAry['w1_24h']['95percents'] = number_format($data->price, 2);}
            
            if($cAry['w1_0818']['5percents'] === null && $ttl['w1_0818'] >= 0.05) {$cAry['w1_0818']['5percents'] = number_format($data->price, 2);}
            if($cAry['w1_0818']['25percents'] === null && $ttl['w1_0818'] >= 0.25) {$cAry['w1_0818']['25percents'] = number_format($data->price, 2);}
            if($cAry['w1_0818']['50percents'] === null && $ttl['w1_0818'] >= 0.50) {$cAry['w1_0818']['50percents'] = number_format($data->price, 2);}
            if($cAry['w1_0818']['75percents'] === null && $ttl['w1_0818'] >= 0.75) {$cAry['w1_0818']['75percents'] = number_format($data->price, 2);}
            if($cAry['w1_0818']['95percents'] === null && $ttl['w1_0818'] >= 0.95) {$cAry['w1_0818']['95percents'] = number_format($data->price, 2);}
            
            if($cAry['w2_24h']['5percents'] === null && $ttl['w2_24h'] >= 0.05) {$cAry['w2_24h']['5percents'] = number_format($data->price, 2);}
            if($cAry['w2_24h']['25percents'] === null && $ttl['w2_24h'] >= 0.25) {$cAry['w2_24h']['25percents'] = number_format($data->price, 2);}
            if($cAry['w2_24h']['50percents'] === null && $ttl['w2_24h'] >= 0.50) {$cAry['w2_24h']['50percents'] = number_format($data->price, 2);}
            if($cAry['w2_24h']['75percents'] === null && $ttl['w2_24h'] >= 0.75) {$cAry['w2_24h']['75percents'] = number_format($data->price, 2);}
            if($cAry['w2_24h']['95percents'] === null && $ttl['w2_24h'] >= 0.95) {$cAry['w2_24h']['95percents'] = number_format($data->price, 2);}
            
            if($cAry['w2_0818']['5percents'] === null && $ttl['w2_0818'] >= 0.05) {$cAry['w2_0818']['5percents'] = number_format($data->price, 2);}
            if($cAry['w2_0818']['25percents'] === null && $ttl['w2_0818'] >= 0.25) {$cAry['w2_0818']['25percents'] = number_format($data->price, 2);}
            if($cAry['w2_0818']['50percents'] === null && $ttl['w2_0818'] >= 0.50) {$cAry['w2_0818']['50percents'] = number_format($data->price, 2);}
            if($cAry['w2_0818']['75percents'] === null && $ttl['w2_0818'] >= 0.75) {$cAry['w2_0818']['75percents'] = number_format($data->price, 2);}
            if($cAry['w2_0818']['95percents'] === null && $ttl['w2_0818'] >= 0.95) {$cAry['w2_0818']['95percents'] = number_format($data->price, 2);}
            
            if($cAry['w3_24h']['5percents'] === null && $ttl['w3_24h'] >= 0.05) {$cAry['w3_24h']['5percents'] = number_format($data->price, 2);}
            if($cAry['w3_24h']['25percents'] === null && $ttl['w3_24h'] >= 0.25) {$cAry['w3_24h']['25percents'] = number_format($data->price, 2);}
            if($cAry['w3_24h']['50percents'] === null && $ttl['w3_24h'] >= 0.50) {$cAry['w3_24h']['50percents'] = number_format($data->price, 2);}
            if($cAry['w3_24h']['75percents'] === null && $ttl['w3_24h'] >= 0.75) {$cAry['w3_24h']['75percents'] = number_format($data->price, 2);}
            if($cAry['w3_24h']['95percents'] === null && $ttl['w3_24h'] >= 0.95) {$cAry['w3_24h']['95percents'] = number_format($data->price, 2);}
            
            if($cAry['w3_0818']['5percents'] === null && $ttl['w3_0818'] >= 0.05) {$cAry['w3_0818']['5percents'] = number_format($data->price, 2);}
            if($cAry['w3_0818']['25percents'] === null && $ttl['w3_0818'] >= 0.25) {$cAry['w3_0818']['25percents'] = number_format($data->price, 2);}
            if($cAry['w3_0818']['50percents'] === null && $ttl['w3_0818'] >= 0.50) {$cAry['w3_0818']['50percents'] = number_format($data->price, 2);}
            if($cAry['w3_0818']['75percents'] === null && $ttl['w3_0818'] >= 0.75) {$cAry['w3_0818']['75percents'] = number_format($data->price, 2);}
            if($cAry['w3_0818']['95percents'] === null && $ttl['w3_0818'] >= 0.95) {$cAry['w3_0818']['95percents'] = number_format($data->price, 2);}
        }
        
        return $cAry;
    }

    public function initialize()
    {
        $this->tag->setTitle('MRI Power Index');
        parent::initialize();
    }

    public function indexAction()
    {
        $this->view->en = '/dsprice/en';   // 英語ページへのリンク 2020/01/28
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
        if($this->_enable($auth_bits) == 0)
        {
            return $this->response->redirect($this->session->has(self::FLG_LANGOVERRIDE) ? '/dsprice/reme' : '/dsprice/rem');   // 2020/02/26
        }

        // データの取得 需要供給
        $upload = $this->_findUpload();
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $ds_upload_date = date('Y年m月d日', strtotime($upload->target_date));

        $ds_data = DSBalances::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $ds_data_list = $this->_loadDSBalance($ds_data);
        
        // 需要と供給の最大値
        $s_max = DSBalances::maximum(
                [
                    'column' => 's_nuclear+s_coal_usc+s_coal_sc+s_coal_misc+s_lng_macc2+s_lng_macc+s_lng_acc+s_lng_misc+s_oil+s_lng_cc',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $s_max = ceil($s_max / 1000) * 1000;
        $d_max = DSBalances::maximum(
                [
                    'column' => 'd_max',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $d_max = ceil($d_max / 1000) * 1000;
        
        // 価格予測
        $strWeekDates = $this->_legendDates($upload->target_date);

        // 条件を満たす価格の範囲
        $price_low = PriceDistributions::minimum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );
        $price_high = PriceDistributions::maximum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );

        //$price_low = $price_low ? floor($price_low - 2) : 0;
        if($price_low >= 2)
        {
             $price_low = floor($price_low - 2);
        }
        elseif($price_low >= 1)
        {
             $price_low = 1;
        }
        else
        {
             $price_low = 0;
        }

        $price_high = $price_high ? ceil($price_high + 2) : 25.0;

        $price_data = PriceDistributions::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>=:Low:) AND (price<=:High:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'Low' => $price_low,
                                'High' => $price_high,
                            ),
                            'order' => 'price',
                        )
        );
        $price_data_list = [];
        $i = 0;
        foreach ($price_data as $data) {
            // >>> グラフ描画最小値 $price_low のレコードが無い場合
            if(($i == 0) && ($data->price > $price_low))
            {
                $price_data_list[$i]['price'] = number_format($price_low, 2);
                $price_data_list[$i]['w1_24h'] = 0;
                $price_data_list[$i]['w1_0818'] = 0;
                $price_data_list[$i]['w1_0820'] = 0;
                $price_data_list[$i]['w1_0822'] = 0;
                $price_data_list[$i]['w2_24h'] = 0;
                $price_data_list[$i]['w2_0818'] = 0;
                $price_data_list[$i]['w2_0820'] = 0;
                $price_data_list[$i]['w2_0822'] = 0;
                $price_data_list[$i]['w3_24h'] = 0;
                $price_data_list[$i]['w3_0818'] = 0;
                $price_data_list[$i]['w3_0820'] = 0;
                $price_data_list[$i]['w3_0822'] = 0;
                $i++;
            }
            // <<<

            $price_data_list[$i]['price'] = number_format($data->price, 2);
            $price_data_list[$i]['w1_24h'] = $data->w1_24h;
            $price_data_list[$i]['w1_0818'] = $data->w1_0818;
            $price_data_list[$i]['w1_0820'] = $data->w1_0820;
            $price_data_list[$i]['w1_0822'] = $data->w1_0822;
            $price_data_list[$i]['w2_24h'] = $data->w2_24h;
            $price_data_list[$i]['w2_0818'] = $data->w2_0818;
            $price_data_list[$i]['w2_0820'] = $data->w2_0820;
            $price_data_list[$i]['w2_0822'] = $data->w2_0822;
            $price_data_list[$i]['w3_24h'] = $data->w3_24h;
            $price_data_list[$i]['w3_0818'] = $data->w3_0818;
            $price_data_list[$i]['w3_0820'] = $data->w3_0820;
            $price_data_list[$i]['w3_0822'] = $data->w3_0822;
            $i++;
        }

        // 集計
        $price_data = PriceDistributions::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'price',
                        )
        );
        $cAry = $this->_summaryData($price_data);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w1_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w1_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w2_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w2_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w3_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributions::sum(
                        array(
                            'column' => 'w3_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_0818']['average'] = number_format($price_data / 100, 2);

        // 最頻値
        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w1_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w1_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w2_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w2_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w3_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributions::maximum(
                        array(
                            'column' => 'w3_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributions::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_0818']['mode'] = number_format($price_data->price, 2);

        $weeklyExists = PriceDistributions::existWeekly();    // 2020/02/26
        
        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_dsprice.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_dsprice.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_dsprice' => 'active',
                    'ds_data_list' => $ds_data_list,
                    'ds_max' => max([$s_max, $d_max]),
                    'price_data_list' => $price_data_list,
                    'price_low' => $price_low,
                    'price_high' => $price_high,
                    'ds_upload_date' => $ds_upload_date,
                    'week_dates' => $strWeekDates,
                    'cary' => $cAry,
                    'export_date' => date('Ymd', strtotime($upload->target_date)),
                    'filename_area' => '_System',
                    'series_name' => '',
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'weekly_exists' => $weeklyExists,   // 2020/02/26
                    'dict' => "{'確率密度':'確率密度','ダウンロード':'ダウンロード'"
                    . ",'24時間平均':'24時間平均'"
                    . ",'平日8-18時平均':'平日8-18時平均'"
                    . ",'価格（円/kWh）':'価格（円/kWh）'"
                    . ",'需要・供給(MW)':'需要・供給(MW)'"
                    . ",'原子力':'原子力'"
                    . ",'石炭_USC':'石炭_USC'"
                    . ",'石炭_SC':'石炭_SC'"
                    . ",'石炭_その他':'石炭_その他'"
                    . ",'LNG_その他':'LNG_その他'"
                    . ",'石油':'石油'"
                    . ",'残余需要（最大）':'残余需要（最大）'"
                    . ",'残余需要（最小）':'残余需要（最小）'"
                    . ",'残余需要（平均）':'残余需要（平均）'"
                    . "}",
                )
        );
    }

    public function eAction()
    {
        $this->view->en = '/dsprice/ee';   // 英語ページへのリンク 2020/01/28
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
        if($this->_enable($auth_bits) == 0)
        {
            return $this->response->redirect($this->session->has(self::FLG_LANGOVERRIDE) ? '/dsprice/reme' : '/dsprice/rem');   // 2020/02/26
        }

        // データの取得 需要供給
        $upload = $this->_findUpload();
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $ds_upload_date = date('Y年m月d日', strtotime($upload->target_date));

        $ds_data = DSBalancesEast::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $ds_data_list = $this->_loadDSBalance($ds_data);
        
        // 需要と供給の最大値
        $s_max = DSBalancesEast::maximum(
                [
                    'column' => 's_nuclear+s_coal_usc+s_coal_sc+s_coal_misc+s_lng_macc2+s_lng_macc+s_lng_acc+s_lng_misc+s_oil+s_lng_cc',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $s_max = ceil($s_max / 1000) * 1000;
        $d_max = DSBalancesEast::maximum(
                [
                    'column' => 'd_max',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $d_max = ceil($d_max / 1000) * 1000;
        
        // 価格予測
        $strWeekDates = $this->_legendDates($upload->target_date);
        
        // 条件を満たす価格の範囲
        $price_low = PriceDistributionsEast::minimum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );
        $price_high = PriceDistributionsEast::maximum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );

        //$price_low = $price_low ? floor($price_low - 2) : 0;
        if($price_low >= 2)
        {
             $price_low = floor($price_low - 2);
        }
        elseif($price_low >= 1)
        {
             $price_low = 1;
        }
        else
        {
             $price_low = 0;
        }

        $price_high = $price_high ? ceil($price_high + 2) : 25.0;

        $price_data = PriceDistributionsEast::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>=:Low:) AND (price<=:High:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'Low' => $price_low,
                                'High' => $price_high,
                            ),
                        )
        );
        $price_data_list = [];
        $i = 0;
        foreach ($price_data as $data) {
            // >>> グラフ描画最小値 $price_low のレコードが無い場合
            if(($i == 0) && ($data->price > $price_low))
            {
                $price_data_list[$i]['price'] = number_format($price_low, 2);
                $price_data_list[$i]['w1_24h'] = 0;
                $price_data_list[$i]['w1_0818'] = 0;
                $price_data_list[$i]['w1_0820'] = 0;
                $price_data_list[$i]['w1_0822'] = 0;
                $price_data_list[$i]['w2_24h'] = 0;
                $price_data_list[$i]['w2_0818'] = 0;
                $price_data_list[$i]['w2_0820'] = 0;
                $price_data_list[$i]['w2_0822'] = 0;
                $price_data_list[$i]['w3_24h'] = 0;
                $price_data_list[$i]['w3_0818'] = 0;
                $price_data_list[$i]['w3_0820'] = 0;
                $price_data_list[$i]['w3_0822'] = 0;
                $i++;
            }
            // <<<

            $price_data_list[$i]['price'] = number_format($data->price, 2);
            $price_data_list[$i]['w1_24h'] = $data->w1_24h;
            $price_data_list[$i]['w1_0818'] = $data->w1_0818;
            $price_data_list[$i]['w1_0820'] = $data->w1_0820;
            $price_data_list[$i]['w1_0822'] = $data->w1_0822;
            $price_data_list[$i]['w2_24h'] = $data->w2_24h;
            $price_data_list[$i]['w2_0818'] = $data->w2_0818;
            $price_data_list[$i]['w2_0820'] = $data->w2_0820;
            $price_data_list[$i]['w2_0822'] = $data->w2_0822;
            $price_data_list[$i]['w3_24h'] = $data->w3_24h;
            $price_data_list[$i]['w3_0818'] = $data->w3_0818;
            $price_data_list[$i]['w3_0820'] = $data->w3_0820;
            $price_data_list[$i]['w3_0822'] = $data->w3_0822;
            $i++;
        }

        // 集計
        $price_data = PriceDistributionsEast::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'price',
                        )
        );
        $cAry = $this->_summaryData($price_data);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w1_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w1_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w2_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w2_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w3_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsEast::sum(
                        array(
                            'column' => 'w3_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_0818']['average'] = number_format($price_data / 100, 2);

        // 最頻値
        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w1_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w1_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w2_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w2_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w3_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsEast::maximum(
                        array(
                            'column' => 'w3_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsEast::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_0818']['mode'] = number_format($price_data->price, 2);

        $weeklyExists = PriceDistributionsEast::existWeekly();    // 2020/02/26

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_dsprice.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_dsprice.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_dsprice' => 'active',
                    'ds_data_list' => $ds_data_list,
                    'ds_max' => max([$s_max, $d_max]),
                    'price_data_list' => $price_data_list,
                    'price_low' => $price_low,
                    'price_high' => $price_high,
                    'ds_upload_date' => $ds_upload_date,
                    'week_dates' => $strWeekDates,
                    'cary' => $cAry,
                    'export_date' => date('Ymd', strtotime($upload->target_date)),
                    'filename_area' => '_East',
                    'series_name' => '',
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'weekly_exists' => $weeklyExists,   // 2020/02/26
                    'dict' => "{'確率密度':'確率密度','ダウンロード':'ダウンロード'"
                    . ",'24時間平均':'24時間平均'"
                    . ",'平日8-18時平均':'平日8-18時平均'"
                    . ",'価格（円/kWh）':'価格（円/kWh）'"
                    . ",'需要・供給(MW)':'需要・供給(MW)'"
                    . ",'原子力':'原子力'"
                    . ",'石炭_USC':'石炭_USC'"
                    . ",'石炭_SC':'石炭_SC'"
                    . ",'石炭_その他':'石炭_その他'"
                    . ",'LNG_その他':'LNG_その他'"
                    . ",'石油':'石油'"
                    . ",'残余需要（最大）':'残余需要（最大）'"
                    . ",'残余需要（最小）':'残余需要（最小）'"
                    . ",'残余需要（平均）':'残余需要（平均）'"
                    . "}",
                )
        );
    }

    public function wAction()
    {
        $this->view->en = '/dsprice/we';   // 英語ページへのリンク 2020/01/28
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
        if($this->_enable($auth_bits) == 0)
        {
            return $this->response->redirect($this->session->has(self::FLG_LANGOVERRIDE) ? '/dsprice/reme' : '/dsprice/rem');   // 2020/02/26
        }

        // データの取得 需要供給
        $upload = $this->_findUpload();
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $ds_upload_date = date('Y年m月d日', strtotime($upload->target_date));

        $ds_data = DSBalancesWest::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $ds_data_list = $this->_loadDSBalance($ds_data);
        
        // 需要と供給の最大値
        $s_max = DSBalancesWest::maximum(
                [
                    'column' => 's_nuclear+s_coal_usc+s_coal_sc+s_coal_misc+s_lng_macc2+s_lng_macc+s_lng_acc+s_lng_misc+s_oil+s_lng_cc',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $s_max = ceil($s_max / 1000) * 1000;
        $d_max = DSBalancesWest::maximum(
                [
                    'column' => 'd_max',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $d_max = ceil($d_max / 1000) * 1000;
        
        // 価格予測
        $strWeekDates = $this->_legendDates($upload->target_date);
        
        // 条件を満たす価格の範囲
        $price_low = PriceDistributionsWest::minimum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );
        $price_high = PriceDistributionsWest::maximum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );

        //$price_low = $price_low ? floor($price_low - 2) : 0;
        if($price_low >= 2)
        {
             $price_low = floor($price_low - 2);
        }
        elseif($price_low >= 1)
        {
             $price_low = 1;
        }
        else
        {
             $price_low = 0;
        }

        $price_high = $price_high ? ceil($price_high + 2) : 25.0;

        $price_data = PriceDistributionsWest::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>=:Low:) AND (price<=:High:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'Low' => $price_low,
                                'High' => $price_high,
                            ),
                        )
        );
        $price_data_list = [];
        $i = 0;
        foreach ($price_data as $data) {
            // >>> グラフ描画最小値 $price_low のレコードが無い場合
            if(($i == 0) && ($data->price > $price_low))
            {
                $price_data_list[$i]['price'] = number_format($price_low, 2);
                $price_data_list[$i]['w1_24h'] = 0;
                $price_data_list[$i]['w1_0818'] = 0;
                $price_data_list[$i]['w1_0820'] = 0;
                $price_data_list[$i]['w1_0822'] = 0;
                $price_data_list[$i]['w2_24h'] = 0;
                $price_data_list[$i]['w2_0818'] = 0;
                $price_data_list[$i]['w2_0820'] = 0;
                $price_data_list[$i]['w2_0822'] = 0;
                $price_data_list[$i]['w3_24h'] = 0;
                $price_data_list[$i]['w3_0818'] = 0;
                $price_data_list[$i]['w3_0820'] = 0;
                $price_data_list[$i]['w3_0822'] = 0;
                $i++;
            }
            // <<<

            $price_data_list[$i]['price'] = number_format($data->price, 2);
            $price_data_list[$i]['w1_24h'] = $data->w1_24h;
            $price_data_list[$i]['w1_0818'] = $data->w1_0818;
            $price_data_list[$i]['w1_0820'] = $data->w1_0820;
            $price_data_list[$i]['w1_0822'] = $data->w1_0822;
            $price_data_list[$i]['w2_24h'] = $data->w2_24h;
            $price_data_list[$i]['w2_0818'] = $data->w2_0818;
            $price_data_list[$i]['w2_0820'] = $data->w2_0820;
            $price_data_list[$i]['w2_0822'] = $data->w2_0822;
            $price_data_list[$i]['w3_24h'] = $data->w3_24h;
            $price_data_list[$i]['w3_0818'] = $data->w3_0818;
            $price_data_list[$i]['w3_0820'] = $data->w3_0820;
            $price_data_list[$i]['w3_0822'] = $data->w3_0822;
            $i++;
        }

        // 集計
        $price_data = PriceDistributionsWest::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'price',
                        )
        );
        $cAry = $this->_summaryData($price_data);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w1_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w1_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w2_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w2_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w3_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsWest::sum(
                        array(
                            'column' => 'w3_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_0818']['average'] = number_format($price_data / 100, 2);

        // 最頻値
        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w1_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w1_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w2_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w2_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w3_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsWest::maximum(
                        array(
                            'column' => 'w3_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsWest::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_0818']['mode'] = number_format($price_data->price, 2);

        $weeklyExists = PriceDistributionsWest::existWeekly();    // 2020/02/26

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_dsprice.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_dsprice.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_dsprice' => 'active',
                    'ds_data_list' => $ds_data_list,
                    'ds_max' => max([$s_max, $d_max]),
                    'price_data_list' => $price_data_list,
                    'price_low' => $price_low,
                    'price_high' => $price_high,
                    'ds_upload_date' => $ds_upload_date,
                    'week_dates' => $strWeekDates,
                    'cary' => $cAry,
                    'export_date' => date('Ymd', strtotime($upload->target_date)),
                    'filename_area' => '_West',
                    'series_name' => '',
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'weekly_exists' => $weeklyExists,   // 2020/02/26
                    'dict' => "{'確率密度':'確率密度','ダウンロード':'ダウンロード'"
                    . ",'24時間平均':'24時間平均'"
                    . ",'平日8-18時平均':'平日8-18時平均'"
                    . ",'価格（円/kWh）':'価格（円/kWh）'"
                    . ",'需要・供給(MW)':'需要・供給(MW)'"
                    . ",'原子力':'原子力'"
                    . ",'石炭_USC':'石炭_USC'"
                    . ",'石炭_SC':'石炭_SC'"
                    . ",'石炭_その他':'石炭_その他'"
                    . ",'LNG_その他':'LNG_その他'"
                    . ",'石油':'石油'"
                    . ",'残余需要（最大）':'残余需要（最大）'"
                    . ",'残余需要（最小）':'残余需要（最小）'"
                    . ",'残余需要（平均）':'残余需要（平均）'"
                    . "}",
                )
        );
    }

    public function hAction()
    {
        $this->view->en = '/dsprice/he';   // 英語ページへのリンク 2020/01/28
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
        if($this->_enable($auth_bits) == 0)
        {
            return $this->response->redirect($this->session->has(self::FLG_LANGOVERRIDE) ? '/dsprice/reme' : '/dsprice/rem');   // 2020/02/26
        }

        // データの取得 需要供給
        $upload = $this->_findUpload();
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $ds_upload_date = date('Y年m月d日', strtotime($upload->target_date));

        $ds_data = DSBalancesHokkaido::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $ds_data_list = $this->_loadDSBalance($ds_data);
        
        // 需要と供給の最大値
        $s_max = DSBalancesHokkaido::maximum(
                [
                    'column' => 's_nuclear+s_coal_usc+s_coal_sc+s_coal_misc+s_lng_macc2+s_lng_macc+s_lng_acc+s_lng_misc+s_oil+s_lng_cc',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $s_max = ceil($s_max / 100) * 100;
        $d_max = DSBalancesHokkaido::maximum(
                [
                    'column' => 'd_max',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $d_max = ceil($d_max / 100) * 100;
        
        // 価格予測
        $strWeekDates = $this->_legendDates($upload->target_date);
        
        // 条件を満たす価格の範囲
        $price_low = PriceDistributionsHokkaido::minimum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );
        $price_high = PriceDistributionsHokkaido::maximum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );

        //$price_low = $price_low ? floor($price_low - 2) : 0;
        if($price_low >= 2)
        {
             $price_low = floor($price_low - 2);
        }
        elseif($price_low >= 1)
        {
             $price_low = 1;
        }
        else
        {
             $price_low = 0;
        }

        $price_high = $price_high ? ceil($price_high + 2) : 25.0;

        $price_data = PriceDistributionsHokkaido::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>=:Low:) AND (price<=:High:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'Low' => $price_low,
                                'High' => $price_high,
                            ),
                        )
        );
        $price_data_list = [];
        $i = 0;
        foreach ($price_data as $data) {
            // >>> グラフ描画最小値 $price_low のレコードが無い場合
            if(($i == 0) && ($data->price > $price_low))
            {
                $price_data_list[$i]['price'] = number_format($price_low, 2);
                $price_data_list[$i]['w1_24h'] = 0;
                $price_data_list[$i]['w1_0818'] = 0;
                $price_data_list[$i]['w1_0820'] = 0;
                $price_data_list[$i]['w1_0822'] = 0;
                $price_data_list[$i]['w2_24h'] = 0;
                $price_data_list[$i]['w2_0818'] = 0;
                $price_data_list[$i]['w2_0820'] = 0;
                $price_data_list[$i]['w2_0822'] = 0;
                $price_data_list[$i]['w3_24h'] = 0;
                $price_data_list[$i]['w3_0818'] = 0;
                $price_data_list[$i]['w3_0820'] = 0;
                $price_data_list[$i]['w3_0822'] = 0;
                $i++;
            }
            // <<<

            $price_data_list[$i]['price'] = number_format($data->price, 2);
            $price_data_list[$i]['w1_24h'] = $data->w1_24h;
            $price_data_list[$i]['w1_0818'] = $data->w1_0818;
            $price_data_list[$i]['w1_0820'] = $data->w1_0820;
            $price_data_list[$i]['w1_0822'] = $data->w1_0822;
            $price_data_list[$i]['w2_24h'] = $data->w2_24h;
            $price_data_list[$i]['w2_0818'] = $data->w2_0818;
            $price_data_list[$i]['w2_0820'] = $data->w2_0820;
            $price_data_list[$i]['w2_0822'] = $data->w2_0822;
            $price_data_list[$i]['w3_24h'] = $data->w3_24h;
            $price_data_list[$i]['w3_0818'] = $data->w3_0818;
            $price_data_list[$i]['w3_0820'] = $data->w3_0820;
            $price_data_list[$i]['w3_0822'] = $data->w3_0822;
            $i++;
        }

        // 集計
        $price_data = PriceDistributionsHokkaido::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'price',
                        )
        );
        $cAry = $this->_summaryData($price_data);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w1_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w1_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w2_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w2_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w3_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsHokkaido::sum(
                        array(
                            'column' => 'w3_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_0818']['average'] = number_format($price_data / 100, 2);

        // 最頻値
        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w1_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w1_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w2_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w2_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w3_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsHokkaido::maximum(
                        array(
                            'column' => 'w3_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsHokkaido::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_0818']['mode'] = number_format($price_data->price, 2);

        $weeklyExists = PriceDistributionsHokkaido::existWeekly();    // 2020/02/26

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_dsprice.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_dsprice.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_dsprice' => 'active',
                    'ds_data_list' => $ds_data_list,
                    'ds_max' => max([$s_max, $d_max]),
                    'price_data_list' => $price_data_list,
                    'price_low' => $price_low,
                    'price_high' => $price_high,
                    'ds_upload_date' => $ds_upload_date,
                    'week_dates' => $strWeekDates,
                    'cary' => $cAry,
                    'export_date' => date('Ymd', strtotime($upload->target_date)),
                    'filename_area' => '_Hokkaido',
                    'series_name' => '',
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'weekly_exists' => $weeklyExists,   // 2020/02/26
                    'dict' => "{'確率密度':'確率密度','ダウンロード':'ダウンロード'"
                    . ",'24時間平均':'24時間平均'"
                    . ",'平日8-18時平均':'平日8-18時平均'"
                    . ",'価格（円/kWh）':'価格（円/kWh）'"
                    . ",'需要・供給(MW)':'需要・供給(MW)'"
                    . ",'原子力':'原子力'"
                    . ",'石炭_USC':'石炭_USC'"
                    . ",'石炭_SC':'石炭_SC'"
                    . ",'石炭_その他':'石炭_その他'"
                    . ",'LNG_その他':'LNG_その他'"
                    . ",'石油':'石油'"
                    . ",'残余需要（最大）':'残余需要（最大）'"
                    . ",'残余需要（最小）':'残余需要（最小）'"
                    . ",'残余需要（平均）':'残余需要（平均）'"
                    . "}",
                )
        );
    }

    public function kAction()
    {
        $this->view->en = '/dsprice/ke';   // 英語ページへのリンク 2020/01/28
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
        if($this->_enable($auth_bits) == 0)
        {
            return $this->response->redirect($this->session->has(self::FLG_LANGOVERRIDE) ? '/dsprice/reme' : '/dsprice/rem');   // 2020/02/26
        }

        // データの取得 需要供給
        $upload = $this->_findUpload();
        $upload_id = $upload->id;
        $strTargetDate = date('Y-m-d', strtotime($upload->target_date));    // 2020/02/02
        $ds_upload_date = date('Y年m月d日', strtotime($upload->target_date));

        $ds_data = DSBalancesKyushu::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $ds_data_list = $this->_loadDSBalance($ds_data);
        
        // 需要と供給の最大値
        $s_max = DSBalancesKyushu::maximum(
                [
                    'column' => 's_nuclear+s_coal_usc+s_coal_sc+s_coal_misc+s_lng_macc2+s_lng_macc+s_lng_acc+s_lng_misc+s_oil+s_lng_cc',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $s_max = ceil($s_max / 100) * 100;
        $d_max = DSBalancesKyushu::maximum(
                [
                    'column' => 'd_max',
                    'conditions' => ['upload_id' => $upload_id],
                ]
        );
        $d_max = ceil($d_max / 100) * 100;
        
        // 価格予測
        $strWeekDates = $this->_legendDates($upload->target_date);
        
        // 条件を満たす価格の範囲
        $price_low = PriceDistributionsKyushu::minimum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );
        $price_high = PriceDistributionsKyushu::maximum(
            [
                'column' => 'price',
                'conditions' => 
                                '(w1_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w1_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w2_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w2_0822>' . self::MIN_PRICE . ') OR ' .
                                '(w3_24h>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0818>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0820>' . self::MIN_PRICE . ') OR ' .
                                '(w3_0822>' . self::MIN_PRICE . ')'
                ,
            ]
        );

        //$price_low = $price_low ? floor($price_low - 2) : 0;
        if($price_low >= 2)
        {
             $price_low = floor($price_low - 2);
        }
        elseif($price_low >= 1)
        {
             $price_low = 1;
        }
        else
        {
             $price_low = 0;
        }

        $price_high = $price_high ? ceil($price_high + 2) : 25.0;

        $price_data = PriceDistributionsKyushu::find(
                        array(
                            "(upload_id=:uploadId:) AND (price>=:Low:) AND (price<=:High:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'Low' => $price_low,
                                'High' => $price_high,
                            ),
                        )
        );
        $price_data_list = [];
        $i = 0;
        foreach ($price_data as $data) {
            // >>> グラフ描画最小値 $price_low のレコードが無い場合
            if(($i == 0) && ($data->price > $price_low))
            {
                $price_data_list[$i]['price'] = number_format($price_low, 2);
                $price_data_list[$i]['w1_24h'] = 0;
                $price_data_list[$i]['w1_0818'] = 0;
                $price_data_list[$i]['w1_0820'] = 0;
                $price_data_list[$i]['w1_0822'] = 0;
                $price_data_list[$i]['w2_24h'] = 0;
                $price_data_list[$i]['w2_0818'] = 0;
                $price_data_list[$i]['w2_0820'] = 0;
                $price_data_list[$i]['w2_0822'] = 0;
                $price_data_list[$i]['w3_24h'] = 0;
                $price_data_list[$i]['w3_0818'] = 0;
                $price_data_list[$i]['w3_0820'] = 0;
                $price_data_list[$i]['w3_0822'] = 0;
                $i++;
            }
            // <<<

            $price_data_list[$i]['price'] = number_format($data->price, 2);
            $price_data_list[$i]['w1_24h'] = $data->w1_24h;
            $price_data_list[$i]['w1_0818'] = $data->w1_0818;
            $price_data_list[$i]['w1_0820'] = $data->w1_0820;
            $price_data_list[$i]['w1_0822'] = $data->w1_0822;
            $price_data_list[$i]['w2_24h'] = $data->w2_24h;
            $price_data_list[$i]['w2_0818'] = $data->w2_0818;
            $price_data_list[$i]['w2_0820'] = $data->w2_0820;
            $price_data_list[$i]['w2_0822'] = $data->w2_0822;
            $price_data_list[$i]['w3_24h'] = $data->w3_24h;
            $price_data_list[$i]['w3_0818'] = $data->w3_0818;
            $price_data_list[$i]['w3_0820'] = $data->w3_0820;
            $price_data_list[$i]['w3_0822'] = $data->w3_0822;
            $i++;
        }

        // 集計
        $price_data = PriceDistributionsKyushu::find(
                        array(
                            "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                            'order' => 'price',
                        )
        );
        $cAry = $this->_summaryData($price_data);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w1_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w1_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w1_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w2_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w2_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w2_0818']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w3_24h * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_24h']['average'] = number_format($price_data / 100, 2);
        
        $price_data = PriceDistributionsKyushu::sum(
                        array(
                            'column' => 'w3_0818 * price',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $cAry['w3_0818']['average'] = number_format($price_data / 100, 2);

        // 最頻値
        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w1_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w1_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w1_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w1_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w2_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w2_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w2_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w2_0818']['mode'] = number_format($price_data->price, 2);

        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w3_24h',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_24h=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_24h']['mode'] = number_format($price_data->price, 2);
        
        $rate_max = PriceDistributionsKyushu::maximum(
                        array(
                            'column' => 'w3_0818',
                            'conditions' => "(upload_id=:uploadId:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                            ),
                        )
        );
        $price_data = PriceDistributionsKyushu::findfirst(
                        array(
                            'conditions' => "(upload_id=:uploadId:) AND (w3_0818=:rate:)",
                            'bind' => array(
                                'uploadId' => $upload_id,
                                'rate' => $rate_max,
                            ),
                        )
        );
        $cAry['w3_0818']['mode'] = number_format($price_data->price, 2);

        $weeklyExists = PriceDistributionsKyushu::existWeekly();    // 2020/02/26

        // CSSのローカルリソースを追加します
        $this->assets
                ->addCss('css/chart_dsprice.css')
                ;

        // JavaScriptのローカルリソースを追加します
        // 2020/02/08
        if(!$this->session->has(self::FLG_LANGOVERRIDE))
        {
            $this->assets
                    ->addJs('js/chart_dsprice.js')
            ;
        }

        // viewにデータを渡す
        $this->view->setVars(
                array(
                    'login' => 'login',
                    'active_dsprice' => 'active',
                    'ds_data_list' => $ds_data_list,
                    'ds_max' => max([$s_max, $d_max]),
                    'price_data_list' => $price_data_list,
                    'price_low' => $price_low,
                    'price_high' => $price_high,
                    'ds_upload_date' => $ds_upload_date,
                    'week_dates' => $strWeekDates,
                    'cary' => $cAry,
                    'export_date' => date('Ymd', strtotime($upload->target_date)),
                    'filename_area' => '_Kyushu',
                    'series_name' => '',
                    'target_date' => $strTargetDate,    // 2020/01/31
                    'weekly_exists' => $weeklyExists,   // 2020/02/26
                    'dict' => "{'確率密度':'確率密度','ダウンロード':'ダウンロード'"
                    . ",'24時間平均':'24時間平均'"
                    . ",'平日8-18時平均':'平日8-18時平均'"
                    . ",'価格（円/kWh）':'価格（円/kWh）'"
                    . ",'需要・供給(MW)':'需要・供給(MW)'"
                    . ",'原子力':'原子力'"
                    . ",'石炭_USC':'石炭_USC'"
                    . ",'石炭_SC':'石炭_SC'"
                    . ",'石炭_その他':'石炭_その他'"
                    . ",'LNG_その他':'LNG_その他'"
                    . ",'石油':'石油'"
                    . ",'残余需要（最大）':'残余需要（最大）'"
                    . ",'残余需要（最小）':'残余需要（最小）'"
                    . ",'残余需要（平均）':'残余需要（平均）'"
                    . "}",
                )
        );
    }

    // 2020/01/28
    public function  enAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->indexAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->ds_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'確率密度':'Probability Density','ダウンロード':'Download'"
                    . ",'24時間平均':'24-hour averaged price'"
                    . ",'平日8-18時平均':'Daytime 8:00-18:00 averaged price'"
                    . ",'価格（円/kWh）':'Price(JPY/kWh)'"
                    . ",'需要・供給(MW)':'Load・Generation(MW)'"
                    . ",'原子力':'Nuclear'"
                    . ",'石炭_USC':'Coal_USC'"
                    . ",'石炭_SC':'Coal_SC'"
                    . ",'石炭_その他':'Coal_Others'"
                    . ",'LNG_その他':'LNG_Others'"
                    . ",'石油':'Oil'"
                    . ",'残余需要（最大）':'Residual Load (Highest)'"
                    . ",'残余需要（最小）':'Residual Load (Lowest)'"
                    . ",'残余需要（平均）':'Residual Load (Average)'"
                    . "}";
        $this->assets
                ->addJs('js/chart_dspricee.js')
        ;
    }
    
    public function  eeAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->eAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/e';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->ds_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'確率密度':'Probability Density','ダウンロード':'Download'"
                    . ",'24時間平均':'24-hour averaged price'"
                    . ",'平日8-18時平均':'Daytime 8:00-18:00 averaged price'"
                    . ",'価格（円/kWh）':'Price (JPY/kWh)'"
                    . ",'需要・供給(MW)':'Load・Generation (MW)'"
                    . ",'原子力':'Nuclear'"
                    . ",'石炭_USC':'Coal_USC'"
                    . ",'石炭_SC':'Coal_SC'"
                    . ",'石炭_その他':'Coal_Others'"
                    . ",'LNG_その他':'LNG_Others'"
                    . ",'石油':'Oil'"
                    . ",'残余需要（最大）':'Residual Load (Highest)'"
                    . ",'残余需要（最小）':'Residual Load (Lowest)'"
                    . ",'残余需要（平均）':'Residual Load (Average)'"
                    . "}";
        $this->assets
                ->addJs('js/chart_dspricee.js')
        ;
    }
    
    public function  weAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->wAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/w';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->ds_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'確率密度':'Probability Density','ダウンロード':'Download'"
                    . ",'24時間平均':'24-hour averaged price'"
                    . ",'平日8-18時平均':'Daytime 8:00-18:00 averaged price'"
                    . ",'価格（円/kWh）':'Price (JPY/kWh)'"
                    . ",'需要・供給(MW)':'Load・Generation(MW)'"
                    . ",'原子力':'Nuclear'"
                    . ",'石炭_USC':'Coal_USC'"
                    . ",'石炭_SC':'Coal_SC'"
                    . ",'石炭_その他':'Coal_Others'"
                    . ",'LNG_その他':'LNG_Others'"
                    . ",'石油':'Oil'"
                    . ",'残余需要（最大）':'Residual Load (Highest)'"
                    . ",'残余需要（最小）':'Residual Load (Lowest)'"
                    . ",'残余需要（平均）':'Residual Load (Average)'"
                    . "}";
        $this->assets
                ->addJs('js/chart_dspricee.js')
        ;
    }
    
    public function  heAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->hAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/h';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->ds_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'確率密度':'Probability Density','ダウンロード':'Download'"
                    . ",'24時間平均':'24-hour averaged price'"
                    . ",'平日8-18時平均':'Daytime 8:00-18:00 averaged price'"
                    . ",'価格（円/kWh）':'Price (JPY/kWh)'"
                    . ",'需要・供給(MW)':'Load・Generation(MW)'"
                    . ",'原子力':'Nuclear'"
                    . ",'石炭_USC':'Coal_USC'"
                    . ",'石炭_SC':'Coal_SC'"
                    . ",'石炭_その他':'Coal_Others'"
                    . ",'LNG_その他':'LNG_Others'"
                    . ",'石油':'Oil'"
                    . ",'残余需要（最大）':'Residual Load (Highest)'"
                    . ",'残余需要（最小）':'Residual Load (Lowest)'"
                    . ",'残余需要（平均）':'Residual Load (Average)'"
                    . "}";
        $this->assets
                ->addJs('js/chart_dspricee.js')
        ;
    }
    
    public function  keAction()
    {
        $this->session->set(self::FLG_LANGOVERRIDE, 'ovr');
        $this->kAction();
        $this->session->remove(self::FLG_LANGOVERRIDE);
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/k';   // 日本語ページへのリンク
        $this->setLang('en');
        $this->view->ds_upload_date = date('F j, Y', strtotime($this->view->target_date));
        $this->view->dict = "{'確率密度':'Probability Density','ダウンロード':'Download'"
                    . ",'24時間平均':'24-hour averaged price'"
                    . ",'平日8-18時平均':'Daytime 8:00-18:00 averaged price'"
                    . ",'価格（円/kWh）':'Price (JPY/kWh)'"
                    . ",'需要・供給(MW)':'Load・Generation(MW)'"
                    . ",'原子力':'Nuclear'"
                    . ",'石炭_USC':'Coal_USC'"
                    . ",'石炭_SC':'Coal_SC'"
                    . ",'石炭_その他':'Coal_Others'"
                    . ",'LNG_その他':'LNG_Others'"
                    . ",'石油':'Oil'"
                    . ",'残余需要（最大）':'Residual Load (Highest)'"
                    . ",'残余需要（最小）':'Residual Load (Lowest)'"
                    . ",'残余需要（平均）':'Residual Load (Average)'"
                    . "}";
        $this->assets
                ->addJs('js/chart_dspricee.js')
        ;
    }
    // 2020/02/21
    public function remAction()
    {
        $this->view->setMainView('index');        
        $this->view->en = '/dsprice/reme';   // 英語ページへのリンク
        $this->setLang('ja');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
    }
    
    public function remeAction()
    {
        $this->view->setMainView('indexe');        
        $this->view->ja = '/dsprice/rem';   // 日本語ページへのリンク
        $this->setLang('en');
        
        $auth = $this->session->get('auth');
        if (!empty($auth)) {
            $userId = $auth['user_id'];
            $auth_bits = $auth['auth_bits'];
        }
    }
}
