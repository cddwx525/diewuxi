<?php
namespace blog\views\guest\category;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\categories_position;

class show extends guest_base
{
    public function set_items()
    {
        $this->title = "Category: [" . $this->data["category"]["full_name"] . "]";
        $this->position = categories_position::widget(array("data" => array_slice($this->data["category"]["path"], 0, -1)));
        $this->position[] = htmlspecialchars($this->data["category"]["name"]);

        $this->main = html::tag(
            "div",
            html::inline_tag("h3", "Category: [" . htmlspecialchars($this->data["category"]["full_name"]) . "]", array()) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Name: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["category"]["full_name"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Description: ", array()) .
                        html::inline_tag("span", htmlspecialchars($this->data["category"]["description"]), array()),
                        array()
                    ) . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Articles: ", array()) .
                        html::inline_tag(
                            "span",
                            html::a(
                                htmlspecialchars($this->data["category"]["article_count"]),
                                url::get(
                                    array(\swdf::$app->name, "guest/article.slug_list_category", ""),
                                    array("full_category_slug" => $this->data["category"]["full_slug"]),
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
