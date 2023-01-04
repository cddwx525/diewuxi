<?php
namespace blog\views\admin\comment;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class delete extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Delete comment";
        $this->position = array("Delete comment");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Delete comment",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Comment deleted Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "Article",
                        url::get(
                            array(\swdf::$app->name, "admin/article.show", ""),
                            array("id" => $this->data["comment"]->get_article()->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding")
                    ) .
                    html::a(
                        "Comment list",
                        url::get(
                            array(\swdf::$app->name, "admin/comment.list_all", ""),
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
        $this->text = "Delete successfully.";
    }
}
?>
