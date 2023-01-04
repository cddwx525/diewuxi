<?php
namespace main\views;

use swdf\helpers\html;
use main\views\layouts\base;

class home extends base
{
    /**
     *
     */
    protected function set_items()
    {
        $this->description = "Diewuxi.";
        $this->title = "Home";
        $this->position = array("Home");

        $this->main = html::tag(
            "div",
            html::tag(
                "div",
                html::inline_tag("p", "Welcome to Diewuxi.", array()) . "\n" .
                html::mono_tag(
                    "img",
                    array("src" => "/apps/blog/web/uploads/000/000/000/026-circutss.jpg", "alt" => "site_logo"),
                ) . "\n" .
                html::mono_tag("br", array()) . "\n" .
                html::mono_tag("br", array()),
                array("class" => "markdown-body")
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
        $this->text = "" .
            "################################################################################\n" .
            "This is text mode of home page.\n" .
            "<a href=\"https://www.baidu.com\">Baidu</a>\n" .
            "################################################################################";
    }
}
?>
