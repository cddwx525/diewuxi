<?php
namespace blog\views\guest\tag;

use blog\lib\url;
use blog\lib\views\guest_base;

class show extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tag = $result["tag"];


        $title = "Tag: [" . htmlspecialchars($tag["name"]) . "]";

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.list_all", ""), array(), "") . "\">All tags</a> > " . htmlspecialchars($tag["name"]);


        $content = "<h3 class=\"bg-primary\">Tag: [" . htmlspecialchars($tag["name"]) . "]</h3>

<div class=\"bg-info\">
<ul>
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($tag["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($tag["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($tag["description"]) . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list_tag", ""), array("tag_slug" => $tag["slug"]), "") . "\">" . $tag["article_count"] . "</a></span></li>
</ul>
</div>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
