<?php
namespace blog\views\admin\authentication;

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
        $this->title = "Login write";
        $this->position = array("Login write");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Login write",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "admin/authentication.login", ""), array(), "") . "\" method=\"post\">" . "\n" .
            "<label>Username:</label>" . "\n" .
            "<p><input type=\"text\" name=\"name\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>Password:</label>" . "\n" .
            "<p><input type=\"password\" name=\"password\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>Remember me</label>" . "\n" .
            "<p><input type=\"checkbox\" name=\"remember\" value=\"TRUE\" /></p>" . "\n\n" .

            "<p><input type=\"submit\" name=\"\" value=\"Login\" class=\"input-submit\" /></p>" . "\n" .
            "</form>",
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
