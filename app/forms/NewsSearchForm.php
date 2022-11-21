<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Regex;

class NewsSearchForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        $dtfrom = new Text('dtfrom');
        $dtfrom->setLabel('日時開始');
        $this->add($dtfrom);
        
        $dtto = new Text('dtto');
        $dtto->setLabel('日時終了');
        $this->add($dtto);
    }
}
