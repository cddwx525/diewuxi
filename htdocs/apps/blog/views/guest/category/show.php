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

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.list_all", ""), array(), "") . "\">All categories</a> > " . htmlspecialchars($category["name"]);


        if (empty($category["son"]))
        {
            $subcategory_links = "<span>NULL</span>";
        }
        else
        {
            $subcategory_links = array();
            foreach ($category["son"] as $son)
            {
                $subcategory_links[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.slug_show", ""), array("category_slug" => $son["slug"]), "") . "\">" . htmlspecialchars($son["name"]) . "</a>";
            }
            $subcategory_links = implode(", ", $subcategory_links);
        }

        $content = "<h3 class=\"bg-primary\">Category: [" . htmlspecialchars($category["name"]) . "]</h3>

<div class=\"bg-info\">
<ul>
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($category["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($category["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($category["description"]) . "</span></li>
<li><span>Sons: </span><span>" . $subcategory_links . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . $category["article_count"] . "</a></span></li>
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
