<?php

// 2018/09/28
class Authority extends \Phalcon\Mvc\Model 
{

    public function initialize()
    {
        
    }

    public function getSource()
    {
        return "tm11_authority";
    }

    public function afterFetch()
    {
        
    }
    
    static public function findNameBits()
    {
        $res = [];
        $Authorities = self::find();
        foreach ($Authorities as $Auth)
        {
            $res[$Auth->auth_name] = intval($Auth->auth_bits);
        }
        return $res;
    }
}
