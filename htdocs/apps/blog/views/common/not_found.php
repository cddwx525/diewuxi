<?php
namespace blog\views\common;

use blog\lib\url;
use blog\lib\views\simple;

class not_found extends simple
{
    public function get_items($result)
    {
        $url = new url();


        $title = "Not found";

        $position = " > Not Found";

        $content = "<h3 class=\"bg-primary\">Not Found!</h3>

<div class=\"bg-warning\">
<p>Your request page: \"" . $result["parameters"]["url"] . "\" is not found on this server.</p>
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
        return "Not Found!";
    }
}
?>
