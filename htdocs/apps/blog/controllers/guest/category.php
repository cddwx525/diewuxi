<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\category as category_model;

class category extends controller
{
    /**
     *
     *
     */
    protected function get_behaviors()
    {
        return array(
            array(
                "class" => init::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_config",
                        array()
                    )
                ),
            ),
            array(
                "class" => side_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => TRUE,
                )
            ),
        );
    }


    /**
     *
     *
     */
    public function list_all()
    {
        $category = new category_model();

        $root_categories = $category->get_root();

        return array(
            "guest/category/list_all",
            array(
                "root_categories" => $root_categories,
            )
        );
    }


    /**
     * Function slug show.
     */
    public function slug_show()
    {
        $category = new category_model();

        if ($category->get_is_full_slug(\swdf::$app->request["get"]["full_slug"]) === FALSE)
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_full_slug(\swdf::$app->request["get"]["full_slug"]);

            return array(
                "guest/category/show",
                array(
                    "category" => $category,
                )
            );
        }
    }
}
?>
