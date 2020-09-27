<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class tag_cloud extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        $tags = $config["data"];

        return $this->output_tags($tags);
    }


    /**
     *
     *
     */
    private function output_tags($tags)
    {
        $tag_list = array();
        foreach ($tags as $tag)
        {
            $tag_list[] = html::a(
                htmlspecialchars($tag["name"]),
                url::get(
                    array( \swdf::$app->name, "guest/article.slug_list_tag", ""),
                    array("tag_slug" => $tag["slug"]),
                    ""
                ),
                array("class" => "tag")
            ) .
            html::inline_tag(
                "span",
                "[" . $tag["article_count"] . "]",
                array()
            );
        }

        return implode("\n", $tag_list);
    }
}
?>
