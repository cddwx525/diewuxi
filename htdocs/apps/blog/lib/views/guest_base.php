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

        $category_list = "<ul class=\"list-unstyled\">
" . $this->category_output($result["meta_data"]["categories"], $result, $url, "", "") . "
</ul>";

        $tag_list = array();
        foreach ($result["meta_data"]["tags"] as $one_tag)
        {
            $tag_list[] = "<a class=\"tag\" href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list_tag", ""), array("tag_slug" => $one_tag["slug"]), "") . "\">". htmlspecialchars($one_tag["name"]) . "<span>[" . $one_tag["article_count"] . "]</span></a>";
        }
        $tag_list = implode(" ", $tag_list);


        $side = "";

        $main_area = "<div class=\"row-fluid\">

<div class=\"col-md-9 col-md-push-3\">
" . $items["main"] . "
</div>

<div class=\"col-md-3 col-md-pull-9\">
<h3 class=\"bg-primary\">Browse by category</h3>
" . $category_list . "
<h3 class=\"bg-primary\">Browse by tag</h3>
" . $tag_list . "
</div>

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
                $list[] = $indent . "<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "<span>[" . $category["article_count"] . "]</span></a></li>
" . $indent . "<ul>
" . $this->category_output($category["son"], $result, $url, $indent . $indent_constant, $indent_constant) . "
" . $indent . "</ul>";
            }
            else
            {
                $list[] = $indent . "<li><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_list", ""), array("full_category_slug" => $category["full_slug"]), "") . "\">" . htmlspecialchars($category["name"]) . "<span>[" . $category["article_count"] . "]</span></a></li>";
            }
        }
        return implode("\n", $list);
    }
}
?>
