<?php
namespace blog\views\admin\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\admin_base;

class message extends admin_base
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
                    $this->data["message"],
                    array("class" => "text-warning text-center")
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::a("Back", $this->data["back_url"], array()),
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
        $this->text = $this->data["message"];
    }
}
?>
