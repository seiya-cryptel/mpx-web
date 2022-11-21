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

class UsersForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        $id = new Text('id');
        $id->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'メールアドレスは省略できません。'
                    )
                ),
                new Email(
                    array(
                        'message' => 'メールアドレスが正しくありません。'
                    )
                ),
            )
        );
        $id->setLabel('メールアドレス');
        $this->add($id);
        
        $userName = new Text("user_name");
        $userName->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '会社名は省略できません。'
                    )
                ),
            )
        );
        $userName->setLabel('会社名');
        $this->add($userName);
        
        $userNickname = new Text("user_nickname");
        $userNickname->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'ユーザネームは省略できません。'
                    )
                ),
            )
        );
        $userNickname->setLabel('ユーザネーム');
        $this->add($userNickname);
                
        $userType = new Select(
            'user_type',
            array(
                '1' => 'プランＡ',
                '2' => 'プランＡ２',
                '3' => 'プランＢ',
                '4' => 'プランＢ２',
                '5' => 'プランＣ',
                '6' => 'プランＣ２',
                '7' => 'プランＤ',
                '8' => 'プランＤ２',
                '9' => '管理者',
            )
        );
        $userType->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'ユーザ種別は省略できません。'
                    )
                ),
            )
        );
        $userType->setLabel('ユーザ種別');
        $this->add($userType);
        
        $validFrom = new Date("valid_from");
        $validFrom->setLabel('有効期間開始');
        $this->add($validFrom);
        
        $validTo = new Date("valid_to");
        $validTo->setLabel('有効期間終了');
        $this->add($validTo);

        $isValid = new Check("isvalid", ['value' => 1]);    // 2015/12/18
        $isValid->setLabel('有効');
        $isValid->setDefault(1);
        $this->add($isValid);
    }
}
