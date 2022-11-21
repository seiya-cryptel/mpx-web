<?php

class SysSettings extends Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "tm01_system";
    }

    public function load()
    {
        $rows = SysSettings::find();
        foreach ($rows as $row) {
            if ($row->istext) {
                $vals[$row->var_name][$row->var_index] = $row->txtval;
            } else {
                $vals[$row->var_name][$row->var_index] = $row->numval;
            }
        }
        return $vals;
    }

}
