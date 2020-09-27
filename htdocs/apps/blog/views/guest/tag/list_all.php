<?php
namespace blog\views\guest\tag;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\tags;

class list_all extends guest_base
{
    protected function set_items()
    {
        $this->title = "All tags";
        $this->position = array("Tags");

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "All tags", array()) . "\n" .
            tags::widget(array("data" => $this->data["tags"])),
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
