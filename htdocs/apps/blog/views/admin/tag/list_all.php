<?php
namespace blog\views\admin\tag;

use blog\lib\url;
use blog\lib\views\admin_base;

class list_all extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tags = $result["tags"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "All tags";
        $position = " > All tags";

        $list = array();
        foreach ($tags as $key => $tag)
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
<td>" . htmlspecialchars($tag["name"]) . "</td>
<td>" . htmlspecialchars($tag["slug"]) . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.list_tag", ""), array("tag_id" => $tag["id"]), "") . "\">" . $tag["article_count"] . "</a></td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/tag.delete_confirm", ""), array("id" => $tag["id"]), "") . "\">Delete</a> <a href=\"" . $url->get(array($app_space_name, "admin/tag.edit", ""), array("id" => $tag["id"]), "") . "\">Edit</a> <a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $tag["id"]), "") . "\">View</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $tag_list = "<div class=\"content_title border_frame\" >
<h3>All tags</h3>
</div>

<div id=\"tag_list_table\" class=\"border_frame\">
<table class=\"table table-hover\">
<tr>
<th>Name</th>
<th>Slug</th>
<th>Articles</th>
<th>Operate</th>
</tr>
" . $list . "
</table>
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.write", ""), array(), "") . "\">Write an tag</a></p>
" . $tag_list . "
</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
