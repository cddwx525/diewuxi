<?php
namespace blog\views\admin\article;

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


        $title = "Update article";
        $position = " > Update article</a>";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"text-warning\">[" . $state . "], Update failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.edit", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"text-success\">Article have been updated successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $parameters["post"]["id"]), "") . "\">View</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.list_all", ""), array(), "") . "\">Article lsit</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Update article</h3>
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
