<?php

class Notices extends \Phalcon\Mvc\Model 
{

    public function initialize()
    {
        
    }

    public function getSource()
    {
        return "tt93_notice";
    }

    public function afterFetch()
    {
        $sysSetting =  $this->getDI()->getSession()->get(ControllerBase::SV_VALUES);
        
        // 日付フォーマット
        $this->date_notice = date('Y-m-d', strtotime($this->date_notice));
        $this->date_notice_disp = date('Y-m-d', strtotime($this->date_notice));
        $this->date_notice_datetime = date('Y-m-d H:i:s', strtotime($this->date_notice));
        // 2020/02/15
        $this->date_noticee = date('M d, Y', strtotime($this->date_notice));
        $this->date_notice_dispe = date('M d, Y', strtotime($this->date_notice));
        $this->date_notice_datetimee = date('M d, Y H:i:s', strtotime($this->date_notice));
        
        // 対象ユーザ
        $targetUserDisp = "";
        if($this->target_user & 1) {
            if($targetUserDisp != "")   $targetUserDisp .= '|';
            $targetUserDisp .= '非会員';
        }
        if($this->target_user & 2) {
            if($targetUserDisp != "")   $targetUserDisp .= '|';
            $targetUserDisp .= '会員';
        }
        $this->target_user_disp = $targetUserDisp;
        
        // 公開
        $this->publish_disp = ($this->publish==1 ? '公開' : '非公開');
        
        // 登録日
        $this->regdate_datetime = date('Y-m-d', strtotime($this->regdate));

        // new 判定       
        if(strtotime($this->date_notice) > strtotime(sprintf('-%d day', $sysSetting['NEWS_NEW'][0]))) {
            $this->newMark = 'new';
        }
        else {
            $this->newMark = '';
        }
        
        // url 加工
        if(is_null($this->content) || trim($this->content)=='') {
            // $this->url = '/news/c/' . $this->id;
        }
        else {
            $this->url = '/news/c/' . $this->id;            
        }
        
        // url 相対フラグ
        if(is_null($this->url) || trim($this->url)=='') {
            $this->relativeFlag = false;
        }
        else {
            $this->relativeFlag = (substr($this->url, 0, 4)=='http') ? false : true;            
        }
    }

    public function beforeSave()
    {
        $this->publish = ($this->publish ? TRUE : FALSE);
        $this->isvalid = ($this->isvalid ? TRUE : FALSE);
    }
}
