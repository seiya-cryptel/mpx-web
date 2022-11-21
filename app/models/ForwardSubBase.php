<?php

abstract class ForwardSubBase extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        $this->belongsTo('upload_id', 'Uploads', 'id');
    }

    // 2022/07/10 CSV Stream からレコードを追加 ------------------------
    //  $FH     I/O ファイルリソース
    public function fromCSVStream($FH, $uploadId)
    {
        fgetcsv($FH);   // ヘッダ行
        while (($fields = fgetcsv($FH)) !== FALSE)
        {
            $this->id = null;
            $this->upload_id = $uploadId;
            $this->fc_datetime = date('Y-m-d', strtotime($fields[0] . '-' . $fields[1] . '-' . $fields[2]));
            $this->price = trim(str_replace(',', '', $fields[3]));
            $this->create();
        }
    }

}
