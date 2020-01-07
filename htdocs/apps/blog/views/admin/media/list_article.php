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
        foreach ($medias as $key => $media)
        {
            if (($key + 1)% 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            $list[] = "<tr class=\"" . $alternate . "\">
<td>" . $media["date"] . "</td>
<td>" . $media["file"] . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $media["article_id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a></td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/media.delete_confirm", ""), array("id" => $media["id"]), "") . "\">Delete</a> <a href=\"" . $url->get(array($app_space_name, "admin/media.edit", ""), array("id" => $media["id"]), "") . "\">Edit</a> <a href=\"" . $url->get(array($app_space_name, "admin/media.show", ""), array("id" => $media["id"]), "") . "\">View</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $media_list = "<h3 class=\"bg-primary\">Medias in article [" . htmlspecialchars($article["title"]) . "]</h3>

<table class=\"table\">
<tr>
<th>Date</th>
<th>File</th>
<th>Article</th>
<th>Operate</th>
</tr>
" . $list . "
</table>";

        $main = "<div>" . "\n" . $media_list . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
