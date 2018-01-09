<?php
namespace blog\views\guest;

use blog\lib\url;
use blog\lib\views\guest_base;

class about extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $about_page_page = $result["about_page_page"];


        $css = array(
            $url->get_static($result["meta_data"]["settings"]["app_space_name"], "css/github-markdown.css"),
        );
        $title = "About";

        $position = " > About";

        $content = "<div class=\"content_title border_frame\">
<h3>About</h3>
</div>

<div class=\"border_frame markdown-body\">" . $about_page_page["content"] . "</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

        return array(
            "css" => $css,
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
