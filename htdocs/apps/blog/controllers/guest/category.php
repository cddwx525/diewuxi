<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\config_state;
use blog\filters\init;
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
                "class" => config_state::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_conig",
                        array()
                    )
                ),
            ),
            array(
                "class" => init::class,
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
        $category_model = new category_model();

        $category_tree = $category_model->get_tree();

        return array(
            "guest/category/list_all",
            array(
                "category_tree" => $category_tree,
            )
        );
    }


    /**
     * Function slug show.
     */
    public function slug_show()
    {
        $category_model = new category_model();

        $full_slug = \swdf::$app->request["get"]["full_slug"];

        if ($category_model->get_is_full_slug($full_slug) === TRUE)
        {
            $category = $category_model->get_by_full_slug($full_slug);

            return array(
                "guest/category/show",
                array(
                    "category" => $category,
                )
            );
        }
        else
        {
            return array(
                "common/not_found",
                array()
            );
        }
    }
}
?>
