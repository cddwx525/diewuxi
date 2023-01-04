<?php
namespace main\views;

use swdf\helpers\html;
use main\views\layouts\base;

class not_found extends base
{
    public function set_items()
    {
        $this->title = "Not found";
        $this->position = array("Not Found");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Not Found!",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Your request page: \"" . \swdf::$app->request["url"] . "\" is not found on this server.",
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
        $this->text = "Not Found!";
    }
}
?>
