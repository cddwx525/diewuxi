<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_tags extends widget
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
            $html = "<span>There is no tag now.</span>";
        }
        else
        {
            $tags_link_list = array();
            foreach ($tags as $one_tag)
            {
                $tags_link_list[] = html::a(
                    htmlspecialchars($one_tag->record["name"]),
                    url::get(
                        array(\swdf::$app->name, "admin/tag.show", ""),
                        array("id" => $one_tag->record["id"]),
                        ""
                    ),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    htmlspecialchars($one_tag->record["slug"]),
                    array("class" => "text-padding-s")
                ) .
                html::inline_tag(
                    "span",
                    "[" . $one_tag->get_article_count() . "]",
                    array()
                );
            }
            $html = implode(", ", $tags_link_list);
        }

        return $html;
    }
}
?>
