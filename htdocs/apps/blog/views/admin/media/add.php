<?php
namespace blog\views\admin\media;

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


        $title = "Add media";
        $position = " > Add media";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Add failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.write", ""), array(), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Media have been added successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.show", ""), array("id" => $result["media_add"]["last_id"]), "") . "\">View</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.list_all", ""), array(), "") . "\">Media list</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Add media</h3>
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
