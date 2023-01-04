<?php
namespace blog\views\guest\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;
use blog\widgets\articles_position;

class write extends guest_base
{
    protected function set_items()
    {
        $this->title = "Comment under: [" . $this->data["article"]->record["title"] . "]";
        $this->position = articles_position::widget(array("data" => $this->data["article"]->get_category()->get_path()));
        $this->position[] = html::a(
            htmlspecialchars($this->data["article"]->record["title"]),
            url::get(
                array(\swdf::$app->name, "guest/article.slug_show", ""),
                array("full_slug" => $this->data["article"]->get_full_slug()),
                ""
            ),
            array()
        );
        $this->position[] = "Write comment";

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
                        array(\swdf::$app->name, "guest/article.slug_show", ""),
                        array("full_slug" => $this->data["article"]->get_full_slug()),
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
                    $author_part,
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
            "<form action=\"" . url::get(array(\swdf::$app->name, "guest/comment.add", ""), array(), "") . "\" method=\"post\">" . "\n\n" .
            "<p><input type=\"hidden\" name=\"article_id\" value=\"" . $this->data["article"]->record["id"] . "\" /></p>" . "\n" .
            "<p><input type=\"hidden\" name=\"target_id\" value=\"" . $this->data["comment"]->record["id"] . "\" /></p>" . "\n\n" .

            "<label>* Name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"user\" value=\"\" id=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Email:</label>" . "\n" .
            "<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>Website:</label>" . "\n" .
            "<p><input type=\"text\" name=\"site\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Content:</label>" . "\n" .
            "<p><textarea name=\"content\" class=\"textarea\"></textarea></p>" . "\n\n" .

            "<p><input type=\"submit\" name=\"send\" value=\"Send\" class=\"input-submit\" /></p>" . "\n" .
            "</form >",
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
