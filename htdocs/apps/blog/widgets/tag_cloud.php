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

        foreach ($tags as $one_tag)
        {
            $tag_list[] = html::a(
                html::inline_tag(
                    "span",
                    htmlspecialchars($one_tag->record["name"]),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    "[" . $one_tag->get_article_count() . "]",
                    array()
                ),
                url::get(
                    array( \swdf::$app->name, "guest/article.slug_list_by_tag", ""),
                    array("tag_slug" => $one_tag->record["slug"]),
                    ""
                ),
                array("class" => "tag")
            );
        }

        return implode("\n", $tag_list);
    }
}
?>
