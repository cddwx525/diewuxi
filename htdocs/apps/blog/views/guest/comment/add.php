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
            $message = "<p class=\"text-warning\">[" . $state . "], Comment failed!</p>
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">Return to article</a></p>"; 
        }
        else
        {
            $message = "<p class=\"text-success\">Comment is added Successfully!</p>
<p><a href=\"" . $url->get(array($result["meta_data"]["settings"]["app_space_name"], "guest/article.slug_show", ""), array("full_article_slug" => $article["full_slug"]), "") . "\">Return to article</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Add comment under: [" . htmlspecialchars($article["title"]) . "]</h3>
" . $message;

        $main = "<div>" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
