<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Regex;

class NewsForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        if ($options['edit']) {
            $element = new Hidden("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }
        
        $targetUser = new Select(
            'target_user',
            array(
                '1' => '非会員',
                '2' => '会員',
                '3' => '非会員|会員',
            )
        );
        $targetUser->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '対象ユーザは省略できません。'
                    )
                ),
            )
        );
        $targetUser->setLabel('対象ユーザ');
        $this->add($targetUser);
                
        $dateNotice = new Date("date_notice");
        $dateNotice->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '配信日は省略できません。'
                    )
                ),
            )
        );
        $dateNotice->setLabel('配信日');
        $this->add($dateNotice);
        
        $category = new Select(
            'category',
            array(
                'NEWS' => 'ニュース',
                'REPORT_M' => '月次レポート',
                'REPORT_W' => '週次レポート',
                'REPORT_LFC' => '長期フォワードカーブレポート',     // 2017/07/12
                'REPORT_O' => 'エリア間値差カーブ',
                'MODEL' => 'モデル',
            )
        );
        $category->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'カテゴリは省略できません。'
                    )
                ),
            )
        );
        $category->setLabel('カテゴリ');
        $this->add($category);
        
        $title = new Text("title");
        $title->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'タイトルは省略できません。'
                    )
                ),
            )
        );
        $title->setLabel('タイトル');
        $this->add($title);
        
        // 2020/01/28
        $itm = new Text("title_e");
        $itm->setLabel('タイトル 英語');
        $this->add($itm);
        
        $content = new TextArea("content");
        $content->setLabel('本文');
        $this->add($content);
        
        $url = new Text("url");
        $url->setLabel('URL');
        $this->add($url);
        
        // 2020/01/28
        $itm = new Text("url_e");
        $itm->setLabel('URL 英語用');
        $this->add($itm);

        $publish = new Check("publish", ['value' => 1]);
        $publish->setLabel('公開');
        $publish->setDefault(0);
        $this->add($publish);

        $isValid = new Check("isvalid", ['value' => 1]);    // 2015/12/18
        $isValid->setLabel('有効');
        $isValid->setDefault(1);
        $this->add($isValid);
    }
}
