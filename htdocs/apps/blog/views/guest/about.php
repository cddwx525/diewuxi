<?php
namespace blog\views\guest;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\guest_base;

class about extends guest_base
{
    protected function set_items()
    {
        $this->css = array(
            url::get_static(\swdf::$app->name, "css/github-markdown.css"),
        );
        $this->title = "About";
        $this->position = array("About");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "About",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                $this->data["about_page"]["content"],
                array("class" => "markdown-body")
            ),
            array()
        );
    }

    protected function set_text()
    {
        $this->text = "";
    }
}
?>
