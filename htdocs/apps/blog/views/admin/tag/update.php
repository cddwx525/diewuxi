<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class update extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Update tag: [" . $this->data["tag"]->record["name"] . "]";
        $this->position = array("Update tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Update tag: [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Tag updated Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/tag.show", ""),
                            array("id" => $this->data["tag"]->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) .
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
        $this->text = "Update successfully.";
    }
}
?>
