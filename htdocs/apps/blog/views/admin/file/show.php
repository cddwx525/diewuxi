<?php
namespace blog\views\admin\file;

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
        $this->css = array(url::get_static("css/github-markdown.css"),);

        $this->title = "File: [" . $this->data["file"]->record["name"] . "]";
        $this->position = array("Show file");

        $this->main = html::tag(
            "div",
            html::inline_tag(
                "h3",
                "File: [" . $this->data["file"]->record["name"] . "]",
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::tag(
                    "ul",
                    "<li><span>Id: </span><span>" . $this->data["file"]->record["id"] . "</span></li>" . "\n" .
                    "<li><span>Date: </span><span>" . $this->data["file"]->record["date"] . "</span></li>" . "\n" .
                    "<li><span>Name: </span><span>" . $this->data["file"]->record["name"] . "</span></li>" . "\n" .
                    "<li><span>Related articles: </span><span>" . $this->data["file"]->get_article_count() . "</span></li>" . "\n" .
                    html::inline_tag(
                        "li",
                        html::inline_tag("span", "Link: ", array()) .
                        html::inline_tag("span", $this->data["file"]->get_url(), array()),
                        array()
                    ),
                    array()
                ),
                array()
            ) . "\n\n" .
            html::tag(
                "div",
                html::a(
                    html::mono_tag(
                        "img",
                        array("src" => $this->data["file"]->get_url(), "alt" => htmlspecialchars($this->data["file"]->record["name"]))
                    ),
                    $this->data["file"]->get_url(),
                    array()
                ),
                array("class" => "markdown-body")
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
