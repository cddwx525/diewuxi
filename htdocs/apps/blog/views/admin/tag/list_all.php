<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_tag_table;

class list_all extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "All tags";
        $this->position = array("Tags");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "p",
                html::a(
                    "Write a tag",
                    url::get(
                        array(\swdf::$app->name, "admin/tag.write", ""),
                        array(),
                        ""
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "All tags",
                array()
            ) . "\n" .
            admin_tag_table::widget(array("data" => $this->data["tags"])),
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
