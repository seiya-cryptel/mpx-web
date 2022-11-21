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

class UploadSearchForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        $upfrom = new Text('upfrom');
        $upfrom->setLabel('アップロード開始');
        $this->add($upfrom);
        
        $upto = new Text('upto');
        $upto->setLabel('アップロード終了');
        $this->add($upto);

        $targetfrom = new Text('targetfrom');
        $targetfrom->setLabel('配信／セトルメント開始');
        $this->add($targetfrom);
        
        $targetto = new Text('targetto');
        $targetto->setLabel('配信／セトルメント終了');
        $this->add($targetto);
        
        $email = new Text('email');
        $email->setLabel('メールアドレス');
        $this->add($email);
    }
}
