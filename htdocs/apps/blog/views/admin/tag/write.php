<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_tags;

class write extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Write tag";
        $this->position = array("Write tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Write tag(* must be write)",
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
                ) . "\n\n" .
                html::inline_tag("p", "* Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "name", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Slug:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "slug", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Description:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", "", array("name" => "description", "class" => "textarea")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "add", "value" => "Add", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/tag.add", ""), array(), ""),
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
