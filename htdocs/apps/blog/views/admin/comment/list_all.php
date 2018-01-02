<?php
namespace blog\views\admin\comment;

use blog\lib\url;
use blog\lib\views\admin_base;

class list_all extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $comments = $result["comments"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "All comments";
        $position = " > All comments";

        $list = array();
        foreach ($comments as $comment)
        {
            $list[] = "<tr>
<td>" . htmlspecialchars($comment["user"]) . "</td>
<td>" . $comment["author"] . "</td>
<td>" . htmlspecialchars($comment["mail"]) . "</td>
<td>" . htmlspecialchars($comment["site"]) . "</td>
<td>" . $comment["date"] . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $comment["article"]["id"]), $comment["id"]) . "\">" . htmlspecialchars($comment["article"]["title"]) . "</a></td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $comment["id"]), "") . "\">Delete</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $comment_list = "<div class=\"content_title border_frame\" >
<h3>All comments</h3>
</div>

<div id=\"comment_list_table\" class=\"border_frame\">
<table class=\"table table-hover\">
<tr>
<th>User</th>
<th>Author</th>
<th>Mail</th>
<th>Site</th>
<th>Date</th>
<th>Article</th>
<th>Operate</th>
</tr>
" . $list . "
</table>
</div>";
    
        $main = "<div id=\"main\" class=\"border_frame\">" . $comment_list . " </div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
