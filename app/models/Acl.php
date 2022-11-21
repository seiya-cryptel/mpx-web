<?php

// 2017/05/21
class Acl extends \Phalcon\Mvc\Model 
{

    public function initialize()
    {
        $this->belongsTo('auth_name', 'Authority', 'auth_name');
    }

    public function getSource()
    {
        return "tm12_acl";
    }

    public function afterFetch()
    {
        
    }
}
