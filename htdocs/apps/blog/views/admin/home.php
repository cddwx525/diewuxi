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

        $content = "<div class=\"content_title border_frame\">
<h3>Administration homepage.</h3>
</div>

<div id=\"content\" class=\"border_frame\">
<p>This is home page.</p>
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

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
