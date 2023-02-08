<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class category_path extends widget
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
    private function get_html($category)
    {
        $category_path_list = array();
        foreach ($category->get_path()  as $one_category)
        {
            $category_path_list[] = html::a(
                htmlspecialchars($one_category->record["name"]),
                url::get(
                    array(\swdf::$app->name, "guest/article.slug_list_by_category", ""),
                    array("full_category_slug" => $one_category->get_full_slug()),
                    ""
                ),
                array()
            );
        }

        return implode("/", $category_path_list);
    }
}
?>
