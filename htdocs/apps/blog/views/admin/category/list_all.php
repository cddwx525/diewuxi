<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class list_all extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $categories = $result["categories"];
        $category_sturcture = $result["category_sturcture"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "All categories";
        $position = " > All categories";


        $list = array();
        foreach ($categories as $key => $category)
        {
            if (($key + 1)% 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            if ($category["parent"] === NULL)
            {
                $category_parent_link = "NULL";
            }
            else
            {
                $category_parent_link = "<a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["parent"]["id"]), "") . "\">" . htmlspecialchars($category["parent"]["name"]) . "</a>";
            }

            $list[] = "<tr class=\"" . $alternate . "\">
<td>" . htmlspecialchars($category["name"]) . "</td>
<td>" . htmlspecialchars($category["slug"]) . "</td>
<td>" . $category_parent_link . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.list_category", ""), array("category_id" => $category["id"]), "") . "\">" . $category["article_count"] . "</a></td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/category.delete_confirm", ""), array("id" => $category["id"]), "") . "\">Delete</a> <a href=\"" . $url->get(array($app_space_name, "admin/category.edit", ""), array("id" => $category["id"]), "") . "\">Edit</a> <a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">View</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $category_list = "<h3 class=\"bg-primary\">Category list:</h3>

<table class=\"table\">
<tr>
<th>Name</th>
<th>Slug</th>
<th>Parent</th>
<th>Articles</th>
<th>Operate</th>
</tr>
" . $list . "
</table>";

        $category_relation = "<h3 class=\"bg-primary\">Category relation:</h3>

<ul>
" . $this->category_output($result, $category_sturcture, array(), $url, "") . "
</ul>";

        $main = "<div>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.write", ""), array(), "") . "\">Write an category</a></p>
" . $category_list . "
" . $category_relation . "
</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }


    private function category_output($result, $categories, $list, $url, $indent)
    {
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];

        foreach ($categories as $category)
        {
            if (isset($category["son"]))
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a> [" . $category["article_count"] . "]</li>
" . $indent . "<ul>
" . $this->category_output($result, $category["son"], array(), $url, $indent . "") . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $category["id"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a> [" . $category["article_count"] . "]</li>";
            }
        }
        return implode("\n", $list);
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
