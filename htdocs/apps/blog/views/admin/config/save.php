<?php
namespace blog\views\admin\config;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\common_base;

class save extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Save config";
        $this->position = array("Save config");
        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Save config",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Save config Successfully!",
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
        $this->text = "Save config successfully.";
    }
}
?>
