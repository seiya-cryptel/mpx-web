<?php

class ForwardSubCifOils extends ForwardSubBase
// class ForwardSubCifOils extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        parent::initialize();
    }

    public function getSource()
    {
        return "tt25_fc_cif_oil";
    }

}
