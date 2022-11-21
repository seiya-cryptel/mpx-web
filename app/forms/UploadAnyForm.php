<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\File;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Regex;

// 新しいアップロード画面 2016/03/01
class UploadAnyForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        $dataType = new Select(
                'dataType',
                array(
                    UploadController::DATA_FORWARDMAIN => '電力フォーワード',
                    UploadController::DATA_FORWARDMAIN_E => '電力フォーワード 東エリア',
                    UploadController::DATA_FORWARDMAIN_W => '電力フォーワード 西エリア',
                    UploadController::DATA_FORWARDMAIN_H => '電力フォーワード 北海道',
                    UploadController::DATA_FORWARDMAIN_K => '電力フォーワード 九州',
                    UploadController::DATA_FORWARDSUB => '燃料炉前価格想定',        // 2019/02/08
                    UploadController::DATA_FORWARDSUB_CIF => '燃料CIF価格想定',     // 2019/02/08
                    UploadController::DATA_HISTORICALMAIN => 'JEPX',
                    UploadController::DATA_HISTORICALSUB => 'CME',
                    UploadController::DATA_PREREQUISITE => '需要・再エネ',
                    UploadController::DATA_PREREQUISITE_E => '需要・再エネ 東エリア',
                    UploadController::DATA_PREREQUISITE_W => '需要・再エネ 西エリア',
                    UploadController::DATA_PREREQUISITE_H => '需要・再エネ 北海道',     // 2017/02/19
                    UploadController::DATA_PREREQUISITE_K => '需要・再エネ 九州',
                    UploadController::DATA_HISTORICALDEMAND => '需要実績',
                    UploadController::DATA_CAPACITY => '供給力',    // 2016/03/27
                    UploadController::DATA_CAPACITY_E => '供給力 東エリア',    // 2016/05/17
                    UploadController::DATA_CAPACITY_W => '供給力 西エリア',
                    UploadController::DATA_CAPACITY_H => '供給力 北海道',       // 2017/02/19
                    UploadController::DATA_CAPACITY_K => '供給力 九州',
                    UploadController::DATA_INTERCONNECT => '連系線運用容量想定',    // 2016/05/22
                    UploadController::DATA_INTERCONNECT_H => '連系線運用容量想定 北本', // 2017/02/23
                    UploadController::DATA_INTERCONNECT_K => '連系線運用容量想定 関門',
                    UploadController::DATA_EVENT => '供給力イベント',     // 2016/06/20
                    UploadController::DATA_JEPX_SHORT => '短期JEPXスポット予測',
                    UploadController::DATA_JEPX_SHORT_E => '短期JEPXスポット予測 東エリア', // 2016/07/01
                    UploadController::DATA_JEPX_SHORT_W => '短期JEPXスポット予測 西エリア',
                    UploadController::DATA_JEPX_SHORT_H => '短期JEPXスポット予測 北海道',   // 2017/02/19
                    UploadController::DATA_JEPX_SHORT_K => '短期JEPXスポット予測 九州',
                    UploadController::DATA_RESIDUAL_LOAD => '残余需要',     // 2018/02/16
                    UploadController::DATA_HYDRO_PUMP => '揚水',
                    UploadController::DATA_ASP => 'ＡＳＰ',
                    // 2019/10/22
                    // UploadController::DATA_FWD_D_S_BALANCE => '需給バランス・価格予測',  2020/02/29
                    UploadController::DATA_FWD_D_S_BALANCE => '１か月予測',
                )
                );
        $dataType->setLabel('アップロード データ');
        $this->add($dataType);
        
        $validFrom = new Text('validFrom');
        $validFrom->setLabel('有効期間開始');
        $this->add($validFrom);
        
        $uploadFile = new File('uploadFile');
        $uploadFile->setLabel('ファイル');
        $this->add($uploadFile);
    }
}
