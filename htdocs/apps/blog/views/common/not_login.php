<?php
namespace blog\views\common;

use blog\lib\url;
use blog\lib\views\simple;

class not_login extends simple
{
    public function get_items($result)
    {
        $url = new url();
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Not Login";

        $position = " > Not login";

        $content = "<h3 class=\"bg-primary\">Not Login!</h3>

<div class=\"bg-warning\">
<p>Go to login: <a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Login</a></p>
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
