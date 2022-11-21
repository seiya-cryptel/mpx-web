<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class UserPwdsForm extends Form
{

    public function initialize($entity = null, $options = array())
    {

        $userPwd = new Password("user_pwd1");
        $userPwd->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'パスワードは省略できません。',
                        'cancelOnFail' => true
                            )
                    ),
                    new Confirmation(
                            array(
                        'message' => 'パスワードは省略できません。',
                        'with' => 'user_pwd2',
                            )
                    ),
                )
        );
        $userPwd->setLabel('パスワード');
        $this->add($userPwd);

        $userPwd2 = new Password("user_pwd2");
        $userPwd2->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => '確認用パスワードは省略できません。'
                            )
                    ),
                )
        );
        $userPwd2->setLabel('確認用パスワード');
        $this->add($userPwd2);
    }

}
