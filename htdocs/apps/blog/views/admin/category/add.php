<?php
namespace blog\views\admin\category;

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
        $this->title = "Add category";
        $this->position = array("Add category");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Add category",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Category added Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/category.show", ""),
                            array("id" => $this->data["category"]->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) .
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
        $this->text = "Add successfully.";
    }
}
?>
