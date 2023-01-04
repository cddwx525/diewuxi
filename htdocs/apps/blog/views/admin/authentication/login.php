<?php
namespace blog\views\admin\authentication;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\common_base;

class login extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Login";
        $this->position = array("Login");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Login",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Login successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Administrator home",
                        url::get(
                            array(\swdf::$app->name, "admin/home.show", ""),
                            array(),
                            ""
                        ),
                        array()
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
        $this->text = "";
    }
}
?>
