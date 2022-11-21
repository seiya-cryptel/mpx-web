<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;

class InquiryGuestForm extends Form
{

    public function initialize($entity = null, $options = array())
    {
        $email1 = new Email("email1");
        $email1->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'メールアドレスは省略できません。',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $email1->setLabel('メールアドレス');
        if($options['mode'] == 'confirm') {
            $email1->setAttribute('readonly', 'readonly');
        }
        $this->add($email1);

        if($options['mode'] != 'confirm') {
            $email2 = new Email("email2");
            $email2->addValidators(
                array(
                    new Confirmation(
                            array(
                        'message' => 'メールアドレスが一致しません。',
                        'with' => 'email1',
                            )
                    ),
                )
            );
            $email2->setLabel('メールアドレス（確認）');
            $this->add($email2);
        }
        else {
            $email2 = new Hidden("email2");
            $email2->addValidators(
                array(
                    new Confirmation(
                            array(
                        'message' => 'メールアドレスが一致しません。',
                        'with' => 'email1',
                            )
                    ),
                )
            );
            $email2->setLabel('メールアドレス（確認）');
            $this->add($email2);
        }
        
        $guestCorp = new Text("guest_corp");
        $guestCorp->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '会社名は省略できません。',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $guestCorp->setLabel('会社名');
        if($options['mode'] == 'confirm') {
            $guestCorp->setAttribute('readonly', 'readonly');
        }
        $this->add($guestCorp);
        
        $guestName = new Text("guest_name");
        $guestName->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'お名前は省略できません。',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $guestName->setLabel('お名前');
        if($options['mode'] == 'confirm') {
            $guestName->setAttribute('readonly', 'readonly');
        }
        $this->add($guestName);
        
        $subject = new Text("subject");
        $subject->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '件名は省略できません。',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $subject->setLabel('件名');
        if($options['mode'] == 'confirm') {
            $subject->setAttribute('readonly', 'readonly');
        }
        $this->add($subject);

        $body = new TextArea("body");
        $body->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '本文は省略できません。'
                    )
                ),
            )
        );
        $body->setLabel('本文');
        if($options['mode'] == 'confirm') {
            $body->setAttribute('readonly', 'readonly');
        }
        $this->add($body);
    }

}
