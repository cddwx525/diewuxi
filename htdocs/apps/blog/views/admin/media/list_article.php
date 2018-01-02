<?php
namespace blog\views\admin\media;

use blog\lib\url;
use blog\lib\views\admin_base;

class list_article extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];
        $medias = $result["medias"];
        $article = $result["article"];


        $title = "Medias in article " . htmlspecialchars($article["title"]);
        $position = " > Medias in article " . htmlspecialchars($article["title"]);

        $list = array();
        foreach ($medias as $media)
        {
            $list[] = "<tr>
<td>" . $media["date"] . "</td>
<td>" . $media["file"] . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $media["article_id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a></td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $media["id"]), "") . "\">Delete</a> <a href=\"" . $url->get(array($app_space_name, "admin/media.edit", ""), array("id" => $media["id"]), "") . "\">Edit</a> <a href=\"" . $url->get(array($app_space_name, "admin/media.show", ""), array("id" => $media["id"]), "") . "\">View</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $media_list = "<div class=\"content_title border_frame\" >
<h3>Medias in article [" . htmlspecialchars($article["title"]) . "]</h3>
</div>

<div id=\"media_list_table\" class=\"border_frame\">
<table class=\"table table-hover\">
<tr>
<th>Date</th>
<th>File</th>
<th>Article</th>
<th>Operate</th>
</tr>
" . $list . "
</table>
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $media_list . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
