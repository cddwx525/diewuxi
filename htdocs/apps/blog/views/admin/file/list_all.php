<?php
namespace blog\views\admin\file;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_file_table;

class list_all extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "All files";
        $this->position = array("Files");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "p",
                html::a(
                    "Write a file",
                    url::get(
                        array(\swdf::$app->name, "admin/file.write", ""),
                        array(),
                        ""
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "All files",
                array()
            ) . "\n" .
            admin_file_table::widget(array("data" => $this->data["files"])),
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
