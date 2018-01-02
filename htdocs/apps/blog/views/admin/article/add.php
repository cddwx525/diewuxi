<?php
namespace blog\views\admin\article;

use blog\lib\url;
use blog\lib\views\admin_base;

class add extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Add article";
        $position = " > Add article";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Add failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.write", ""), array(), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Article have been added successfully!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.show", ""), array("id" => $result["article_add"]["last_id"]), "") . "\">View</a></p> 
<p><a href=\"" . $url->get(array($app_space_name, "admin/article.list_all", ""), array(), "") . "\">Article list</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Add article</h3>
</div>

<div class=\"message border_frame\">
" . $message . "
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
