<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_tag_table extends widget
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
        $tag_link_list = array();

        foreach ($tags as $key => $tag)
        {
            if (($key + 1) % 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            $tag_link_list[] = html::tag(
                "tr",
                html::inline_tag("td", $tag->record["id"], array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($tag->record["name"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($tag->record["slug"]), array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        htmlspecialchars($tag->get_article_count()),
                        url::get(
                            array(\swdf::$app->name, "admin/article.list_by_tag", ""),
                            array("tag_id" => $tag->record["id"]),
                            ""
                        ),
                        array()
                    ),
                    array()
                ) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        "Delete",
                        url::get(
                            array(\swdf::$app->name, "admin/tag.delete_confirm", ""),
                            array("id" => $tag->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "Edit",
                        url::get(
                            array(\swdf::$app->name, "admin/tag.edit", ""),
                            array("id" => $tag->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/tag.show", ""),
                            array("id" => $tag->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ),
                    array()
                ),
                array("class" => $alternate)
            );
        }
        $tag_links = implode("\n", $tag_link_list);

        return html::tag(
            "table",
            html::tag(
                "tr",
                html::inline_tag("th", "Id", array()) . "\n" .
                html::inline_tag("th", "Name", array()) . "\n" .
                html::inline_tag("th", "Slug", array()) . "\n" .
                html::inline_tag("th", "Articles", array()) . "\n" .
                html::inline_tag("th", "Operations", array()),
                array()
            ) . "\n" .
            $tag_links,
            array("class" => "alternate-table")
        );
    }
}
?>
