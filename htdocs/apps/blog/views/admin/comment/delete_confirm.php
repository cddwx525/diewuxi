<?php
namespace blog\views\admin\comment;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete_confirm extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $comment = $result["comment"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Confirm delete comment";
        $position = " > Confirm delete comment";


        $content = "<h3 class=\"bg-primary\">Confirm delete comment</h3>

<p>The information of the comment are:</p>

<div class=\"bg-info\">
<span>" . htmlspecialchars($comment["user"]) . "</span>
</div>

<div>" . htmlspecialchars($comment["content"]) . "</div>

<div>
<span class=\"text-muted\">" . $comment["date"] . "</span>
</div>

<form action=\"" . $url->get(array($app_space_name, "admin/comment.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $comment["id"] . "\" />

<p>Please input the password to confirm the action: </p>
<p><input type=\"password\" name=\"password\" value=\"\" id=\"\" /> <input type=\"submit\" name=\"confirm\" value=\"Confirm\" /></p>
</form>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
