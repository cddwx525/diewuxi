<?php
namespace blog\views\admin\option;

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
        $this->title = "Update site option";
        $this->position = array("Update site option");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Update site option",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Site option updated Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Return to homepage.",
                        url::get(array(\swdf::$app->name, "admin/home.show", ""), array(), ""),
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
