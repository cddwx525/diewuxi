<?php
namespace blog\views\admin\category;

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


        $title = "Delete category";
        $position = " > Delete category";


        if ($state != "SUCCESS")
        {
            if ($state === "PASSWORD_FAIL")
            {
                $message = "<p class=\"failure\">Password wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else if ($state === "DELETE_DENY")
            {
                $message = "<p class=\"failure\">Category has sons or articles, cannot deleted!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"failure\">[" . $state . "], Category delete wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"success\">Category have been deleted successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/category.list_all", ""), array(), "") . "\">Category list</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Delete category</h3>
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
