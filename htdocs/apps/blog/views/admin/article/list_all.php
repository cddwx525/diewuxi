<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_article_list;

class list_all extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "All articles";
        $this->position = array("Articles");

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
                "All articles",
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
