<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_category_table extends widget
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
    private function get_html($categories)
    {
        $category_link_list = array();

        foreach ($categories as $key => $category)
        {
            if (($key + 1) % 2 === 0)
            {
                $alternate = "even";
            }
            else
            {
                $alternate = "odd";
            }

            if (is_null($category->get_parent()) === TRUE)
            {
                $parent_link = "<span>NULL</span>";
            }
            else
            {
                $parent_link = html::a(
                    htmlspecialchars($category->get_parent()->record["name"]),
                    url::get(array(\swdf::$app->name, "admin/category.show", ""), array("id" => $category->get_parent()->record["id"]), ""),
                    array()
                );
            }

            $category_link_list[] = html::tag(
                "tr",
                html::inline_tag("td", $category->record["id"], array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($category->record["name"]), array()) . "\n" .
                html::inline_tag("td", htmlspecialchars($category->get_full_slug()), array()) . "\n" .
                html::inline_tag("td", $parent_link, array()) . "\n" .
                html::inline_tag(
                    "td",
                    html::a(
                        htmlspecialchars($category->get_article_count()),
                        url::get(
                            array(\swdf::$app->name, "admin/article.list_by_category", ""),
                            array("category_id" => $category->record["id"]),
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
                            array(\swdf::$app->name, "admin/category.delete_confirm", ""),
                            array("id" => $category->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "Edit",
                        url::get(
                            array(\swdf::$app->name, "admin/category.edit", ""),
                            array("id" => $category->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ) .
                    html::a(
                        "View",
                        url::get(
                            array(\swdf::$app->name, "admin/category.show", ""),
                            array("id" => $category->record["id"]),
                            ""
                        ),
                        array("class" => "text-padding-s")
                    ),
                    array()
                ),
                array("class" => $alternate)
            );
        }
        $category_links = implode("\n", $category_link_list);

        $result = html::tag(
            "table",
            html::tag(
                "tr",
                html::inline_tag("th", "Id", array()) . "\n" .
                html::inline_tag("th", "Name", array()) . "\n" .
                html::inline_tag("th", "Full slug", array()) . "\n" .
                html::inline_tag("th", "Parent", array()) . "\n" .
                html::inline_tag("th", "Articles", array()) . "\n" .
                html::inline_tag("th", "Operations", array()),
                array()
            ) . "\n" .
            $category_links,
            array("class" => "alternate-table")
        );

        return $result;
    }
}
?>
