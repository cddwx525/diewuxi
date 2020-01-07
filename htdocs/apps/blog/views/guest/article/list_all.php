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

        $position = " > All articles";


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

                $article_list[] = "<div>
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a></p>

<ul>
<li><span>Category: </span><span><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/category.slug_show", ""), array("category_slug" => $article["category"]["slug"]), "") . "\">" . htmlspecialchars($article["category"]["name"]) . "</a></span></li>
<li><span>Tag: </span><span>" . $article_tag_links . "</span></li>
<li><span>Date: </span><span class=\"text-muted\">" . $article["date"]  . "</span></li>
</ul>
</div>";
            }
            $article_list = implode("\n", $article_list);
        }

        $content = "<h3 class=\"bg-primary\">All articles</h3>
<div>
" . $article_list . "
</div>";

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
