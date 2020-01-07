<?php
namespace blog\views\admin\comment;

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


        $title = "Delete comment";
        $position = " > Delete comment";


        if ($state != "SUCCESS")
        {
            if ($state === "PASSWORD_WRONG")
            {
                $message = "<p class=\"text-warning\">Password wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"text-warning\">[" . $state . "], Comment delete wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/comment.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"text-success\">Comment have been deleted successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/comment.list_all", ""), array(), "") . "\">Comment list</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Delete comment</h3>

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
