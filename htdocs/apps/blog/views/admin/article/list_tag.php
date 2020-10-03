<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_article_list;

class list_tag extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Articles in tag [" . $this->data["tag"]["name"] . "]";
        $this->position = array("Articles in tag [" . htmlspecialchars($this->data["tag"]["name"]) . "]");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "p",
                html::a(
                    "Write an article.",
                    url::get(
                        array(\swdf::$app->name, "admin/article.write", ""),
                        array(),
                        ""
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "Articles in tag [" . $this->data["tag"]["name"] . "]",
                array()
            ) . "\n\n" .
            admin_article_list::widget(array("data" => $this->data["articles"])),
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
