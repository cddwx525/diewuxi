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
        return $this->get_html($config["data"]);
    }


    /**
     *
     *
     */
    private function get_html($tags)
    {
        $tag_list = array();

        foreach ($tags as $tag)
        {
            $tag_list[] = html::a(
                htmlspecialchars($tag->record["name"]),
                url::get(
                    array( \swdf::$app->name, "guest/article.slug_list_by_tag", ""),
                    array("tag_slug" => $tag->record["slug"]),
                    ""
                ),
                array("class" => "tag")
            ) .
            html::inline_tag(
                "span",
                "[" . $tag->get_article_count() . "]",
                array()
            );
        }

        return implode("\n", $tag_list);
    }
}
?>
