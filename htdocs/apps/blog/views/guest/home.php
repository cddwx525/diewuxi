<?php
namespace blog\views\guest;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;
use blog\widgets\article_list;

class home extends guest_base
{
    protected function set_items()
    {
        $this->css = array(
            url::get_static("css/github-markdown.css"),
        );
        $this->description = "Diewuxi blog.";

        $this->title = "Home";
        $this->position = array("Home");

        $this->main = html::tag(
            "div",
            html::tag(
                "div",
                html::inline_tag("p", "Home page.", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()),
                array()
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "Latest articles:",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                article_list::widget(array("data" => $this->data["articles"])),
                array()
            ),
            array()
        );
    }

    protected function set_text()
    {
        $this->text = "This is home page.";
    }
}
?>
