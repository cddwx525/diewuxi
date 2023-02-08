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
            $html = "<span>NULL</span>";
        }
        else
        {
            $tags_link_list = array();
            foreach ($tags as $one_tag)
            {
                $tags_link_list[] = html::a(
                    htmlspecialchars($one_tag->record["name"]),
                    url::get(
                        array(\swdf::$app->name, "guest/article.slug_list_by_tag", ""),
                        array("tag_slug" => $one_tag->record["slug"]),
                        ""
                    ),
                    array()
                );
            }
            $html = implode(", ", $tags_link_list);
        }

        return $html;
    }
}
?>
