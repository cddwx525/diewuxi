<?php
namespace blog\views\admin\comment;

use blog\lib\url;
use blog\lib\views\admin_base;

class write extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $comment = $result["comment"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Write comment under [" . $article["title"] . "]";
        $position = " > Write comment";

        if ($comment["author"] === "1")
        {
            $author_part = "<span class=\"author\">[Author]</span>";
        }
        else
        {
            $author_part = "";
        }


        $content = "<div class=\"content_title border_frame\" >
<h3>Comment</h3>
</div>

<div class=\"border_frame\">
<p>Under article [<a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</p>
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
<form action=\"" . $url->get(array($app_space_name, "admin/comment.add", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>
<p><input type=\"hidden\" name=\"article_id\" value=\"" . $article["id"] . "\" /></p>
<p><input type=\"hidden\" name=\"target_id\" value=\"" . $comment["id"] . "\" /></p>

<p>* Is author(bool):</p>
<p><input type=\"checkbox\" name=\"author\" value=\"TRUE\" /></p>

<p>* name(vchar(32)):</p>
<p><input type=\"text\" name=\"user\" value=\"\" class=\"input_text\" /></p>

<p>* email(vchar(256)):</p>
<p><input type=\"text\" name=\"mail\" value=\"\" class=\"input_text\" /></p>

<p>website(vchar(256)):</p>
<p><input type=\"text\" name=\"site\" value=\"\" class=\"input_text\" /></p>

<p>* content(text):</p>
<p><textarea name=\"content\" class=\"textarea\"></textarea></p>

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
