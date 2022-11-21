<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class UserPwdsEForm extends Form
{

    public function initialize($entity = null, $options = array())
    {

        $userPwd = new Password("user_pwd1");
        $userPwd->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'Password is required.',
                        'cancelOnFail' => true
                            )
                    ),
                    new Confirmation(
                            array(
                        'message' => 'Password is required.',
                        'with' => 'user_pwd2',
                            )
                    ),
                )
        );
        $userPwd->setLabel('Password');
        $this->add($userPwd);

        $userPwd2 = new Password("user_pwd2");
        $userPwd2->addValidators(
                array(
                    new PresenceOf(
                            array(
                        'message' => 'Re-enter password is required.'
                            )
                    ),
                )
        );
        $userPwd2->setLabel('Re-enter password');
        $this->add($userPwd2);
    }

}
