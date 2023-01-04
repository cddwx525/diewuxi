<?php
namespace blog\views\admin\file;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class add extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Add file";
        $this->position = array("Add file");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Add file",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "File added Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/file.show", ""),
                            array("id" => $this->data["file"]->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) .
                    html::a(
                        "File list",
                        url::get(
                            array(\swdf::$app->name, "admin/file.list_all", ""),
                            array(),
                            ""
                        ),
                        array("class" => "text-padding")
                    ),
                    array("class" => "text-center")
                ),
                array()
            ),
            array()
        );
    }



    /**
     *
     *
     */
    protected function set_text()
    {
        $this->text = "Add successfully.";
    }
}
?>
