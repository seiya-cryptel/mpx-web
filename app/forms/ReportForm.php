<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Numeric;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Textarea;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\File;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Between;
use Phalcon\Validation\Validator\Regex;

class ReportForm extends Form
{
    
    public function initialize($entity = null, $options = array())
    {
        if ($options['edit']) {
            $element = new Hidden("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }
        
        $targetUser = new Select(   // 2016/06/28
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
        
        $this->add(new Hidden('url'));
        // 2020/01/30
        $this->add(new Hidden('url_e'));
                
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
                'REPORT_M' => '月次レポート',
                'REPORT_W' => '週次レポート',
                'REPORT_LFC' => '長期フォワードカーブレポート',     // 2017/07/12
                'REPORT_GS' => 'ジェネレーション・スタック',        // 2017/11/15
                'REPORT_VA' => '検証データ',        // 2018/04/29
                'REPORT_RP' => 'MPXマーケットリスクプレミアム',     // 2018/06/04
                'REPORT_O' => 'エリア間値差カーブ',
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
        
        $uploadFile = new File('uploadFile');
        $uploadFile->setLabel('レポートファイル');
        $this->add($uploadFile);

        // 2020/01/30
        $title = new Text("title_e");
        $title->setLabel('タイトル 英語');
        $this->add($title);
        
        $uploadFile = new File('uploadFile_e');
        $uploadFile->setLabel('英文レポートファイル');
        $this->add($uploadFile);
        
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
