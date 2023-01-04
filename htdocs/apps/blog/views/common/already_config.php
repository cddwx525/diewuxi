<?php
namespace blog\views\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\common_base;

class already_config extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Already config";
        $this->position = array("Already config");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Already config!",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        "Go to home",
                        url::get(array(\swdf::$app->name, "guest/home.show",""), array(), ""),
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
        $this->text = "Already config!";
    }
}
?>
