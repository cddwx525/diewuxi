<?php
namespace blog\views\admin\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_comment_table;

class list_by_article extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Comments in article: [" . $this->data["article"]->record["title"] . "]";
        $this->position = array("Comments in article");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Comments in article: [" . htmlspecialchars($this->data["article"]->record["title"]) . "]",
                array()
            ) . "\n\n" .
            admin_comment_table::widget(array("data" => $this->data["comments"])),
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
