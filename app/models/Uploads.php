<?php

class Uploads extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        
    }

    public function getSource()
    {
        return "tt94_upload";
    }

    public function afterFetch()
    {
        $this->target_date_disp = date('Y-m-d', strtotime($this->target_date));
    }

    public function beforeSave()
    {
        
    }
    
    // レコード w check ---------------------------------------------------------
    static public function findFirstWC($id)
    {
        $self = self::findfirst($id);
        if(!$self)
        {
            $msg = __CLASS__ . ' not found for id: %s';
            /* 2022/03/16 Log クラス未定義 
            Log::Write(Log::LOG_TYPE_ERROR,
                    __CLASS__ . '::' . __FUNCTION__ . $msg,
                    [$id]);
             * 
             */
            throw new \Phalcon\Exception(vsprintf($msg, [$id]));
        }
        return $self;
    }

}
