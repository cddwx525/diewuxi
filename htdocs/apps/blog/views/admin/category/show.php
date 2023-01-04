<?php
namespace blog\views\admin\category;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_path;

class show extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Category: [" . $this->data["category"]->get_full_name() . "]";
        $this->position = array("Show category");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Category: [" . $this->data["category"]->get_full_name() . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    "<li><span>Full name: </span><span>" . htmlspecialchars($this->data["category"]->get_full_name()) . "</span></li>" . "\n" .
                    "<li><span>Full slug: </span><span>" . htmlspecialchars($this->data["category"]->get_full_slug()) . "</span></li>" . "\n" .
                    "<li><span>Description: </span><span>" . htmlspecialchars($this->data["category"]->record["description"]) . "</span></li>" . "\n" .
                    "<li><span>Path link: </span><span>" . admin_category_path::widget(array("data" => $this->data["category"])) . "</span></li>" . "\n" .
                    "<li><span>Articles: </span><span>" . html::a(
                        $this->data["category"]->get_article_count(),
                        url::get(array(\swdf::$app->name, "admin/article.list_by_category", ""), array("category_id" => $this->data["category"]->record["id"]), ""),
                        array()
                    ) . "</span></li>",
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
