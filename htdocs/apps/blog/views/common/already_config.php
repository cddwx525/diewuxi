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

        $content = "<h3 class=\"bg-primary\">Already config!</h3>

<div class=\"bg-warning\">
<p>Go to home: <a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Home</a></p>
</div>";

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
