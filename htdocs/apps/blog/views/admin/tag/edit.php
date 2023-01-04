<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_tags;

class edit extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Edit tag: [" . $this->data["tag"]->record["name"] . "]";
        $this->position = array("Edit tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Edit tag: [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) . "\n\n" .
            html::inline_tag(
                "p",
                "Availiable tags:",
                array()
            ) . "\n\n" .
            admin_tags::widget(array("data" => $this->data["tags"])) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "form_stamp", "value" => $this->data["form_stamp"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["tag"]->record["id"])),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "name", "value" => $this->data["tag"]->record["name"], "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Slug:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "slug", "value" => $this->data["tag"]->record["slug"], "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Description:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", $this->data["tag"]->record["description"], array("name" => "description", "class" => "textarea")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "update", "value" => "Update", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/tag.update", ""), array(), ""),
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
        $this->text = "Form_stamp: " . $this->data["form_stamp"];
    }
}
?>
