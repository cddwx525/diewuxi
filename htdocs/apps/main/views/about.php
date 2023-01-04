<?php
namespace main\views;

use swdf\helpers\html;
use main\views\layouts\base;

class about extends base
{
    public function set_items()
    {
        $this->title = "About";
        $this->position = array("About");

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Changelog:", array()) . "\n\n" .
            html::tag(
                "ul",
                html::inline_tag("li", "2023-01-04 New code structure.", array()) . "\n" .
                html::inline_tag("li", "2017-09-18 First version.", array()) . "\n" .
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

    public function set_text()
    {
         $this->text = "About page.";
    }
}
?>
