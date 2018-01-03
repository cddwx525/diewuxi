<?php
namespace blog\views\admin\comment;

use blog\lib\url;
use blog\lib\views\admin_base;

class add extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $article = $result["article"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Comment under " . $article["title"];
        $position = " > Add comment";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Comment failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">Return to article</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Comment have been added successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">Return to article</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Comment under: [<a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">" . htmlspecialchars($article["title"]) . "</a>]</h3>
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
