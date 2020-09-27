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
        return $this->get_tags($config["data"]);
    }


    /**
     *
     *
     */
    private function get_tags($tags)
    {
        if (empty($tags))
        {
            $tag_list = "<p>There is no tags now.</p>";
        }
        else
        {
            $tag_link_list = array();
            foreach ($tags as $one_tag)
            {
                $tag_link_list[] = html::inline_tag(
                    "span",
                    html::a(
                        htmlspecialchars($one_tag["name"]),
                        url::get(
                            array(\swdf::$app->name, "guest/tag.slug_show", ""),
                            array("slug" => $one_tag["slug"]),
                            ""
                        ),
                        array()
                    ) .
                    html::inline_tag(
                        "span",
                        "[" . $one_tag["article_count"] . "]",
                        array()
                    ),
                    array()
                );
            }

            $tag_link = implode("\n", $tag_link_list);
        }
        return $tag_link;
    }
}
?>
