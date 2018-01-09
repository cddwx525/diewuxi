<?php
namespace blog\lib\views;

use blog\lib\url;
use blog\lib\views\base;

abstract class guest_base extends base
{
    public function get_main($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $category_list = "<ul id=\"root_ul\">
" . $this->category_output($result["meta_data"]["categories"], $result, $url, "", "") . "
</ul>";

        $tag_list = array();
        foreach ($result["meta_data"]["tags"] as $one_tag)
        {
            $tag_list[] = "<span class=\"tag\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list_tag", ""), array("tag_slug" => $one_tag["slug"]), "") . "\">". htmlspecialchars($one_tag["name"]) . " [" . $one_tag["article_count"] . "]</a></span>";
        }
        $tag_list = implode(" ", $tag_list);


        $side = "<div id=\"side\" class=\"border_frame\">

<div class=\"content_title border_frame\">
<h3>Browse by category</h3>
</div>

<div id=\"category_list\" class=\"border_frame\">
" . $category_list . "
</div>

<div class=\"content_title border_frame\">
<h3>Browse by tag</h3>
</div>

<div id=\"tag_list\" class=\"border_frame\">
" . $tag_list . "
</div>
</div>";

        $main_area = "<div id=\"main_area\" class=\"border_frame\">
<div id=\"side_container\">
" . $side . "
</div>

<div id=\"main_container\">
" . $items["main"] . "
</div>

<div class=\"clear_both\"></div>
</div>";

        return $main_area;
    }


    private function category_output($categories, $result, $url, $indent, $indent_constant)
    {
        $list = array();
        foreach ($categories as $category)
        {
            if (isset($category["son"]))
            {
                $list[] = $indent . "<li class=\"category\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "[" . $category["article_count"] . "]</a></li>
" . $indent . "<ul>
" . $this->category_output($category["son"], $result, $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li class=\"category\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "[" . $category["article_count"] . "]</a></li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
