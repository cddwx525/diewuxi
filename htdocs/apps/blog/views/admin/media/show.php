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


        $media_part = "<div class=\"content_title border_frame\" >
<h3>Media</h3>
</div>

<div id=\"media_information\" class=\"border_frame\">
<ul>
<li><span>Date: </span><span class=\"description\">" . $media["date"] . "</span></li>
<li><span>Article: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $media["article_id"]), "") . "\">" . htmlspecialchars($media["article"]["title"]) . "</a></span></li>
<li><span>Link: </span><input type=\"text\" value=\"" . htmlspecialchars($url->get_static_relate($app_space_name, $media["file"])) . "\" id=\"media_link\" /></li>
</ul>
</div>

<div id=\"media_content\" class=\"border_frame\">
<img src=\"" . htmlspecialchars($url->get_static_relate($app_space_name, $media["file"])) . "\" alt=\"" . htmlspecialchars($media["file"]) . "\" />
</div>";


        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $media_part . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
