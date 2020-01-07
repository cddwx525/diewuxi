<?php
namespace blog\views\guest\tag;

use blog\lib\url;
use blog\lib\views\guest_base;

class list_all extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $tags = $result["tags"];


        $title = "All tags";

        $position = " > All tags";


        if (empty($tags))
        {
            $tag_list = "<p>There is no tags now.</p>";
        }
        else
        {
            $tag_list = array();
            foreach ($tags as $one_tag)
            {
                $tag_list[] = "<span><a class=\"tag\" href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.slug_show", ""), array("tag_slug" => $one_tag["slug"]), "") . "\">". htmlspecialchars($one_tag["name"]) . " [" . $one_tag["article_count"] . "]</a></span>";
            }
            $tag_list = implode(" ", $tag_list);
        }

        $content = "<h3 class=\"bg-primary\">All tags</h3>
" . $tag_list;

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
