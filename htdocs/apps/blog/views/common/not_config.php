<?php
namespace blog\views\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\common_base;

class not_config extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Not configed";
        $this->position = array("Not configed");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Not configed!",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        "Go to config",
                        url::get(array(\swdf::$app->name, "admin/config.write",""), array(), ""),
                        array()
                    ),
                    array()
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
        $this->text = "Not Found!";
    }
}
?>
