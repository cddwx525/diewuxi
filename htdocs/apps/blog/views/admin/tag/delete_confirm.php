<?php
namespace blog\views\admin\tag;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete_confirm extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tag = $result["tag"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Confirm delete tag";
        $position = " > Confirm delete tag";

        $content = "<h3 class=\"bg-primary\">Confirm delete tag</h3>

<p>The information of the tag are:</p>

<ul class=\"bg-info\">
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($tag["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($tag["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($tag["description"]) . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.list_tag", ""), array("tag_id" => $tag["id"]), "") . "\">" . $tag["article_count"] . "</a></span></li>
</ul>

<form action=\"" . $url->get(array($app_space_name, "admin/tag.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $tag["id"] . "\" />

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
