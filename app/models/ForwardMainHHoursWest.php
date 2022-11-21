<?php

class ForwardMainHHoursWest extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt11_fcjp_hhour_w";
    }

    public function afterFetch()
    {
        
    }

    public function beforeSave()
    {
        
    }

}
