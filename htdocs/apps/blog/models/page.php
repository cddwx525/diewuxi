<?php
namespace blog\models;

use swdf\base\model;

class page extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "page";
    }



    /**
     *
     *
     */
    public function get_by_id($id)
    {
        $this->record = $this->select_by_id($id)["record"];

        return $this;
    }


    /**
     *
     *
     */
    public function get_by_slug($slug)
    {
        $where = array(
            array(
                "field" => "slug",
                "value" => $slug,
                "operator" => "=",
                "condition" => "",
            ),
        );
        $this->record = $this->where($where)->select_first()["record"];

        return $this;
    }
}
?>
