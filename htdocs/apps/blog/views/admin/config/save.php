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
            $message = "<p class=\"text-warning\">[" . $state . "], Save failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/config.write", ""), array(), "") . "\">Re config</a></p>";
        }
        else
        {
            $message = "<p class=\"text-success\">Configs have been saved successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Admin Home</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "guest/home.show", ""), array(), "") . "\">Home</a></p>";
        }

        $content = "<h3 class=\"bg-primary\">Save config</h3>

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
