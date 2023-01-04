<?php
namespace blog\views\admin\option;

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
        $this->title = "Edit site option";
        $this->position = array("Edit site option");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Edit site option",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "admin/option.update", ""), array(), "") . "\" method=\"post\">" . "\n" .
            "<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $this->data["form_stamp"] . "\" /></p>" . "\n\n" .

            "<label>* Blog name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"blog_name\" value=\"" . \swdf::$app->data["options"]["blog_name"] . "\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>Blog description:</label>" . "\n" .
            "<p><textarea name=\"blog_description\" class=\"textarea\">" . \swdf::$app->data["options"]["blog_description"] . "</textarea></p>" . "\n\n" .

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
