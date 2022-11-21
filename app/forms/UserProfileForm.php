<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class UserProfileForm extends Form
{

    public function initialize($entity = null, $options = array())
    {
        $userId = new Text("id");
        $userId->setLabel('メールアドレス');
        $userId->setAttribute('readonly', 'readonly');
        $this->add($userId);

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

        $userName = new Text("user_name");
        $userName->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'ユーザ名は省略できません。'
                            )
                    ),
                )
        );
        $userName->setLabel('ユーザ名');
        $this->add($userName);
    }

}
