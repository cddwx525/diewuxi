<?php
namespace blog\views\guest\article;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\articles_position;
use blog\widgets\tag_list;
use blog\widgets\category_path;
use blog\widgets\comment_tree;
use blog\lib\Michelf\MarkdownExtra;

class slug_show extends guest_base
{
    protected function set_items()
    {
        $this->description = $this->data["article"]->record["description"];
        $this->keywords = $this->data["article"]->record["keywords"];
        $this->css = array(url::get_static("css/github-markdown.css"),);

        //$this->js = array(
        //    html::inline_tag(
        //        "script",
        //        "MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}, processEscapes: true, TeX: {extensions: [\"mhchem.js\"]}})",
        //        array("type" => "text/x-mathjax-config",)
        //    ),
        //    html::inline_tag(
        //        "script",
        //        "",
        //        array(
        //            "type" => "text/javascript",
        //            "async src" => "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML",
        //        )
        //    ),
        //);

        $this->title = htmlspecialchars($this->data["article"]->record["title"]);
        $this->position = articles_position::widget(array("data" => $this->data["article"]->get_category()->get_path()));
        $this->position[] = htmlspecialchars($this->data["article"]->record["title"]);

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                htmlspecialchars($this->data["article"]->record["title"]),
                array("class" => "text-center")
            ) . "\n" .
            html::mono_tag("hr", array()) . "\n\n" .

            html::tag(
                "div",
                html::tag(
                    "table",
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Date:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . $this->data["article"]->record["date"] . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Description:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . htmlspecialchars($this->data["article"]->record["description"]) . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Keywords:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . htmlspecialchars($this->data["article"]->record["keywords"]) . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Category:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . category_path::widget(array("data" => $this->data["article"]->get_category())) . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Tag:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . tag_list::widget(array("data" => $this->data["article"]->get_tags())) . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Link:", array("class" => "text-right")) . "\n" .
                        html::inline_tag(
                            "td",
                            html::inline_tag(
                                "span",
                                url::get(
                                    array(\swdf::$app->name, "guest/article.slug_show", ""),
                                    array("full_slug" => $this->data["article"]->get_full_slug()),
                                    ""
                                ),
                                array()
                            ),
                            array()
                        ),
                        array()
                    ),
                    array("class" => "table-noborder")
                ),
                array()
            ) . "\n" .
            html::mono_tag("hr", array()) . "\n\n" .

            html::tag(
                "div",
                MarkdownExtra::defaultTransform($this->data["article"]->record["content"]),
                array("class" => "markdown-body block-padding")
            ) . "\n" .
            html::mono_tag("hr", array()) . "\n\n" .

            html::inline_tag(
                "h3",
                "Comments [" . $this->data["article"]->get_comment_count() . "]",
                array()
            ) . "\n\n" .
            comment_tree::widget(array("data" => $this->data["root_comments"])) . "\n" .
            html::mono_tag("hr", array()) . "\n\n" .

            html::inline_tag(
                "h3",
                "Write comment(* is necessary, and email is not shown to public)",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "guest/comment.add", ""), array(), "") . "\" method=\"post\">" . "\n\n" .
            "<p><input type=\"hidden\" name=\"article_id\" value=\"" . $this->data["article"]->record["id"] . "\" /></p>" . "\n" .
            "<p><input type=\"hidden\" name=\"target_id\" value=\"" . "NULL" . "\" /></p>" . "\n\n" .

            "<label>* Name:</label>" . "\n" .
            "<p><input type=\"text\" name=\"user\" value=\"\" id=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Email:</label>" . "\n" .
            "<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>Website:</label>" . "\n" .
            "<p><input type=\"text\" name=\"site\" value=\"\" class=\"input-text\" /></p>" . "\n\n" .

            "<label>* Content:</label>" . "\n" .
            "<p><textarea name=\"content\" class=\"textarea\"></textarea></p>" . "\n\n" .

            "<p><input type=\"submit\" name=\"send\" value=\"Send\" class=\"input-submit\" /></p>" . "\n" .
            "</form >",
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
