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
        $articles = $config["data"];

        return $this->get_articles($articles);
    }


    /**
     *
     *
     */
    private function get_articles($articles)
    {
        if (empty($articles))
        {
            $articles_link = html::inline_tag(
                "p",
                "There is no articles now.",
                array()
            );
        }
        else
        {
            // Get tag links.
            $article_link_list = array();
            foreach ($articles as $article)
            {
                if (empty($article["tags"]))
                {
                    $tag_links = html::inline_tag("span", "NULL", array());
                }
                else
                {
                    $tag_link_list = array();
                    foreach ($article["tags"] as $tag)
                    {
                        $tag_link_list[] = html::a(
                            htmlspecialchars($tag["name"]),
                            url::get(
                                array(\swdf::$app->name, "guest/tag.slug_show", ""),
                                array("slug" => $tag["slug"]),
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
                            htmlspecialchars($article["title"]),
                            url::get(
                                array(\swdf::$app->name, "guest/article.slug_show", ""),
                                array("full_slug" => $article["full_slug"]),
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
                                    htmlspecialchars($article["category"]["full_name"]),
                                    url::get(
                                        array(\swdf::$app->name, "guest/category.slug_show", ""),
                                        array("full_slug" => $article["category"]["full_slug"]),
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
                            html::inline_tag("span", $article["date"], array()),
                            array()
                        ),
                        array()
                    ),
                    array()
                );
            }
            $articles_link = implode("\n", $article_link_list);
        }

        return $articles_link;
    }
}
?>
