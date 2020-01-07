<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class show extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $comment_count = $result["comment_count"];
        $comments = $result["comments"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $description = $article["description"];
        $keywords = $article["keywords"];
        $css = array($url->get_static($app_space_name, "css/github-markdown.css"),);
        $js = array();
        $js[] = "<script type=\"text/x-mathjax-config\">MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\\\(','\\\\)']]}, processEscapes: true, TeX: {extensions: [\"mhchem.js\"]}});</script>
<script type=\"text/javascript\" async src=\"https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML\"></script>";
        $title = $article["title"];

        $position = " > <a href=\"" . $url->get(array($app_space_name, "admin/article.list_all", ""), array(), "") . "\">Articles</a> > <a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">". htmlspecialchars($article["title"]) . "</a>";


        if (empty($article["tag"]))
        {
            $article_tag_links = "<span>NULL</span>";
        }
        else
        {
            $article_tag_links = array();
            foreach ($article["tag"] as $tag)
            {
                $article_tag_links[] = "<a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $tag["id"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
            }
            $article_tag_links = implode(", ", $article_tag_links);
        }



        if (empty($comments))
        {
            $comment_list = "<h3 class=\"bg-primary\">Comments [" . $comment_count . "]</h3>
<p>There is no comments now.</p>";
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
                        $author_part = "<span class=\"text-warning\">[Author]</span>";
                    }
                    else
                    {
                        $author_part = "";
                    }

                    $list[] = "<li id=\"" . $comment["id"] . "\"><div>
<div class=\"bg-info\">
" . $author_part . "<span>" . htmlspecialchars($comment["user"]) . "</span><span class=\"pull-right\">[" . $comment["number"] . "#]</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $comment["id"]), "") . "\">Delete</a></span>
</div>

</div></li>
<ul>
" . $this->comment_output($result, $comment["reply"], $article, array(), $url, $indent, $indent_constant) . "
</ul>";
                }
                else
                {
                    if ($comment["author"] === "1")
                    {
                        $author_part = "<span class=\"text-warning\">[Author]</span>";
                    }
                    else
                    {
                        $author_part = "";
                    }

                    $list[] = "<li id=\"" . $comment["id"] . "\"><div>
<div class=\"bg-info\">
" . $author_part . "<span>" . htmlspecialchars($comment["user"]) . "</span><span class=\"pull-right\">[" . $comment["number"] . "#]</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $comment["id"]), "") . "\">Delete</a></span>
</div>

</div></li>";
                }
            }
            $list = implode("\n", $list);

            $comment_list = "<ul class=\"list-unstyled\">
" . $list . "
</ul> ";
        }


        $content = "<h3 class=\"bg-primary\">Article: [" . htmlspecialchars($article["title"]) . "]</h3>

<h3 class=\"article_title\">" . htmlspecialchars($article["title"]) . "</h3>

<div class=\"bg-info\">
<ul>
<li><span>Date: </span><span class=\"text-muted\">" . $article["date"] . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . $article["slug"] . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . $article["description"] . "</span></li>
<li><span>Keywords: </span><span class=\"text-muted\">" . $article["keywords"] . "</span></li>
<li><span>Category: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $article["category_id"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></span></li>
<li><span>Tag: </span><span>" . $article_tag_links . "</span></li>
<li><span>Link: </span><span class=\"text-success\">" . $url->get(array($app_space_name, "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "</span></li>
<li><span>License: </span><span class=\"text-warning\"><a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/3.0/\">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a></span></li>
</ul>
</div>

<div class=\"markdown-body\">
" . $article["content"] . "
</div>

<h3 class=\"bg-primary\">Comments [" . $comment_count . "]</h3>

" . $comment_list . "

<h3 class=\"bg-primary\">Write comment(* is necessary, and email is not shown to public)</h3>

<form action=\"" . $url->get(array($app_space_name, "admin/comment.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"article_id\" value=\"" . $article["id"] . "\" /></p>
<p><input type=\"hidden\" name=\"target_id\" value=\"" . "NULL" . "\" /></p>

<p>* Is author(bool):</p>
<p><input type=\"checkbox\" name=\"author\" value=\"TRUE\" /></p>

<p>* Name(vchar(32)):</p>
<p><input type=\"text\" name=\"user\" value=\"\" id=\"\" class=\"input_text\" /></p>

<p>* Email(vchar(256)):</p>
<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input_text\" /></p>

<p>Website(vchar(256)):</p>
<p><input type=\"text\" name=\"site\" value=\"\" class=\"input_text\" /></p>

<p>* Content(text):</p>
<p><textarea name=\"content\" class=\"textarea\"></textarea></p>

<p><input type=\"submit\" name=\"send\" value=\"Send\" class=\"input_submit\" /></p>
</form >";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

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


    private function comment_output($result, $comments, $article, $list, $url, $indent, $indent_constant)
    {
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        foreach ($comments as $comment)
        {
            if (isset($comment["reply"]))
            {
                if ($comment["author"] === "1")
                {
                    $author_part = "<span class=\"text-warning\">[Author]</span>";
                }
                else
                {
                    $author_part = "";
                }

                $list[] = $indent . "<li id=\"" . $comment["id"] . "\"><div>
<div class=\"bg-info\">
" . $author_part . "
<span>" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $comment["id"]), "") . "\">Delete</a></span>
</div>

</div></li>
" . $indent . "<ul>
" . $this->comment_output($result, $comment["reply"], $article, array(), $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                if ($comment["author"] === "1")
                {
                    $author_part = "<span class=\"text-warning\">[Author]</span>";
                }
                else
                {
                    $author_part = "";
                }

                $list[] = $indent . "<li id=\"" . $comment["id"] . "\"><div>
<div class=\"bg-info\">
" . $author_part . "
<span>" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.write", ""), array("article_id" => $article["id"], "target_id" => $comment["id"]), "") . "\">Reply</a></span> <span><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $comment["id"]), "") . "\">Delete</a></span>
</div>

</div></li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
