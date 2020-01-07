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
        foreach ($comments as $key => $comment)
        {
            if (($key + 1)% 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            $list[] = "<tr class=\"" . $alternate . "\">
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

        $comment_list = "<h3 class=\"bg-primary\">All comments</h3>

<table class=\"table\">
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
</table>";
    
        $main = "<div>" . "\n" . $comment_list . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
