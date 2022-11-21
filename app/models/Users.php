<?php

class Users extends Phalcon\Mvc\Model
{
    // public $fc_hourly;      // 2018/10/19 2018/02/26
    // public $report_va;      // 2018/05/16
    // public $report_rp;      // 2018/06/04
    public $auth_bits;      // 2018/09/28
    public $user_type_disp;      // 2018/10/19
    public $valid_from_disp;
    public $valid_to_disp;
    public $isvalid_disp;
    public $dl_tool01;
    public $dl_tool02;
    public $dl_tool03;
    public $dl_tool04;
    public $dl_tool05;
    public $dl_tool06;
    public $dl_tool07;
    public $dl_tool08;
    public $dl_tool09;
    public $dl_tool10;
    public $dl_tool;

    public function getSource()
    {
        return "tm02_user";
    }
    public function afterFetch()
    {
        // ユーザ種別
        switch($this->user_type) {
        case 1:
            $this->user_type_disp = 'プランＡ';
            break;
        case 2:
            $this->user_type_disp = 'プランＢ';
            break;
        case 3:
            $this->user_type_disp = 'プランＣ';
            break;
        case 4:
            $this->user_type_disp = 'プランＤ';
            break;
        case 9:
            $this->user_type_disp = '管理者';
            break;
        default:
            $this->user_type_dips = '不明';
        }
        // 有効期間
        if(empty($this->valid_from)) {
            $this->valid_from_disp = '';
        }
        else {
            $this->valid_from_disp = date('Y-m-d', strtotime($this->valid_from));
        }
        if(empty($this->valid_to)) {
            $this->valid_to_disp = '';
        }
        else {
            $this->valid_to_disp = date('Y-m-d', strtotime($this->valid_to));
        }
        // 有効フラグ
        if(! empty($this->isvalid) && $this->isvalid) {
            $this->isvalid_disp = '有効';
        }
        else {
            $this->isvalid_disp = '';
        }
        
        // ツールダウンロードフラグ 2017/05/26
        if($this->dl_tool01
                || $this->dl_tool02
                || $this->dl_tool03
                || $this->dl_tool04
                || $this->dl_tool05
                || $this->dl_tool06
                || $this->dl_tool07
                || $this->dl_tool08
                || $this->dl_tool09
                || $this->dl_tool10)
        {
            $this->dl_tool = true;
        }
        else
        {
            $this->dl_tool = false;
        }
    }

    public function beforeSave()
    {
        $this->valid_from = ($this->valid_from ? $this->valid_from : NULL);
        $this->valid_to = ($this->valid_to ? $this->valid_to : NULL);
        $this->isvalid = ($this->isvalid ? TRUE : FALSE);
        $this->upddate = date('Y-m-d H:i:s');
    }

}
