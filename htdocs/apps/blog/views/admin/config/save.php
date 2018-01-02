<?php
namespace blog\views\admin\config;

use blog\lib\url;
use blog\lib\views\simple;

class save extends simple
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Save config";

        $position = " > save config";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"success\">[" . $state . "], Save failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/config.write", ""), array(), "") . "\">Re config</a></p>";
        }
        else
        {
            $message = "<p class=\"success\">Configs have been saved successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Admin Home</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "guest/home.show", ""), array(), "") . "\">Home</a></p>";
        }

        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>Save config</h3>
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
