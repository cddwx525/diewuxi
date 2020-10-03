<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_category_tree extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_categories($config["data"]);
    }


    /**
     *
     *
     */
    private function get_categories($category_tree)
    {
        if (empty($category_tree))
        {
            $category_link = "<p>There is no category now.</p>";
        }
        else
        {
            $category_link = $this->recusive_categories($category_tree);
        }

        return $category_link;
    }


    /**
     *
     *
     */
    private function recusive_categories($category_tree)
    {
        $category_link_list = array();

        foreach ($category_tree as $node)
        {
            $category_link_list[] = html::inline_tag(
                "li",
                html::a(
                    htmlspecialchars($node["name"]),
                    url::get(
                        array(\swdf::$app->name, "admin/category.show", ""),
                        array("id" => $node["id"]),
                        ""
                    ),
                    array()
                ) .
                html::inline_tag(
                    "span",
                    htmlspecialchars($node["full_slug"]),
                    array("class" => "text-padding-s")
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
                $category_link_list[] = $this->recusive_categories($node["son"]);
            }
            else
            {
            }
        }

        return html::tag("ul", implode("\n", $category_link_list), array());
    }
}
?>
