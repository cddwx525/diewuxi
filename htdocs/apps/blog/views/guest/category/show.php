<?php
namespace blog\views\guest\category;

use blog\lib\url;
use blog\lib\views\guest_base;

class show extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $category = $result["category"];


        $title = "Category: [" . $category["name"] . "]";

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.list_all", ""), array(), "") . "\">All categories</a> > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a>";


        if (empty($category["son"]))
        {
            $subcategory_links = "<span>NULL</span>";
        }
        else
        {
            $subcategory_links = array();
            foreach ($category["son"] as $son)
            {
                $subcategory_links[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.show", ""), array("id" => $son["id"]), "") . "\">" . htmlspecialchars($son["name"]) . "</a>";
            }
            $subcategory_links = implode(", ", $subcategory_links);
        }

        $content = "<div class=\"content_title border_frame\">
<h3>Category: [" . htmlspecialchars($category["name"]) . "]</h3>
</div>

<div id=\"category_infomation\" class=\"border_frame\">
<ul>
<li><span>Name: </span><span class=\"description\">" . htmlspecialchars($category["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"description\">" . htmlspecialchars($category["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"description\">" . htmlspecialchars($category["description"]) . "</span></li>
<li><span>Sons: </span><span class=\"description\">" . $subcategory_links . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . $category["article_count"] . "</a></span></li>
</ul>
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
