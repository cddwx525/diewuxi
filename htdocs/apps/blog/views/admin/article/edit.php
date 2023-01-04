<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_tree;
use blog\widgets\admin_tags;

class edit extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Edit article";
        $this->position = array("Edit article");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Edit article(* must be write)",
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "form_stamp", "value" => $this->data["form_stamp"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["article"]->record["id"])),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Title:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "title", "value" => $this->data["article"]->record["title"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Slug:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "slug", "value" => $this->data["article"]->record["slug"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Date:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "date", "value" => $this->data["article"]->record["date"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Content:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", $this->data["article"]->record["content"], array("name" => "content", "class" => "textarea-big")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Category full slug:", array()) . "\n" .
                html::inline_tag("p", "Availiable categories:", array()) . "\n" .
                admin_category_tree::widget(array("data" => $this->data["root_categories"])) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "category_full_slug", "value" => $this->data["article"]->get_category()->get_full_slug(), "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "Tag slugs(seperated by \", \"):", array()) . "\n" .
                html::inline_tag("p", "Availiable tags:", array()) . "\n" .
                admin_tags::widget(array("data" => $this->data["tags"])) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "tag_slugs", "value" => $this->data["article"]->get_tag_slugs(), "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Keywords:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "keywords", "value" => $this->data["article"]->record["keywords"], "class" => "input-text")),
                    array()
                ) . "\n\n" .

                html::inline_tag("label", "* Description:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", $this->data["article"]->record["description"], array("name" => "description", "class" => "textarea")),
                    array()
                ) . "\n\n" .

                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "update", "value" => "Update", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/article.update", ""), array(), ""),
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
