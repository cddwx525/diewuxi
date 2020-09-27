<?php
namespace blog\views\guest\article;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\articles_position;
use blog\widgets\category_list;
use blog\widgets\article_list;

class list_category extends guest_base
{
    protected function set_items()
    {
        $this->title = "Articles in category [" . $this->data["category"]["full_name"] . "]";
        $this->position = articles_position::widget(array("data" => array_slice($this->data["category"]["path"], 0, -1)));
        $this->position[] = htmlspecialchars($this->data["category"]["name"]);

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Articles in category [" . htmlspecialchars($this->data["category"]["full_name"]) . "]",
                array()
            ) .
            "\n" .
            html::tag(
                "div",
                category_list::widget(array("data" => $this->data["category"]["sub"])) . "\n" .
                article_list::widget(array("data" => $this->data["articles"])),
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
