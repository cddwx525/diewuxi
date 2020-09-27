<?php
namespace blog\views\guest\article;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\article_list;

class list_all extends guest_base
{
    protected function set_items()
    {
        $this->title = "All articles";
        $this->position = array("Articles");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "All articles",
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
