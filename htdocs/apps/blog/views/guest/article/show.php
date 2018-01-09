<?php
namespace blog\views\guest\article;

use blog\lib\url;
use blog\lib\views\guest_base;

class show extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $comment_count = $result["comment_count"];
        $comments = $result["comments"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $description = $article["description"];
        $keywords = $article["keywords"];
        $css = array($url->get_static($app_space_name, "css/github-markdown.css"),);
        $js = array();
        $js[] = "<script type=\"text/x-mathjax-config\">MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}, processEscapes: true, TeX: {extensions: [\"mhchem.js\"]}});</script>
<script type=\"text/javascript\" async src=\"https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML\"></script>";
        $title = $article["title"];


        $categories_link_list = array();
        foreach ($article["category"]["all_levels"]  as $category)
        {
            $categories_link_list[] = "<a href=\"" . $url->get(array($app_space_name, "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a>";
        }


        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_all", ""), array(), "") . "\">All articles</a> > " . implode(" > ", $categories_link_list) . " > " . htmlspecialchars($article["title"]);


        if (empty($article["tag"]))
        {
            $article_tag_links = "<span>NULL</span>";
        }
        else
        {
            $article_tag_links = array();
            foreach ($article["tag"] as $tag)
            {
                $article_tag_links[] = "<a href=\"" . $url->get(array($app_space_name, "guest/tag.slug_show", ""), array("tag_slug" => $tag["slug"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
            }
            $article_tag_links = implode(", ", $article_tag_links);
        }


        if (empty($comments))
        {
            $comment_list = "<p>There is no comments now.</p>";
        }
        else
        {
            $list = array();
            $indent = "";
            $indent_constant = "";
            foreach ($comments as $comment)
            {
                if (isset($comment["reply"]))
                {
                    if ($comment["author"] === "1")
                    {
                        $author_part = "<span class=\"author\">[Author]</span>";
                    }
                    else
                    {
                        $author_part = "";
                    }

                    $list[] = "<li id=\"" . $comment["id"] . "\"><div class=\"comment_entry border_frame\">
<div class=\"comment_entry_header\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span><span class=\"floor\">[" . $comment["number"] . "#]</span>
</div>
<div class=\"comment_entry_content\">" . htmlspecialchars($comment["content"]) . "</div>
<div class=\"comment_entry_information\"><span class=\"description\">" . $comment["date"] . "</span> <span class=\"description\"><a href=\"" . $url->get(array($app_space_name, "guest/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"] ), "") . "\">Reply</a></span>
</div>
</div></li>

<ul>
" . $this->comment_output($comment["reply"], $article, $result, $url, $indent, $indent_constant) . "
</ul>";
                }
                else
                {
                    if ($comment["author"] === "1")
                    {
                        $author_part = "<span class=\"author\">[Author]</span>";
                    }
                    else
                    {
                        $author_part = "";
                    }

                    $list[] = "<li id=\"" . $comment["id"] . "\"><div class=\"comment_entry border_frame\">
<div class=\"comment_entry_header\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span><span class=\"floor\">[" . $comment["number"] . "#]</span>
</div>
<div class=\"comment_entry_content\">" . htmlspecialchars($comment["content"]) . "</div>
<div class=\"comment_entry_information\">
<span class=\"description\">" . $comment["date"] . "</span> <span class=\"description\"><a href=\"" . $url->get(array($app_space_name, "guest/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span>
</div>
</div></li>";
                }
            }
            $list = implode("\n", $list);

            $comment_list = "<ul>
" . $list . "
</ul>";
        }


        $content = "<div class=\"content_title border_frame\">
<h3>Article: [" . htmlspecialchars($article["title"]) . "]</h3>
</div>

<div id=\"article\" class=\"border_frame\">
<h3 id=\"article_title\">" . htmlspecialchars($article["title"]) . "</h3>

<div id=\"article_information\">
<ul>
<li><span>Date: </span><span class=\"description\">" . $article["date"] . "</span></li>
<li><span>Slug: </span><span class=\"description\">" . $article["slug"] . "</span></li>
<li><span>Description: </span><span class=\"description\">" . $article["description"] . "</span></li>
<li><span>Keywords: </span><span class=\"description\">" . $article["keywords"] . "</span></li>
<li><span>Category: </span><span>" . implode(" > ", $categories_link_list) . "</span></li>
<li><span>Tag: </span><span>" . $article_tag_links . "</span></li>
<li><span>Link: </span><span class=\"description\">" . $url->get(array($app_space_name, "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "</span></li>
<li><span>License: </span><span class=\"description\"><a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/3.0/\">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a></span></li>
</ul>
</div>

<div id=\"article_maintext\" class=\"markdown-body\">" . $article["content"] . "</div>
</div>

<div class=\"content_title border_frame\">
<h3>Comments [" . $comment_count . "]</h3>
</div>

<div id=\"comment_list\" class=\"border_frame\">
" . $comment_list . "
</div>

<div class=\"content_title border_frame\">
<h3>Write comment(* is necessary, and email is not shown to public)</h3>
</div>

<div id=\"write_comment\" class=\"border_frame\">
<form action=\"" . $url->get(array($app_space_name, "guest/comment.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"article_id\" value=\"" . $article["id"] . "\" /></p>
<p><input type=\"hidden\" name=\"target_id\" value=\"" . "NULL" . "\" /></p>

<label>* Name(vchar(32)):</label>
<p><input type=\"text\" name=\"user\" value=\"\" id=\"\" class=\"input_text\" /></p>

<label>* Email(vchar(256)):</label>
<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input_text\" /></p>

<label>Website(vchar(256)):</label>
<p><input type=\"text\" name=\"site\" value=\"\" class=\"input_text\" /></p>

<label>* Content(text):</label>
<p><textarea name=\"content\" class=\"textarea\"></textarea></p>

<p><input type=\"submit\" name=\"send\" value=\"Send\" class=\"input_submit\" /></p>
</form >
</div>";


        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

        return array(
            "description" => $description,
            "keywords" => $keywords,
            "css" => $css,
            "js" => $js,
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    private function comment_output($comments, $article, $result, $url, $indent, $indent_constant)
    {
        $list = array();
        foreach ($comments as $comment)
        {
            if (isset($comment["reply"]))
            {
                if ($comment["author"] === "1")
                {
                    $author_part = "<span class=\"author\">[Author]</span>";
                }
                else
                {
                    $author_part = "";
                }

                $list[] = $indent . "<li id=\"" . $comment["id"] . "\"><div class=\"comment_entry border_frame\">
<div class=\"comment_entry_header\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div class=\"comment_entry_content\">" . htmlspecialchars($comment["content"]) . "</div>

<div class=\"comment_entry_information\">
<span class=\"description\">" . $comment["date"] . "</span> <span class=\"description\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span>
</div>
</div></li>
" . $indent . "<ul>
" . $this->comment_output($comment["reply"], $article, $result, $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                if ($comment["author"] === "1")
                {
                    $author_part = "<span class=\"author\">[Author]</span>";
                }
                else
                {
                    $author_part = "";
                }

                $list[] = $indent . "<li id=\"" . $comment["id"] . "\"><div class=\"comment_entry border_frame\">
<div class=\"comment_entry_header\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div class=\"comment_entry_content\">" . htmlspecialchars($comment["content"]) . "</div>

<div class=\"comment_entry_information\">
<span class=\"description\">" . $comment["date"] . "</span> <span class=\"description\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span>
</div>
</div></li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
