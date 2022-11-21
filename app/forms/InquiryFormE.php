<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;

class InquiryFormE extends Form
{

    public function initialize($entity = null, $options = array())
    {
        // $itm = new Text("subject");
        $itm = new Text("subj");
        $itm->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Subject is required.',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $itm->setLabel('Title');
        if($options['mode'] == 'confirm') {
            $itm->setAttribute('readonly', 'readonly');
        }
        $this->add($itm);

        $body = new TextArea("body");
        $body->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Detail is required.'
                    )
                ),
            )
        );
        $body->setLabel('Detail');
        if($options['mode'] == 'confirm') {
            $body->setAttribute('readonly', 'readonly');
        }
        $this->add($body);
    }

}
