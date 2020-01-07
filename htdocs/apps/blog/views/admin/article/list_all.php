<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class list_all extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $articles = $result["articles"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "All articles";
        $position = " > All articles";

        $list = array();
        foreach ($articles as $key => $article)
        {
            if (($key + 1)% 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            if (empty($article["tag"]))
            {
                $article_tags = "<span>NULL</span>";
            }
            else
            {
                $article_tags = array();
                foreach ($article["tag"] as $tag)
                {
                    $article_tags[] = "<a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $tag["id"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
                }
                $article_tags = implode(", ", $article_tags);
            }

            $list[] = "<tr class=\"" . $alternate . "\">
<td>" . $article["id"] . "</td>
<td>" . htmlspecialchars($article["title"]) . "</td>
<td>" . htmlspecialchars($article["slug"]) . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $article["category"]["id"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></td>
<td>" . $article_tags . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/media.list_article", ""), array("article_id" => $article["id"]), "") . "\">" . $article["media_count"] . "</a></td>
<td>" . $article["date"] . "</td>
<td>" . $article["comment_count"] . "</td>
<td><a href=\"" . $url->get(array($app_space_name, "admin/article.delete_confirm", ""), array("id" => $article["id"]), "") . "\">Delete</a> <a href=\"" . $url->get(array($app_space_name, "admin/article.edit", ""), array("id" => $article["id"]), "") . "\">Edit</a> <a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">View</a></td>
</tr>";
        }
        $list = implode("\n", $list);

        $article_list = "<h3 class=\"bg-primary\">All articles</h3>

<table class=\"table\">
<tr>
<th>Id</th>
<th>Title</th>
<th>Slug</th>
<th>Category</th>
<th>Tags</th>
<th>Medias</th>
<th>Date</th>
<th>Comments</th>
<th>Operate</th>
</tr>
" . $list . "
</table>";
    
        $main = "<div>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.write", ""), array(), "") . "\">Write an article</a></p>
" .$article_list . "
</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
