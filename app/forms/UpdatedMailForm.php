<?php
// 2017/05/12

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;

class UpdatedMailForm extends Form 
{
    // deguchi修正 メールタイトル関連修正 2019/05/22
    public function initialize($entity = null, $options = array())
    {
        // mode
        $mode = $options['mode'];
        
        // deguchi修正タイトル関連修正箇所以下
        $subj = new TextArea("updatedsubj", ['rows' => '1']);
        $subj->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => 'サブジェクトは省略できません。'
                    )
                ),
            )
        );

        $subj->setLabel('サブジェクト');
        if($mode == 'confirm') {
            $subj->setAttribute('readonly', 'readonly');
        }
        $this->add($subj);
        // deguchi修正タイトル関連修正箇所以上

        $item = new TextArea("updatedlist", ['rows' => '10']);
        $item->addValidators(
            array(
                new PresenceOf(
                    array(
                        'message' => '本文は省略できません。'
                    )
                ),
            )
        );

        $item->setLabel('更新ファイル');
        if($mode == 'confirm') {
            $item->setAttribute('readonly', 'readonly');
        }

        $this->add($item);
        
        $title = ($mode == 'confirm') ? '送信' : '確認';
        $this->add(new Submit('submit', ['value' => $title]));
    }
}
