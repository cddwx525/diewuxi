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

        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>Not Configed!</h3>
</div>

<div class=\"border_frame\">
<p>Go to config: <a href=\"" . $url->get(array($app_space_name, "admin/config.write", ""), array(), "") . "\">Config</a></p>
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
