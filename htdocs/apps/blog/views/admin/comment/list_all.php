<?php
namespace blog\views\admin\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_comment_table;

class list_all extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "All comments";
        $this->position = array("Comments");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "All comments",
                array()
            ) . "\n" .
            admin_comment_table::widget(array("data" => $this->data["comments"])),
            array()
        );
    }


    /**
     *
     *
     */
    protected function set_text()
    {
        $this->text = "";
    }
}
?>
