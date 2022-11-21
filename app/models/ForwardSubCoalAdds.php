<?php

class ForwardSubCoalAdds extends ForwardSubBase
// class ForwardSubCoalAdds extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        parent::initialize();
        // $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    public function getSource()
    {
        return "tt21_fc_coal_add";
    }
}
