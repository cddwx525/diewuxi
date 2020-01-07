<?php
namespace blog\views\guest\comment;

use blog\lib\url;
use blog\lib\views\guest_base;

class write extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $comment = $result["comment"];


        $title = "Write comment under [" . $article["title"] . "]";

        $position = " > Write comment";


        if ($comment["author"] === "1")
        {
            $author_part = "<span class=\"text-warning\">[Author]</span>";
        }
        else
        {
            $author_part = "";
        }


        $content = "<h3 class=\"bg-primary\">Comment</h3>

<p>Under article [<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</p>
<p>Reply to :</p>

<div id=\"" . $comment["id"] . "\">
<div class=\"bg-info\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<span class=\"text-info\">" . $comment["date"] . "</span>
</div>

<h3 class=\"bg-primary\">Write comment(* is necessary, and email is not shown to public)</h3>

<form action=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/comment.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"article_id\" value=\"" . $article["id"] . "\" /></p>
<p><input type=\"hidden\" name=\"target_id\" value=\"" . $comment["id"] . "\" /></p>

<label>* Name(vchar(32)):</label>
<p><input type=\"text\" name=\"user\" value=\"\" id=\"\" class=\"input_text\" /></p>

<label>* Email(vchar(256)):</label>
<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input_text\" /></p>

<label>Website(vchar(256)):</label>
<p><input type=\"text\" name=\"site\" value=\"\" class=\"input_text\" /></p>

<label>* Content(text):</label>
<p><textarea name=\"content\" class=\"textarea\" ></textarea></p>

<p><input type=\"submit\" name=\"send\" value=\"Send\" class=\"input_submit\" /></p>
</form >";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
