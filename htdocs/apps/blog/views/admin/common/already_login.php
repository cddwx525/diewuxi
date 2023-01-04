<?php
namespace blog\views\admin\common;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\admin_base;

class already_login extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Already login";
        $this->position = array("Already login");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Already login!",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        "Go to administration home",
                        url::get(array(\swdf::$app->name, "admin/home.show",""), array(), ""),
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
        $this->text = "Already login!";
    }
}
?>
