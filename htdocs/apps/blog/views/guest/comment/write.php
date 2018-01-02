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

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_category", ""), array("category_id" => $article["category_id"]), "") . "\">Category: " . htmlspecialchars($article["category"]["name"]) . "</a> > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a> > Write comment";


        if ($comment["author"] === "1")
        {
            $author_part = "<span class=\"author\">[Author]</span>";
        }
        else
        {
            $author_part = "";
        }


        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>Comment</h3>
</div>

<div class=\"border_frame\">
<p>Under article [<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</p>
<p>Reply to :</p>

<div id=\"" . $comment["id"] . "\" class=\"comment_entry border_frame\">

<div class=\"comment_entry_header\">
" . $author_part . "<span class=\"user\">" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div class=\"comment_entry_content\">" . htmlspecialchars($comment["content"]) . "</div>

<div class=\"comment_entry_information\">
<span class=\"description\">" . $comment["date"] . "</span>
</div>
</div>
</div>

<div class=\"content_title border_frame\" >
<h3>Write comment(* is necessary, and email is not shown to public)</h3>
</div>

<div id=\"write_comment\" class=\"border_frame\">
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
</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
