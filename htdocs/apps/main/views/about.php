<?php
namespace main\views;

use main\lib\url;
use main\lib\views\base as base;

class about extends base
{
    public function get_items($result)
    {
        $url = new url();

        $title = "About";

        $position = " > About";

        $content = "<h3 class=\"bg-primary\">About</h3>

<h3>Title 1</h3>

<h3>Title 2</h3>
<p>some text.</p>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "About page.";
    }
}
?>
