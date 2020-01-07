<?php
namespace blog\views\admin\tag;

use blog\lib\url;
use blog\lib\views\admin_base;

class show extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tag = $result["tag"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Tag " . $tag["name"];
        $position = " > Tag information";


        $content = "<h3 class=\"bg-primary\">Tag: " . htmlspecialchars($tag["name"]) . "</h3>

<ul class=\"bg-info\">
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($tag["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($tag["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($tag["description"]) . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.list_tag", ""), array("tag_id" => $tag["id"]), "") . "\">" . $tag["article_count"] . "</a></span></li>
</ul>";

        $main = "<div>" . "\n" . "\n" .$content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
