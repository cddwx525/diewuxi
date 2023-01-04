<?php
namespace blog\views\admin;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_path;

class settings extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Settings";
        $this->position = array("Settings");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Settings",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    "<li>" . html::a("Account settings", url::get(array(\swdf::$app->name, "admin/account.edit", ""), array(), ""), array()) . "</li>" . "\n" .
                    "<li>" . html::a("Site options", url::get(array(\swdf::$app->name, "admin/option.edit", ""), array(), ""), array()) . "</li>" ,
                    array()
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
        $this->text = "";
    }
}
?>
