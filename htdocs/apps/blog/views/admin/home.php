<?php
namespace blog\views\admin;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class home extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Home";
        $this->position = array("Home");

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Administration Home", array()) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag("p", "This is home page.", array()) . "\n" .
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
