<?php
namespace blog\views\admin\authentication;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\common_base;

class logout extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Logout";
        $this->position = array("Logout");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Logout",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Login successfully!",
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Home",
                        url::get(
                            array(\swdf::$app->name, "guest/home.show", ""),
                            array(),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) . "\n" .
                    html::a(
                        "Relogin",
                        url::get(
                            array(\swdf::$app->name, "admin/authentication.write", ""),
                            array(),
                            ""
                        ),
                        array("class" => "text-padding")
                    ),
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
