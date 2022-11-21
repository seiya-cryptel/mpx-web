<?php

class ForwardSubCifCoals extends ForwardSubBase
// class ForwardSubCifCoals extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        parent::initialize();
        // $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt24_fc_cif_coal";
    }

}
