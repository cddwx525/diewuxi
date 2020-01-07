<?php
namespace blog\views\admin;

use blog\lib\url;
use blog\lib\views\admin_base;

class home extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];


        $title = "Home";

        $position = "";

        $content = "<h3 class=\"bg-primary\">Administration homepage.</h3>

<p>This is home page.</p>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
