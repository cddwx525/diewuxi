<?php
namespace blog\views\admin\comment;

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
        $this->title = "Confirm delete comment";
        $this->position = array("Confirm delete comment");


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
            html::inline_tag(
                "h3",
                "Confirm delete comment",
                array()
            ) . "\n" .
            html::inline_tag(
                "p",
                "Comment information:",
                array()
            ) . "\n\n" .
            html::inline_tag(
                "p",
                "Under article: [" .
                html::a(
                    htmlspecialchars($this->data["comment"]->get_article()->record["title"]),
                    url::get(
                        array(\swdf::$app->name, "admin/article.show", ""),
                        array("id" => $this->data["comment"]->get_article()->record["id"]),
                        ""
                    ),
                    array()
                ) .
                "]",
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
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "id", "value" => $this->data["comment"]->record["id"])),
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
                    "action" => url::get(array(\swdf::$app->name, "admin/comment.delete", ""), array(), ""),
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
