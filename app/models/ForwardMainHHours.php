<?php

class ForwardMainHHours extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt11_fcjp_hhour";
    }

    public function afterFetch()
    {
        
    }

    public function beforeSave()
    {
        
    }

}
