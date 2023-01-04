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
            url::get_static("css/github-markdown.css"),
        );
        $this->title = "About";
        $this->position = array("About");

        $this->main = html::tag(
            "div",
            html::tag(
                "div",
                html::inline_tag("p", "", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()),
                array()
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
