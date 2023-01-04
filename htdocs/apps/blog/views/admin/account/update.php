<?php
namespace blog\views\admin\account;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class update extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Update account";
        $this->position = array("Update account");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Update account",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Account updated Successfully! Need relogin",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Go to login",
                        url::get(array(\swdf::$app->name, "admin/authentication.write", ""), array(), ""),
                        array("class" => "text-padding")
                    ),
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
        $this->text = "Update successfully.";
    }
}
?>
