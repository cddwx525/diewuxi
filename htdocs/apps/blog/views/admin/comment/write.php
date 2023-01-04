<?php
namespace blog\views\admin\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class write extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Comment under: [" . $this->data["article"]->record["title"] . "]";
        $this->position = array("Write comment");

        if ($this->data["comment"]->record["author"] === "1")
        {
            $author_part = html::inline_tag("span", "[Author]", array("class" => "text-warning text-padding"));
        }
        else
        {
            $author_part = "";
        }

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Comment", array()) . "\n\n" .
            html::inline_tag(
                "p",
                "Under article: [" .
                html::a(
                    htmlspecialchars($this->data["article"]->record["title"]),
                    url::get(
                        array(\swdf::$app->name, "admin/article.show", ""),
                        array("id" => $this->data["article"]->record["id"]),
                        ""
                    ),
                    array()
                ) .
                "]",
                array()
            ) . "\n\n" .
            html::inline_tag(
                "p",
                "Reply to: ",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "div",
                    html::inline_tag("span", htmlspecialchars($this->data["comment"]->record["user"]), array()) .
                    $author_part .
                    html::inline_tag("span", "[" . htmlspecialchars($this->data["comment"]->record["mail"]) . "]", array("class" => "text-padding")) .
                    html::inline_tag("span", "[" . htmlspecialchars($this->data["comment"]->record["site"]) . "]", array("class" => "text-padding")),
                    array("class" => "bg-header-line-s")
                ) . "\n\n" .
                html::tag(
                    "div",
                    htmlspecialchars($this->data["comment"]->record["content"]),
                    array("class" => "block-padding")
                ) . "\n\n" .
                html::tag(
                    "div",
                    html::inline_tag("span", $this->data["comment"]->record["date"], array()),
                    array()
                ),
                array("id" => $this->data["comment"]->record["id"])
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "Write comment(* is necessary, and email is not shown to public)",
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
                    html::mono_tag("input", array("type" => "hidden", "name" => "article_id", "value" => $this->data["article"]->record["id"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "target_id", "value" => $this->data["comment"]->record["id"])),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Is author:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "checkbox", "name" => "author", "checked" => "true")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "user", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Email:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "mail", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Website:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "site", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Content:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", "", array("name" => "content", "class" => "textarea")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "add", "value" => "Add", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/comment.add", ""), array(), ""),
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
