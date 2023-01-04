<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class categories_position extends widget
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
    private function get_html($category_path)
    {
        $html = array();
        $html[] = html::a(
            "Categories",
            url::get(
                array(\swdf::$app->name, "guest/category.list_all", ""),
                array(),
                ""
            ),
            array()
        );

        foreach ($category_path as $one_category)
        {
            $html[] = html::a(
                htmlspecialchars($one_category->record["name"]),
                url::get(
                    array(\swdf::$app->name, "guest/category.slug_show", ""),
                    array("full_slug" => $one_category->get_full_slug()),
                    ""
                ),
                array()
            );
        }

        return $html;
    }
}
?>
