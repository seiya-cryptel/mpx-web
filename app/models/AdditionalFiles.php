<?php

// 2017/05/21
class AdditionalFiles extends \Phalcon\Mvc\Model 
{

    public function initialize()
    {
        
    }

    public function getSource()
    {
        return "tt83_additional_files";
    }

    public function afterFetch()
    {
        $sysSetting =  $this->getDI()->getSession()->get(ControllerBase::SV_VALUES);
        
        // 日付フォーマット
        $this->upload_date = date('Y-m-d', strtotime($this->upload_date));

        // new 判定       
        if(strtotime($this->upload_date) > strtotime(sprintf('-%d day', $sysSetting['TOOLS_NEW'][0]))) {
            $this->newMark = 'new';
        }
        else {
            $this->newMark = '';
        }
    }
}
