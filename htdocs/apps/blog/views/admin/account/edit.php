<?php
namespace blog\views\admin\account;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class edit extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Edit account setting";
        $this->position = array("Edit account setting");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Edit account setting(* is necessary)",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "admin/account.update", ""), array(), "") . "\" method=\"post\">" . "\n" .
            "<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $this->data["form_stamp"] . "\" /></p>" . "\n\n" .

            "<label>* User name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"name\" value=\"" . $this->data["user"]->record["name"] . "\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* User password:</label>" . "\n" .
            "<p><input type=\"password\" name=\"password\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* User password confirm:</label>" . "\n" .
            "<p><input type=\"password\" name=\"confirm_password\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* User CURRENT password:</label>" . "\n" .
            "<p><input type=\"password\" name=\"current_password\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input-submit\" /></p>" . "\n" .
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
