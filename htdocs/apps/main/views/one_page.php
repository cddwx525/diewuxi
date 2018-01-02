<?php
namespace main\views;

use main\lib\url;
use main\lib\views\base as base;

class one_page extends base
{
    public function get_items($result)
    {
        $url = new url();


        $title = "One page";

        $position = "";

        $content = "<div id=\"content_title\" class=\"border_frame\">
<h3>One page</h3>
</div>

<div id=\"content\" class=\"border_frame\">
<h3>Title 1</h3>
<p>Some text.</p>

<h3>Title 2</h3>
<ul>
<li>item</li>
<li>item</li>
<li>item</li>
</ul>
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
