<?php

class ForwardMainHoursEast extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt14_fcjp_hour_e";
    }

    public function afterFetch()
    {
        
    }

    public function beforeSave()
    {
        
    }

}
