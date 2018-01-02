<?php
namespace blog\views\admin\media;

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


        $title = "Update media";
        $position = " > Update media</a>";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Update failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.edit", ""), array("id" => $parameters["post"]["id"]), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Media have been updated successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.show", ""), array("id" => $parameters["post"]["id"]), "") . "\">View</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "admin/media.list_all", ""), array(), "") . "\">Media lsit</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Update media</h3>
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
