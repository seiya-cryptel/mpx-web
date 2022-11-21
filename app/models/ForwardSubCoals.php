<?php

class ForwardSubCoals extends ForwardSubBase
// class ForwardSubCoals extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        parent::initialize();
        // $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt21_fc_coal";
    }

}
