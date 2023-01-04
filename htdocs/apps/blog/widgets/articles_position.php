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
            "Articles",
            url::get(
                array(\swdf::$app->name, "guest/article.list_all", ""),
                array(),
                ""
            ),
            array()
        );

        foreach ($category_path as $category)
        {
            $html[] = html::a(
                htmlspecialchars($category->record["name"]),
                url::get(
                    array(\swdf::$app->name, "guest/article.slug_list_by_category", ""),
                    array("full_category_slug" => $category->get_full_slug()),
                    ""
                ),
                array()
            );
        }

        return $html;
    }
}
?>
