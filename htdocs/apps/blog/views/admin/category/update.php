<?php
namespace blog\views\admin\category;

use blog\lib\url;
use blog\lib\views\admin_base;

class update extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Update categoty";
        $position = " > Update category";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"text-warning\">[" . $state . "], Update failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.edit", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"text-success\">Category have been updated successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $parameters["post"]["id"]), "") . "\">View</a></p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.list_all", ""), array(), "") . "\">Category list</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Update category</h3>
" . $message;

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
