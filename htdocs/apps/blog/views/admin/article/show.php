<?php
namespace blog\views\admin\article;

use swdf\helpers\url;
use swdf\helpers\html;
use blog\views\layouts\admin_base;
use blog\widgets\admin_category_path;
use blog\widgets\admin_tags;
use blog\widgets\admin_comment_tree;
use blog\lib\Michelf\MarkdownExtra;

class show extends admin_base
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

        $this->title = "Article: [" . $this->data["article"]->record["title"] . "]";
        $this->position = array("Show article");

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
                        html::inline_tag("td", "<span>" . admin_category_path::widget(array("data" => $this->data["article"]->get_category())) . "</span>", array()),
                        array()
                    ) . "\n" .
                    html::tag(
                        "tr",
                        html::inline_tag("td", "Tag:", array("class" => "text-right")) . "\n" .
                        html::inline_tag("td", "<span>" . admin_tags::widget(array("data" => $this->data["article"]->get_tags())) . "</span>", array()),
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
            html::inline_tag(
                "p",
                html::a(
                    "Comments table",
                    url::get(array(\swdf::$app->name, "admin/comment.list_by_article", ""), array("article_id" => $this->data["article"]->record["id"]), ""),
                    array()
                ),
                array()
            ) . "\n\n" .
            admin_comment_tree::widget(array("data" => $this->data["root_comments"])) . "\n" .
            html::mono_tag("hr", array()) . "\n\n" .

            html::inline_tag(
                "h3",
                "Write comment(* is necessary, and email is not shown to public)",
                array()
            ) . "\n\n" .
            html::tag(
                "form",
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "form_stamp", "value" => $this->data["form_stamp"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "article_id", "value" => $this->data["article"]->record["id"])),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "hidden", "name" => "target_id", "value" => "NULL")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Is author:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "checkbox", "name" => "author", "checked" => "true")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Name:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "user", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Email:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "mail", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "Website:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "text", "name" => "site", "value" => "", "class" => "input-text")),
                    array()
                ) . "\n\n" .
                html::inline_tag("p", "* Content:", array()) . "\n" .
                html::inline_tag(
                    "p",
                    html::inline_tag("textarea", "", array("name" => "content", "class" => "textarea")),
                    array()
                ) . "\n\n" .
                html::inline_tag(
                    "p",
                    html::mono_tag("input", array("type" => "submit", "name" => "add", "value" => "Add", "class" => "input-submit")),
                    array()
                ),
                array(
                    "action" => url::get(array(\swdf::$app->name, "admin/comment.add", ""), array(), ""),
                    "method" => "post"
                )
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
