<?php
namespace blog\views\admin\category;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_path;

class delete_confirm extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Confirm delete category: [" . $this->data["category"]->get_full_name() . "]";
        $this->position = array("Confirm delete category");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Confirm delete category: [" . htmlspecialchars($this->data["category"]->get_full_name()) . "]",
                array()
            ) . "\n" .
            html::inline_tag(
                "p",
                "Category information:",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Full name: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["category"]->get_full_name()), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Description: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["category"]->record["description"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Sub count: ", array()) .
                        html::inline_tag("span", $this->data["category"]->get_sub_count(), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Article count: ", array()) .
                        html::inline_tag("span", $this->data["category"]->get_article_count(), array()),
                        array()
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["category"]->record["id"])),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Input user password to confirm the action: ", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "password", "name" => "password", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "confirm", "value" => "Confirm", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/category.delete", ""), array(), ""),
                    "method" => "post"
                )
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
        $this->text = "";
    }
}
?>
