<?php
namespace blog\views\admin\category;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_table;
use blog\widgets\admin_category_manage_tree;

class list_all extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "All categories";
        $this->position = array("Categories");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "p",
                html::a(
                    "Write a category",
                    url::get(
                        array(\swdf::$app->name, "admin/category.write", ""),
                        array(),
                        ""
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "All categories",
                array()
            ) . "\n" .
            admin_category_table::widget(array("data" => $this->data["categories"])) . "\n\n" .
            html::inline_tag(
                "h3",
                "Category relations",
                array()
            ) . "\n" .
            admin_category_manage_tree::widget(array("data" => $this->data["root_categories"])),
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
