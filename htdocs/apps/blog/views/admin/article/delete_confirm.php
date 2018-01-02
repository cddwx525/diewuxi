<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class delete_confirm extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $article = $result["article"];
        $comment_count = $result["comment_count"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Confirm delete article";
        $position = " > Confirm delete article";


        if (empty($article["tag"]))
        {
            $article_tag_names = "<span>NULL</span>";
        }
        else
        {
            $article_tag_names = array();
            foreach ($article["tag"] as $tag)
            {
                $article_tag_names[] = "<a href=\"" . $url->get(array($app_space_name, "admin/tag.show", ""), array("id" => $tag["id"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
            }
            $article_tag_names = implode(" ", $article_tag_names);
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Confirm delete article</h3>
</div>

<div class=\"message border_frame\">
<p>The information of the article are:</p>

<div id=\"article_information\">
<ul>
<li><span>Title: </span><span class=\"description\">" . htmlspecialchars($article["title"]) . "</span></li>
<li><span>Category: </span><span class=\"description\"><a href=\"" . $url->get(array($app_space_name, "admin/category.show", ""), array("id" => $article["category"]["id"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></span></li>
<li><span>Tag: </span><span class=\"description\">" . $article_tag_names . "</span></li>
<li><span>Date: </span><span class=\"description\">" . $article["date"] . "</span></li>
<li><span>Comments count: </span><span class=\"description\">" . $comment_count . "</span></li>
</ul>
</div>

<form action=\"" . $url->get(array($app_space_name, "admin/article.delete", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"id\" value=\"" . $article["id"] . "\" /></p>

<p>Please input the password to confirm the action: </p>
<p><input type=\"password\" name=\"password\" value=\"\" id=\"\" /> <input type=\"submit\" name=\"confirm\" value=\"Confirm\" /></p>
</form>

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
