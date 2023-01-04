<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class add extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Add article";
        $this->position = array("Add article");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Add article",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Article added Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/article.show", ""),
                            array("id" => $this->data["article"]->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) .
                    html::a(
                        "Article list",
                        url::get(
                            array(\swdf::$app->name, "admin/article.list_all", ""),
                            array(),
                            ""
                        ),
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
        $this->text = "Add successfully.";
    }
}
?>
