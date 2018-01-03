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

        $content = "<div class=\"content_title border_frame\">
<h3>Not Found!</h3>
</div>

<div class=\"border_frame\">
<p>Your request page: \"" . $result["parameters"]["url"] . "\" is not found on this server.</p>
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
