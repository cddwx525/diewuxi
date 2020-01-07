<?php
namespace blog\views\admin\media;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete_confirm extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];
        $media = $result["media"];


        $title = "Confirm delete media";
        $position = " > Confirm delete media";


        $content = "<h3 class=\"bg-primary\">Confirm delete media</h3>

<p>The information of the media are:</p>

<ul class=\"bg-info\">
<li><span>Date: </span><span class=\"text-muted\">" . $media["date"] . "</span></li>
<li><span>Article: </span><span><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $media["article_id"]), "") . "\">" . htmlspecialchars($media["article"]["title"]) . "</a></span></li>
<li><span>Link: </span><input type=\"text\" value=\"" . htmlspecialchars($url->get_static_relate($app_space_name, $media["file"])) . "\" id=\"media_link\" /></li>
</ul>

<form action=\"" . $url->get(array($app_space_name, "admin/media.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $media["id"] . "\" /></p>

<p>Please input the password to confirm the action: </p>
<p><input type=\"password\" name=\"password\" value=\"\" id=\"\" /> <input type=\"submit\" name=\"confirm\" value=\"Confirm\" /></p>
</form>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
