<?php
namespace blog\views\guest\category;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\categories;

class list_all extends guest_base
{
    protected function set_items()
    {
        $this->title = "All categories";
        $this->position = array("Categories");
        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "All categories", array()) . "\n\n" .
            categories::widget(array("data" => $this->data["category_tree"])),
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
