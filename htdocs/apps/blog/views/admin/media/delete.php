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
                $message = "<p class=\"failure\">Password wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"failure\">[" . $state . "], Media deleted wrong!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"success\">Media have been deleted successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.list_all", ""), array(), "") . "\">Media list</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Delete media</h3>
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
