<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class UserProfileEForm extends Form
{

    public function initialize($entity = null, $options = array())
    {
        $userId = new Text("id");
        $userId->setLabel('Email Address');
        $userId->setAttribute('readonly', 'readonly');
        $this->add($userId);

        $userNickname = new Text("user_nickname");
        $userNickname->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'User ID is required.'
                            )
                    ),
                )
        );
        $userNickname->setLabel('User ID');
        $this->add($userNickname);

        $userName = new Text("user_name");
        $userName->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'User name is required.'
                            )
                    ),
                )
        );
        $userName->setLabel('User Name');
        $this->add($userName);
    }

}
