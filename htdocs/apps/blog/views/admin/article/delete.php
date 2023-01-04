<?php
namespace blog\views\admin\article;

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
        $this->title = "Delete article: [" . $this->data["article"]->record["title"] . "]";
        $this->position = array("Delete article");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Delete article: [" . htmlspecialchars($this->data["article"]->record["title"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "Article deleted Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
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
        $this->text = "Delete successfully.";
    }
}
?>
