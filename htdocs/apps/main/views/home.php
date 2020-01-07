<?php
namespace main\views;

use main\lib\url;
use main\lib\views\base as base;

class home extends base
{
    public function get_items($result)
    {
        $url = new url();


        $title = "Home";

        $position = "";

        $content = "<h3 class=\"bg-primary\">Home</h3>

<h3>Title 1</h3>
<p>Some text.</p>

<h3>Title 2</h3>
<ul>
<li>item</li>
<li>item</li>
<li>item</li>
</ul>";

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
This is text mode of home page.
################################################################################";
    }
}
?>
