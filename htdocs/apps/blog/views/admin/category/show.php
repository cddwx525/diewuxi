<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class show extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $category = $result["category"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Category " . $category["name"];
        $position = " > Category information";

        if (empty($category["son"]))
        {
            $subcategory_links = "<span>NULL</span>";
        }
        else
        {
            $subcategory_links = array();
            foreach ($category["son"] as $son)
            {
                $subcategory_links[] = "<a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $son["id"]), "") . "\">" . htmlspecialchars($son["name"]) . "</a>";
            }
            $subcategory_links = implode(", ", $subcategory_links);
        }

        $content = "<h3 class=\"bg-primary\">Category: " . htmlspecialchars($category["name"]) . "</h3>

<ul class=\"bg-info\">
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($category["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($category["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($category["description"]) . "</span></li>
<li><span>Sons: </span><span>" . $subcategory_links . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . $category["article_count"] . "</a></span></li>
</ul>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
