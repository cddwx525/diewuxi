<?php
namespace blog\widgets;

use swdf\helpers\url;
use swdf\helpers\html;
use swdf\base\widget;

class admin_category_path extends widget
{
    /**
     *
     *
     */
    protected function run($config)
    {
        return $this->get_category_path($config["data"]);
    }


    /**
     *
     *
     */
    private function get_category_path($category)
    {
        $category_path_list = array();
        foreach ($category["path"]  as $one_category)
        {
            $category_path_list[] = html::a(
                htmlspecialchars($one_category["name"]),
                url::get(
                    array(\swdf::$app->name, "admin/article.list_category", ""),
                    array("category_id" => $one_category["id"]),
                    ""
                ),
                array()
            );
        }

        return implode("/", $category_path_list);
    }
}
?>
