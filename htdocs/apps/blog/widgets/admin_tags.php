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
            $tags_link = "<span>There is no tag now.</span>";
        }
        else
        {
            $tags_link_list = array();
            foreach ($tags as $tag)
            {
                $tags_link_list[] = html::a(
                    htmlspecialchars($tag["name"]),
                    url::get(
                        array(\swdf::$app->name, "admin/article.list_tag", ""),
                        array("tag_id" => $tag["id"]),
                        ""
                    ),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    htmlspecialchars($tag["slug"]),
                    array("class" => "text-padding-s")
                ) .
                html::inline_tag(
                    "span",
                    "[" . $tag["article_count"] . "]",
                    array()
                );
            }
            $tags_link = implode(", ", $tags_link_list);
        }

        return $tags_link;
    }
}
?>
