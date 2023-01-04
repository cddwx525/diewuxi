<?php
namespace blog\views\admin\config;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\common_base;

class write extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Write config";
        $this->position = array("Write config");
        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Write config(* is necessary)",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "admin/config.save", ""), array(), "") . "\" method=\"post\">" . "\n" .
            "<label>* Blog name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"blog_name\" value=\"\" id=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Blog description:</label>" . "\n" .
            "<p><input type=\"text\" name=\"blog_description\" value=\"\" id=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Admin user name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"name\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Admin user password:</label>" . "\n" .
            "<p><input type=\"password\" name=\"password\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<p><input type=\"submit\" name=\"send\" value=\"Save\" class=\"input-submit\" /></p>" . "\n" .
            "</form >",
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
