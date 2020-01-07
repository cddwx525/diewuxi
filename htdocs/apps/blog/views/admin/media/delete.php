<?php
namespace blog\views\admin\media;

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


        $title = "Delete media";
        $position = " > Delete media";


        if ($state != "SUCCESS")
        {
            if ($state === "PASSWORD_FAIL")
            {
                $message = "<p class=\"text-warning\">Password wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"text-warning\">[" . $state . "], Media deleted wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"text-success\">Media have been deleted successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.list_all", ""), array(), "") . "\">Media list</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Delete media</h3>

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
