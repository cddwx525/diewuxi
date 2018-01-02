<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class add extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Add category";
        $position = " > Add category";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Add failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.write", ""), array(), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Category have been added successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $result["category_add"]["last_id"]), "") . "\">View</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.list_all", ""), array(), "") . "\">Category list</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Add category</h3>
</div>

<div class=\"message border_frame\">
" . $message . "
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
