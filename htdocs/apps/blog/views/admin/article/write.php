<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_tree;
use blog\widgets\admin_tags;

class write extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Write article";
        $this->position = array("Write article");


        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Write article(* must be write)",
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "form_stamp", "value" => $this->data["form_stamp"])),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Title:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "title", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Slug:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "slug", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Date:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "date", "value" => date("Y-m-d H:i:s"), "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Content:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", "", array("name" => "content", "class" => "textarea-big")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Category full slug:", array()) . "\n" .
                html::inline_tag("p", "Availiable categories:", array()) . "\n" .
                admin_category_tree::widget(array("data" => $this->data["root_categories"])) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "category_full_slug", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "Tag slugs(seperated by \", \"):", array()) . "\n" .
                html::inline_tag("p", "Availiable tags:", array()) . "\n" .
                admin_tags::widget(array("data" => $this->data["tags"])) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "tag_slugs", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Keywords:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "keywords", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Description:", array()) . "\n" .
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
                    "action" => url::get(array(\swdf::$app->name, "admin/article.add", ""), array(), ""),
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
