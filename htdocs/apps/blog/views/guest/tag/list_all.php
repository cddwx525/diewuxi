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

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.list_all", ""), array(), "") . "\">All tags</a>";


        if (empty($tags))
        {
            $tag_list = "<p>There is no tags now.</p>";
        }
        else
        {
            $tag_list = array();
            foreach ($tags as $one_tag)
            {
                $tag_list[] = "<span class=\"tag\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.show", ""), array("id" => $one_tag["id"]), "") . "\">". htmlspecialchars($one_tag["name"]) . " [" . $one_tag["article_count"] . "]</a></span>";
            }
            $tag_list = implode(" ", $tag_list);
        }

        $content = "<div class=\"content_title border_frame\">
<h3>All tags</h3>
</div>

<div id=\"tag_list\" class=\"border_frame\">
" . $tag_list . "
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
