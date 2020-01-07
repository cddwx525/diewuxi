<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete_confirm extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $category = $result["category"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Confirm delete category";
        $position = " > Confirm delete category";

        if (empty($category["son"]))
        {
            $subcategory_links = "NULL";
        }
        else
        {
            $subcategory_links = array();
            foreach ($category["son"] as $son)
            {
                $subcategory_links[] = "<a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $son["id"]), "") . "\">" . htmlspecialchars($son["name"]) . " </a>";
            }
            $subcategory_links = implode(", ", $subcategory_links);
        }

        $content = "<h3 class=\"bg-primary\">Category delete confirm</h3>

<p>The information of the category are:</p>

<ul class=\"bg-info\">
<li><span>Name: </span><span class=\"text-muted\">" . htmlspecialchars($category["name"]) . "</span></li>
<li><span>Slug: </span><span class=\"text-muted\">" . htmlspecialchars($category["slug"]) . "</span></li>
<li><span>Description: </span><span class=\"text-muted\">" . htmlspecialchars($category["description"]) . "</span></li>
<li><span>Sons: </span><span>" . $subcategory_links . "</span></li>
<li><span>Articles: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . $category["article_count"] . "</a></span></li>
</ul>

<form action=\"" . $url->get(array($app_space_name, "admin/category.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $category["id"] . "\" />

<p>Please input the password to confirm the action: </p>
<p><input type=\"password\" name=\"password\" value=\"\" id=\"\" /> <input type=\"submit\" name=\"confirm\" value=\"Confirm\" /></p>
</form>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
