<?php
namespace blog\views\admin\tag;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;

class show extends admin_base
{
    /**
     *
     *
     */
    protected function set_items()
    {
        $this->title = "Tag: [" . $this->data["tag"]->record["name"] . "]";
        $this->position = array("Show tag");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Tag: [" . htmlspecialchars($this->data["tag"]->record["name"]) . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    "<li><span>Name: </span><span>" . htmlspecialchars($this->data["tag"]->record["name"]) . "</span></li>" . "\n" .
                    "<li><span>Slug: </span><span>" . htmlspecialchars($this->data["tag"]->record["slug"]) . "</span></li>" . "\n" .
                    "<li><span>Description: </span><span>" . htmlspecialchars($this->data["tag"]->record["description"]) . "</span></li>" . "\n" .
                    "<li><span>Articles: </span><span>" . html::a(
                        $this->data["tag"]->get_article_count(),
                        url::get(array(\swdf::$app->name, "admin/article.list_by_tag", ""), array("tag_id" => $this->data["tag"]->record["id"]), ""),
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
