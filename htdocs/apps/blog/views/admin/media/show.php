<?php
namespace blog\views\admin\media;

use blog\lib\url;
use blog\lib\views\admin_base;

class show extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];
        $media = $result["media"];


        $title = "Show media";

        $position = " > Show media";


        $media_part = "<h3 class=\"bg-primary\">Media</h3>

<ul class=\"bg-info\">
<li><span>Date: </span><span class=\"text-info\">" . $media["date"] . "</span></li>
<li><span>Article: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $media["article_id"]), "") . "\">" . htmlspecialchars($media["article"]["title"]) . "</a></span></li>
<li><span>Link: </span><input type=\"text\" value=\"" . htmlspecialchars($url->get_static_relate($app_space_name, $media["file"])) . "\" id=\"media_link\" /></li>
</ul>

<div>
<img src=\"" . htmlspecialchars($url->get_static_relate($app_space_name, $media["file"])) . "\" alt=\"" . htmlspecialchars($media["file"]) . "\" />
</div>";


        $main = "<div>" . "\n" . $media_part . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
