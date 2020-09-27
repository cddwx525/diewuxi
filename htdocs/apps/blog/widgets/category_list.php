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
        return $this->get_category_list($config["data"]);
    }


    /**
     *
     *
     */
    private function get_category_list($categories)
    {
        $category_link_list = array();
        foreach ($categories  as $one_category)
        {
            $category_link_list[] = html::tag(
                "div",
                html::inline_tag(
                    "p",
                    html::a(
                        htmlspecialchars($one_category["name"]) . ">>",
                        url::get(
                            array(\swdf::$app->name, "guest/article.slug_list_category", ""),
                            array("full_category_slug" => $one_category["full_slug"]),
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
