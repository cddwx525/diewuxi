<?php
namespace blog\views\admin\tag;

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


        $title = "Update tag";
        $position = " > Update tag";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"text-warning\">[" . $state . "], Update failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.edit", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"text-success\">Tag have been updated successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $parameters["post"]["id"]), "") . "\">View</a></p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.list_all", ""), array(), "") . "\">Tag list</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Update tag</h3>

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
