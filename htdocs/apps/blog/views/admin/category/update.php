<?php
namespace blog\views\admin\category;

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
        $this->title = "Update category: [" . $this->data["category"]->get_full_name() . "]";
        $this->position = array("Update category");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Update category: [" . htmlspecialchars($this->data["category"]->get_full_name()) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Category updated Successfully!",
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
        $this->text = "Update successfully.";
    }
}
?>
