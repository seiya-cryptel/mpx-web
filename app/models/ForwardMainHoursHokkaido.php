<?php

class ForwardMainHoursHokkaido extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt14_fcjp_hour_h";
    }

    public function afterFetch()
    {
        
    }

    public function beforeSave()
    {
        
    }

}
