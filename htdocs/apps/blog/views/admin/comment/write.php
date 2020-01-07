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
            $author_part = "<span class=\"text-warning\">[Author]</span>";
        }
        else
        {
            $author_part = "";
        }


        $content = "<h3 class=\"bg-primary\">Comment</h3>

<p>Under article [<a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</p>
<p>Reply to :</p>

<div id=\"" . $comment["id"] . "\">

<div class=\"bg-info\">
" . $author_part . "<span>" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span>
</div>

</div>

<h3 class=\"bg-primary\">Write comment(* is necessary, and email is not shown to public)</h3>

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
