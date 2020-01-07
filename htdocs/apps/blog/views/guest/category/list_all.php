<?php
namespace blog\views\guest\category;

use blog\lib\url;
use blog\lib\views\guest_base;

class list_all extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $categories = $result["categories"];


        $title = "All categories";

        $position = " > All categories";


        if (empty($categories))
        {
            $category_list = "<p>There is no category now.</p>";
        }
        else
        {
            $category_list = "<ul>
" . $this->category_output($categories, $result, $url, "", "") . "
</ul>";
        }

        $content = "<h3 class=\"bg-primary\">All categories</h3>
" . $category_list;

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }


    private function category_output($categories, $result, $url, $indent, $indent_constant)
    {
        foreach ($categories as $category)
        {
            if (isset($category["son"]))
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.slug_show", ""), array("category_slug" => $category["slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a> [" . $category["article_count"] . "]</li>
" . $indent . "<ul>
" . $this->category_output($category["son"], $result, $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.slug_show", ""), array("category_slug" => $category["slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "</a> [" . $category["article_count"] . "]</li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
