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
            $message = "<p class=\"text-warning\">[" . $state . "], Comment failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">Return to article</a></p>"; 
        }
        else
        {
            $message = "<p class=\"text-success\">Comment have been added successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $article["id"]), "") . "\">Return to article</a></p>"; 
        }

        $content = "<h3 class=\"bg-primary\">Comment under: [" . htmlspecialchars($article["title"]) . "]</h3>

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
