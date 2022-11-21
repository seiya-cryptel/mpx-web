<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;

class InquiryForm extends Form
{

    public function initialize($entity = null, $options = array())
    {
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
