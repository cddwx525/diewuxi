<?php
namespace blog\views\guest\article;

use swdf\helpers\html;
use swdf\helpers\url;
use blog\views\layouts\guest_base;
use blog\widgets\articles_position;
use blog\widgets\tag_list;
use blog\widgets\category_path;
use blog\widgets\comment_tree;

class show extends guest_base
{
    protected function set_items()
    {
        $this->description = $this->data["article"]["description"];
        $this->keywords = $this->data["article"]["keywords"];
        $this->css = array(url::get_static(\swdf::$app->name, "css/github-markdown.css"),);

        $this->js = array(
            html::inline_tag(
                "script",
                "MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}, processEscapes: true, TeX: {extensions: [\"mhchem.js\"]}})",
                array("type" => "text/x-mathjax-config",)
            ),
            html::inline_tag(
                "script",
                "",
                array(
                    "type" => "text/javascript",
                    "async src" => "https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML",
                )
            ),
        );

        $this->title = htmlspecialchars($this->data["article"]["title"]);
        $this->position = articles_position::widget(array("data" => $this->data["article"]["category"]["path"]));
        $this->position[] = htmlspecialchars($this->data["article"]["title"]);

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "Article: [" . htmlspecialchars($this->data["article"]["title"]) . "]",
                array()
            ) . "\n" .
            html::inline_tag(
                "h4",
                htmlspecialchars($this->data["article"]["title"]),
                array("class" => "text-center")
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    "<li><span>Date: </span><span>" . $this->data["article"]["date"] . "</span></li>" . "\n" .
                    "<li><span>Description: </span><span>" . $this->data["article"]["description"] . "</span></li>" . "\n" .
                    "<li><span>Keywords: </span><span>" . $this->data["article"]["keywords"] . "</span></li>" . "\n" .
                    "<li><span>Category: </span><span>" . category_path::widget(array("data" => $this->data["article"]["category"])) . "</span></li>" . "\n" .
                    "<li><span>Tag: </span><span>" . tag_list::widget(array("data" => $this->data["article"]["tags"])) . "</span></li>" . "\n" .
                    "<li><span>Link: </span><span>" . url::get(
                        array(\swdf::$app->name, "guest/article.slug_show", ""),
                        array("full_slug" => $this->data["article"]["full_slug"]),
                        ""
                    ) . "</span></li>",
                    array()
                ),
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                $this->data["article"]["content"],
                array("class" => "markdown-body")
            ) . "\n\n" .
            html::inline_tag(
                "h3",
                "Comments [" . $this->data["article"]["comment_count"] . "]",
                array()
            ) . "\n\n" .
            comment_tree::widget(array("data" => $this->data["article"]["comment_tree"])) . "\n\n" .
            html::inline_tag(
                "h3",
                "Write comment(* is necessary, and email is not shown to public)",
                array()
            ) . "\n\n" .
            "<form action=\"" . url::get(array(\swdf::$app->name, "guest/comment.add", ""), array(), "") . "\" method=\"post\">" . "\n\n" .
            "<p><input type=\"hidden\" name=\"article_id\" value=\"" . $this->data["article"]["id"] . "\" /></p>" . "\n" .
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
