<?php

// 2017/05/21
class Tools extends \Phalcon\Mvc\Model 
{

    public function initialize()
    {
        
    }

    public function getSource()
    {
        return "tt81_tools";
    }

    public function afterFetch()
    {
        $sysSetting =  $this->getDI()->getSession()->get(ControllerBase::SV_VALUES);
        
        // 日付フォーマット
        $this->update_date = date('Y-m-d', strtotime($this->update_date));
        
        // 登録日
        $this->regdate_datetime = date('Y-m-d', strtotime($this->regdate));
        
        // ファイル名エンコード
        $this->encoded_path = rawurldecode($this->file_path);

        // new 判定       
        if(strtotime($this->update_date) > strtotime(sprintf('-%d day', $sysSetting['TOOLS_NEW'][0]))) {
            $this->newMark = 'new';
        }
        else {
            $this->newMark = '';
        }
    }
}
