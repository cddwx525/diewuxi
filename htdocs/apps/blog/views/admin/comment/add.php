<?php
namespace blog\views\admin\comment;

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
        $this->title = "Comment under: [" . $this->data["article"]->record["title"] . "]";
        $this->position = array("Add comment");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Comment under: [" . htmlspecialchars($this->data["article"]->record["title"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::inline_tag(
                    "p",
                    "comment added Successfully!",
                    array("class" => "text-center")
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/article.show", ""),
                            array("id" => $this->data["article"]->record["id"]),
                            $this->data["comment"]->record["id"]
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
        $this->text = "Add successfully.";
    }
}
?>
