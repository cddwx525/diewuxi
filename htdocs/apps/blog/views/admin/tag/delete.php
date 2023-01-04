<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class delete extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Delete tag: [" . $this->data["tag"]->record["name"] . "]";
        $this->position = array("Delete tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Delete tag: [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Tag deleted Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Tag list",
                        url::get(
                            array(\swdf::$app->name, "admin/tag.list_all", ""),
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
        $this->text = "Delete successfully.";
    }
}
?>
