<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class articles_position extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_position($config["data"]);
    }

    /**
     *
     *
     */
    private function get_position($category_path)
    {
        $position_list = array();
        $position_list[] = html::a(
            "Articles",
            url::get(
                array(\swdf::$app->name, "guest/article.list_all", ""),
                array(),
                ""
            ),
            array()
        );

        foreach ($category_path as $one_category)
        {
            $position_list[] = html::a(
                htmlspecialchars($one_category["name"]),
                url::get(
                    array(\swdf::$app->name, "guest/article.slug_list_category", ""),
                    array("full_category_slug" => $one_category["full_slug"]),
                    ""
                ),
                array()
            );
        }

        return $position_list;
    }
}
?>
