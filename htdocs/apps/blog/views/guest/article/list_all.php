<?php
namespace blog\views\guest\article;

use blog\lib\url;
use blog\lib\views\guest_base;

class list_all extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $articles = $result["articles"];
        $parameters = $result["parameters"];


        $title = "All articles";

        $position = " > <a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.list_all", ""), array(), "") . "\">All articles</a>";


        if (empty($articles))
        {
            $article_list = "<p>There is no articles now.</p>";
        }
        else
        {
            $article_list = array();
            foreach ($articles as $article)
            {
                if (empty($article["tag"]))
                {
                    $article_tag_links = "<span>NULL</span>";
                }
                else
                {
                    $article_tag_links = array();
                    foreach ($article["tag"] as $tag)
                    {
                        $article_tag_links[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.show", ""), array("id" => $tag["id"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
                    }
                    $article_tag_links = implode(", ", $article_tag_links);
                }

                $article_list[] = "<div class=\"article_entry\">
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a></p>
<div class=\"article_entry_information\">

<ul>
<li><span>Category: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.show", ""), array("id" => $article["category_id"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></span></li>
<li><span>Tag: </span><span>" . $article_tag_links . "</span></li>
<li><span>Date: </span><span class=\"description\">" . $article["date"]  . "</span></li>
</ul>

</div>
</div>";
            }
            $article_list = implode("\n", $article_list);
        }

        $content = "<div class=\"content_title border_frame\">
<h3>All articles</h3>
</div>

<div id=\"article_list\" class=\"border_frame\">
" . $article_list . "
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
