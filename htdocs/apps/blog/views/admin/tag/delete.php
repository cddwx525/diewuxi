<?php
namespace blog\views\admin\tag;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Delete tag";
        $position = " > Delete tag";


        if ($state != "SUCCESS")
        {
            if ($state === "PASSWORD_FAIL")
            {
                $message = "<p class=\"text-warning\">Password wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else if ($state === "DELETE_DENY")
            {
                $message = "<p class=\"text-warning\">Tag has articles, cannot deleted!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"text-warning\">[" . $state . "], Tag delete wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"text-success\">Tag have been deleted successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/tag.list_all", ""), array(), "") . "\">Tag list</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Delete tag</h3>

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
