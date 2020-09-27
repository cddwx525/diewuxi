<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class category_side extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        $category_tree = $config["data"];

        return $this->output_tree($category_tree);
    }


    /**
     *
     *
     */
    private function output_tree($category_tree)
    {
        $category_link_list = array();

        foreach ($category_tree as $node)
        {
            $category_link_list[] = html::inline_tag(
                "li",
                html::a(
                    htmlspecialchars($node["name"]),
                    url::get(
                        array(\swdf::$app->name, "guest/article.slug_list_category", ""),
                        array("full_category_slug" => $node["full_slug"]),
                        ""
                    ),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    "[" . $node["article_count"] . "]",
                    array()
                ),
                array()
            );

            if (! is_null($node["son"]))
            {
                $category_link_list[] = $this->output_tree($node["son"]);
            }
            else
            {
            }
        }

        return html::tag("ul", implode("\n", $category_link_list), array());
    }
}
?>
