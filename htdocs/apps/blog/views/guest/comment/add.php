<?php
namespace blog\views\guest\comment;

use blog\lib\url;
use blog\lib\views\guest_base;

class add extends guest_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $article = $result["article"];


        $title = "Comment under " . $article["title"];

        $position = " > Add comment";


        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Comment failed!</p>
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">Return to article</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Comment is added Successfully!</p>
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">Return to article</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\">
<h3>Add comment under: [<a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</h3>
</div>

<div class=\"message border_frame\">
" . $message . "
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
