<?php
namespace main\views;

use main\lib\url;
use main\lib\views\base as base;

class not_found extends base
{
    public function get_items($result)
    {
        $url = new url();


        $title = "Not found";

        $position = " > Not Found";

        $content = "<h3 class=\"bg-primary\">Not Found!</h3>

<p>Your request page: \"" . $result["parameters"]["url"] . "\" is not found on this server.</p>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "################################################################################
This is text mode of not found page.
################################################################################";
    }
}
?>
