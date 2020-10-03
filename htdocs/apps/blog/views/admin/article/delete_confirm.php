<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_path;
use blog\widgets\admin_tag_list;


class delete_confirm extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Confirm delete article [" . htmlspecialchars($this->data["article"]["title"]) . "]";
        $this->position = array("Confirm delete article");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Confirm delete article [" . htmlspecialchars($this->data["article"]["title"]) . "]",
                array()
            ) . "\n" .
            html::inline_tag(
                "p",
                "Article information:",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Title: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["article"]["title"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Description: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["article"]["description"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Keywords: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["article"]["keywords"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Category: ", array()) .
                        html::inline_tag("span", admin_category_path::widget(array("data" => $this->data["article"]["category"])), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Tags: ", array()) .
                        html::inline_tag("span", admin_tag_list::widget(array("data" => $this->data["article"]["tags"])), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Date: ", array()) .
                        html::inline_tag("span", $this->data["article"]["date"], array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Comments count: ", array()) .
                        html::inline_tag("span", $this->data["article"]["comment_count"], array()),
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
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["article"]["id"])),
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
                    "action" => url::get(array(\swdf::$app->name, "admin/article.delete", ""), array(), ""),
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
