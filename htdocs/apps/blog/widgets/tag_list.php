<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class tag_list extends widget
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
            $tags_link = "<span>NULL</span>";
        }
        else
        {
            $tags_link_list = array();
            foreach ($tags as $tag)
            {
                $tags_link_list[] = html::a(
                    htmlspecialchars($tag["name"]),
                    url::get(
                        array(\swdf::$app->name, "guest/article.slug_list_tag", ""),
                        array("tag_slug" => $tag["slug"]),
                        ""
                    ),
                    array()
                );
            }
            $tags_link = implode(", ", $tags_link_list);
        }

        return $tags_link;
    }
}
?>
