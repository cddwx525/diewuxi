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

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "about.show", ""), array(), "") . "\">About</a>";

        $content = "<div class=\"content_title border_frame\">
<h3>About</h3>
</div>

<div id=\"content\" class=\"border_frame\">
<h3>Title 1</h3>
<p>Some text</p>

<h3>Title 2</h3>
<p>some text.</p>
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
