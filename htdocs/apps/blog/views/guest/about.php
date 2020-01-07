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

        $content = "<h3 class=\"bg-primary\">About</h3>

<div class=\"markdown-body\">
" . $about_page_page["content"] . "
</div>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "css" => $css,
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
