<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class article_list extends widget
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
        if (empty($articles) === TRUE)
        {
            $html = html::inline_tag(
                "p",
                "There is no articles now.",
                array()
            );
        }
        else
        {
            $article_link_list = array();
            foreach ($articles as $one_article)
            {
                if (empty($one_article->get_tags()) === TRUE)
                {
                    $tag_links = html::inline_tag("span", "NULL", array());
                }
                else
                {
                    $tag_link_list = array();
                    foreach ($one_article->get_tags() as $tag)
                    {
                        $tag_link_list[] = html::a(
                            htmlspecialchars($tag->record["name"]),
                            url::get(
                                array(\swdf::$app->name, "guest/tag.slug_show", ""),
                                array("slug" => $tag->record["slug"]),
                                ""
                            ),
                            array()
                        );
                    }
                    $tag_links = implode(", ", $tag_link_list);
                }


                $article_link_list[] = html::tag(
                    "div",
                    html::inline_tag(
                        "p",
                        html::a(
                            htmlspecialchars($one_article->record["title"]),
                            url::get(
                                array(\swdf::$app->name, "guest/article.slug_show", ""),
                                array("full_slug" => $one_article->get_full_slug()),
                                ""
                            ),
                            array()
                        ),
                        array()
                    ) .
                    "\n\n" .
                    html::tag(
                        "ul",
                        html::inline_tag(
                            "li",
                            html::inline_tag("span", "Category: ", array()) .
                            html::inline_tag(
                                "span",
                                html::a(
                                    htmlspecialchars($one_article->get_category()->get_full_name()),
                                    url::get(
                                        array(\swdf::$app->name, "guest/category.slug_show", ""),
                                        array("full_slug" => $one_article->get_category()->get_full_slug()),
                                        ""
                                    ),
                                    array()
                                ),
                                array()
                            ),
                            array()
                        ) .
                        "\n" .
                        html::inline_tag(
                            "li",
                            html::inline_tag("span", "Tags: ", array()) .
                            html::inline_tag("span", $tag_links, array()),
                            array()
                        ) .
                        "\n" .
                        html::inline_tag(
                            "li",
                            html::inline_tag("span", "Date: ", array()) .
                            html::inline_tag("span", $one_article->record["date"], array()),
                            array()
                        ),
                        array()
                    ),
                    array()
                );
            }
            $html = implode("\n", $article_link_list);
        }

        return $html;
    }
}
?>
