<?php
namespace blog\views\guest\article;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\article_list;

class slug_list_by_tag extends guest_base
{
    protected function set_items()
    {
        $this->title = "Articles in tag " . $this->data["tag"]->record["name"];
        $this->position = array("Tag: " . htmlspecialchars($this->data["tag"]->record["name"]));

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Articles in Tag [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) .
            "\n" .
            html::tag(
                "div",
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
