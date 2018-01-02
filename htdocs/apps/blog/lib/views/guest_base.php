<?php
namespace blog\lib\views;

use blog\lib\url;
use blog\lib\views\base;

abstract class guest_base extends base
{
    public function get_css($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $css = array();
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["main_app"]["app_space_name"], "css/main.css") . "\">";
        $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/main.css") . "\">";

        if (isset($items["css"]))
        {
            foreach ($items["css"] as $one_css)
            {
                $css[] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $one_css . "\">";
            }
        }
        else
        {
        }

        $css = implode("\n", $css);

        return $css;
    }


    public function get_title($result)
    {
        $items = $this->get_items($result);

        $title = "<title>" . $items["title"] . " - " . $result["meta_data"]["options"]["blog_name"] . " - " . $result["meta_data"]["main_app"]["app_name"] . "</title>";

        return $title;
    }


    public function get_position($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $position_link_list = array();
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["main_app"]["app_space_name"], "home.show", ""), array(), "") . "\">Home</a>";
        $position_link_list[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/home.show", ""), array(), "") . "\">" . $result["meta_data"]["options"]["blog_name"] . "</a>";

        $position_link = implode(" > ", $position_link_list);
        $position_link = $position_link . $items["position"];

        $positon = "<div id=\"position\" class=\"border_frame\">
<span>Current position: </span>" . $position_link . "
</div>";

        return $positon;
    }


    public function get_menu($result)
    {
        $url = new url();

        $items = $this->get_items($result);

        $menu = "<div id=\"section\" class=\"border_frame\">
<div id=\"section_head\">
<h2>" . $result["meta_data"]["options"]["blog_name"] . "</h2>
</div>

<div id=\"menu\">
<div id=\"menu_list\">
<ul>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/home.show", ""), array(), "") . "\">Home</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_all", ""), array(), "") . "\">Articles</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.list_all", ""), array(), "") . "\">Cateories</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.list_all", ""), array(), "") . "\">Tags</a></li>
<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/about.show", ""), array(), "") . "\">About</a></li>
</ul>
</div>
</div>
</div>";

        return $menu;
    }


    /*
     * Main part.
     */
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
            $tag_list[] = "<span class=\"tag\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_tag", ""), array("tag_id" => $one_tag["id"]), "") . "\">". htmlspecialchars($one_tag["name"]) . " [" . $one_tag["article_count"] . "]</a></span>";
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
                $list[] = $indent . "<li class=\"category\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a>[" . $category["article_count"] . "]</li>
" . $indent . "<ul>
" . $this->category_output($category["son"], $result, $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li class=\"category\"><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a>[" . $category["article_count"] . "]</li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
