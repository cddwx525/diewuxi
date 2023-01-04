<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class delete_confirm extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Confirm delete tag: [" . $this->data["tag"]->record["name"] . "]";
        $this->position = array("Confirm delete tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Confirm delete tag: [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) . "\n" .
            html::inline_tag(
                "p",
                "Tag information:",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Name: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["tag"]->record["name"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Slug: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["tag"]->record["slug"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Description: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["tag"]->record["description"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Article count: ", array()) .
                        html::inline_tag("span", $this->data["tag"]->get_article_count(), array()),
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
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["tag"]->record["id"])),
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
                    "action" => url::get(array(\swdf::$app->name, "admin/tag.delete", ""), array(), ""),
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
