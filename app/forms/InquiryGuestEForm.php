<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;

class InquiryGuestEForm extends Form
{

    public function initialize($entity = null, $options = array())
    {
        $email1 = new Email("email1");
        $email1->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Email Address is required.',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $email1->setLabel('E-Mail');
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
                        'message' => 'Email Addresses are not match.',
                        'with' => 'email1',
                            )
                    ),
                )
            );
            $email2->setLabel('E-mail(re-enter)');
            $this->add($email2);
        }
        else {
            $email2 = new Hidden("email2");
            $email2->addValidators(
                array(
                    new Confirmation(
                            array(
                        'message' => 'Email Addresses are not match.',
                        'with' => 'email1',
                            )
                    ),
                )
            );
            $email2->setLabel('E-mail(re-enter)');
            $this->add($email2);
        }
        
        $guestCorp = new Text("guest_corp");
        $guestCorp->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Company Name is required.',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $guestCorp->setLabel('Company Name');
        if($options['mode'] == 'confirm') {
            $guestCorp->setAttribute('readonly', 'readonly');
        }
        $this->add($guestCorp);
        
        $guestName = new Text("guest_name");
        $guestName->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Name is required.',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $guestName->setLabel('Your Name');
        if($options['mode'] == 'confirm') {
            $guestName->setAttribute('readonly', 'readonly');
        }
        $this->add($guestName);
        
        $subject = new Text("subject");
        $subject->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'Subject is required.',
                        'cancelOnFail' => true,
                    )
                ),
            )
        );
        $subject->setLabel('Subject');
        if($options['mode'] == 'confirm') {
            $subject->setAttribute('readonly', 'readonly');
        }
        $this->add($subject);

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
        $body->setLabel('Inquiries detail');
        if($options['mode'] == 'confirm') {
            $body->setAttribute('readonly', 'readonly');
        }
        $this->add($body);
    }

}
