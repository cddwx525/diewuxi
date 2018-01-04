<?php
namespace blog\views\common;

use blog\lib\url;
use blog\lib\views\simple;

class already_config extends simple
{
    public function get_items($result)
    {
        $url = new url();
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Already config";

        $position = " > Already config";

        $content = "<div class=\"content_title border_frame\">
<h3>Already config!</h3>
</div>

<div class=\"border_frame\">
<p>Go to home: <a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Home</a></p>
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
