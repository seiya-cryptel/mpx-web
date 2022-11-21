<?php

// 2020/02/26
// 各週のデータがある true か、全てゼロか false 配列で返す
class PriceDistributionsBase extends \Phalcon\Mvc\Model
{
    static public function existWeekly()
    {
        $exists = [];
        $data = self::find(
                    array(
                        'conditions' => 'w1_24h<>0 or w1_0818<>0 or w1_0820<>0 or w1_0822<>0',
                    )
        );
        $exists[] = (count($data) > 0) ? true : false;
        $data = self::find(
                    array(
                        'conditions' => 'w2_24h<>0 or w2_0818<>0 or w2_0820<>0 or w2_0822<>0',
                    )
        );
        $exists[] = (count($data) > 0) ? true : false;
        $data = self::find(
                    array(
                        'conditions' => 'w3_24h<>0 or w3_0818<>0 or w3_0820<>0 or w3_0822<>0',
                    )
        );
        $exists[] = (count($data) > 0) ? true : false;
        return $exists;
    }
}
