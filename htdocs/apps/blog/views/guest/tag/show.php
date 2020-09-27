<?php
namespace blog\views\guest\tag;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;

class show extends guest_base
{
    protected function set_items()
    {
        $this->title = "Tag: [" . htmlspecialchars($this->data["tag"]["name"]) . "]";
        $this->position = array(
            html::a(
                "Tags",
                url::get(array(\swdf::$app->name, "guest/tag.list_all", ""), array(), ""),
                array()
            ),
            htmlspecialchars($this->data["tag"]["name"])
        );


        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Tag: [" . htmlspecialchars($this->data["tag"]["name"]) . "]", array()) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Name: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["tag"]["name"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Description: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["tag"]["description"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Articles: ", array()) .
                        html::inline_tag(
                            "span",
                            html::a(
                                htmlspecialchars($this->data["tag"]["article_count"]),
                                url::get(
                                    array(\swdf::$app->name, "guest/article.slug_list_tag", ""),
                                    array("tag_slug" => $this->data["tag"]["slug"]),
                                    ""
                                ),
                                array()
                            ),
                            array()
                        ),
                        array()
                    ),
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
