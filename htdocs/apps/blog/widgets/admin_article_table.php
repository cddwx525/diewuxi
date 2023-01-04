<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_article_table extends widget
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
    private function get_html($articles)
    {
        $article_link_list = array();

        foreach ($articles as $key => $article)
        {
            if (($key + 1) % 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            if (empty($article->get_tags()) === TRUE)
            {
                $tag_links = "<span>NULL</span>";
            }
            else
            {
                $tag_link_list = array();
                foreach ($article->get_tags() as $tag)
                {
                    $tag_link_list[] = html::a(
                        htmlspecialchars($tag->record["name"]),
                        url::get(
                            array(\swdf::$app->name, "admin/tag.show", ""),
                            array("id" => $tag->record["id"]),
                            ""
                        ),
                        array()
                    );
                }
                $tag_links = implode(", ", $tag_link_list);
            }

            $article_link_list[] = html::tag(
                "tr",
                html::inline_tag("td", $article->record["id"], array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($article->record["title"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($article->record["slug"]), array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        htmlspecialchars($article->get_category()->get_full_name()),
                        url::get(
                            array(\swdf::$app->name, "admin/category.show", ""),
                            array("id" => $article->record["category_id"]),
                            ""
                        ),
                        array()
                    ),
                    array()
                ) . "\n" .
                html::inline_tag("td", $tag_links, array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        htmlspecialchars($article->get_file_count()),
                        url::get(
                            array(\swdf::$app->name, "admin/file.list_by_article", ""),
                            array("article_id" => $article->record["id"]),
                            ""
                        ),
                        array()
                    ),
                    array()
                ) . "\n" .
                html::inline_tag("td", $article->record["date"], array()) . "\n" .
                html::inline_tag("td", $article->get_comment_count(), array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        "Delete",
                        url::get(
                            array(\swdf::$app->name, "admin/article.delete_confirm", ""),
                            array("id" => $article->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "Edit",
                        url::get(
                            array(\swdf::$app->name, "admin/article.edit", ""),
                            array("id" => $article->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/article.show", ""),
                            array("id" => $article->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ),
                    array()
                ),
                array("class" => $alternate)
            );
        }
        $article_links = implode("\n", $article_link_list);

        $result = html::tag(
            "table",
            html::tag(
                "tr",
                html::inline_tag("th", "Id", array()) . "\n" .
                html::inline_tag("th", "Title", array()) . "\n" .
                html::inline_tag("th", "Slug", array()) . "\n" .
                html::inline_tag("th", "Category", array()) . "\n" .
                html::inline_tag("th", "Tags", array()) . "\n" .
                html::inline_tag("th", "Files", array()) . "\n" .
                html::inline_tag("th", "Date", array()) . "\n" .
                html::inline_tag("th", "Comments", array()) . "\n" .
                html::inline_tag("th", "Operations", array()),
                array()
            ) . "\n" .
            $article_links,
            array("class" => "alternate-table")
        );

        return $result;
    }
}
?>
