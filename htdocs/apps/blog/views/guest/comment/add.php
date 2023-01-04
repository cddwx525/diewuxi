<?php
namespace blog\views\guest\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;
use blog\widgets\articles_position;

class add extends guest_base
{
    protected function set_items()
    {
        $this->title = "Comment under [" . htmlspecialchars($this->data["article"]->record["title"]) . "]";
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
        $this->position[] = "Add comment";

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Add comment under: [" . htmlspecialchars($this->data["article"]->record["title"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Comment added Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "guest/article.slug_show", ""),
                            array("full_slug" => $this->data["article"]->get_full_slug()),
                            $this->data["comment"]->record["id"]
                        ),
                        array()
                    ),
                    array("class" => "text-center")
                ),
                array()
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
