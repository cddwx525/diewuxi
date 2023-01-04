<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class category_list extends widget
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
        foreach ($categories  as $category)
        {
            $category_link_list[] = html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        htmlspecialchars($category->record["name"]) . ">>",
                        url::get(
                            array(\swdf::$app->name, "guest/article.slug_list_by_category", ""),
                            array("full_category_slug" => $category->get_full_slug()),
                            ""
                        ),
                        array()
                    ),
                    array()
                ),
                array()
            );
        }

        return implode("\n", $category_link_list);
    }
}
?>
