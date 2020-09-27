<?php
namespace blog\views\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;

class message extends guest_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Message from: [" . $this->data["source"] . "]";
        $this->position = array("Message");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Message from: [" . $this->data["source"] . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    $this->data["message"] . " Comment failed!",
                    array("class" => "text-error")
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
        $this->text = $this->data["message"] . "Comment failed!";
    }
}
?>
