<?php
namespace blog\views\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\common_base;

class not_login extends common_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Not login";
        $this->position = array("Not login");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Not login!",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        "Go to login",
                        url::get(array(\swdf::$app->name, "admin/authentication.write",""), array(), ""),
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
        $this->text = "Not Found!";
    }
}
?>
