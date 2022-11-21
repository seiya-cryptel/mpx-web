<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class LostpwdForm extends Form
{

    public function initialize($entity = null, $options = array())
    {

        $userEmail = new Email("id");
        $userEmail->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'メールアドレスは省略できません。',
                        'cancelOnFail' => true
                    )
                ),
                new EmailValidator(
                    array(
                        'message' => 'メールアドレスが正しくありません。',
                    )
                ),
            )
        );
        $userEmail->setLabel('メールアドレス');
        $this->add($userEmail);

        $userNickname = new Text("user_nickname");
        $userNickname->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'ユーザIDは省略できません。'
                    )
                ),
            )
        );
        $userNickname->setLabel('ユーザID');
        $this->add($userNickname);
    }

}
