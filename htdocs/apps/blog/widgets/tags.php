<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class tags extends widget
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
        if (empty($tags) === TRUE)
        {
            $html = "<p>There is no tags now.</p>";
        }
        else
        {
            $tag_link_list = array();

            foreach ($tags as $one_tag)
            {
                $tag_link_list[] = html::inline_tag(
                    "span",
                    html::a(
                        htmlspecialchars($one_tag->record["name"]),
                        url::get(
                            array(\swdf::$app->name, "guest/tag.slug_show", ""),
                            array("slug" => $one_tag->record["slug"]),
                            ""
                        ),
                        array()
                    ) .
                    html::inline_tag(
                        "span",
                        "[" . $one_tag->get_article_count() . "]",
                        array()
                    ),
                    array()
                );
            }

            $html = implode("\n", $tag_link_list);
        }
        return $html;
    }
}
?>
