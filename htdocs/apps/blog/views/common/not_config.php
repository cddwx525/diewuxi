<?php
namespace blog\views\common;

use blog\lib\url;
use blog\lib\views\simple;

class not_config extends simple
{
    public function get_items($result)
    {
        $url = new url();
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Not configed";

        $position = " > Not configed";

        $content = "<h3 class=\"bg-primary\">Not Configed!</h3>

<div class=\"bg-warning\">
<p>Go to config: <a href=\"" . $url->get(array($app_space_name, "admin/config.write", ""), array(), "") . "\">Config</a></p>
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
