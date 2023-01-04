<?php
namespace blog\views\admin\category;

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
        $this->title = "Delete category: [" . $this->data["category"]->record["name"] . "]";
        $this->position = array("Delete category");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Delete category: [" . htmlspecialchars($this->data["category"]->record["name"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Category deleted Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Category list",
                        url::get(
                            array(\swdf::$app->name, "admin/category.list_all", ""),
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
