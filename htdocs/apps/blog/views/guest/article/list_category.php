<?php
namespace blog\views\guest\article;

use blog\lib\url;
use blog\lib\views\guest_base;

class list_category extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $category = $result["category"];
        $articles = $result["articles"];


        $title = "Articles in category [" . $category["name"] . "]";

        $position = " > Category: " . htmlspecialchars($category["name"]);

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
                        $article_tag_links[] = "<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/tag.slug_show", ""), array("tag_slug" => $tag["slug"]), "") . "\">" . htmlspecialchars($tag["name"]) . "</a>";
                    }
                    $article_tag_links = implode(", ", $article_tag_links);
                }

                $article_list[] = "<div class=\"article_entry\">
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a></p>

<div class=\"article_entry_information\">

<ul>
<li><span>Category: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.slug_show", ""), array("category_slug" => $article["category"]["slug"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></span></li>
<li><span>Tag: </span><span>" . $article_tag_links . "</span></li>
<li><span>Date: </span><span class=\"description\">" . $article["date"]  . "</span></li>
</ul>

</div>
</div>";
            }
            $article_list = implode("\n", $article_list);
        }


        $content = "<div class=\"content_title border_frame\">
<h3>Articles in category [" . htmlspecialchars($category["name"]) . "]</h3>
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

    public function get_string($result)
    {
        return "list category";
    }
}
?>
