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

        $content = "<div class=\"content_title border_frame\" >
<h3>Confirm delete tag</h3>
</div>

<div id=\"information\" class=\"border_frame\">
<p>The information of the tag are:</p>

<ul>
<li><span>Name: </span><span class=\"description\">" . htmlspecialchars($tag["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"description\">" . htmlspecialchars($tag["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"description\">" . htmlspecialchars($tag["description"]) . "</span></li>
<li><span>Articles: </span><span class=\"description\"><a href=\"" . $url->get(array($app_space_name, "admin/article.list_tag", ""), array("tag_id" => $tag["id"]), "") . "\">" . $tag["article_count"] . "</a></span></li>
</ul>

<form action=\"" . $url->get(array($app_space_name, "admin/tag.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $tag["id"] . "\" />

<p>Please input the password to confirm the action: </p>
<p><input type=\"password\" name=\"password\" value=\"\" id=\"\" /> <input type=\"submit\" name=\"confirm\" value=\"Confirm\" /></p>
</form>
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
