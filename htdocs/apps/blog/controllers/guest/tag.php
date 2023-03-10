<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\tag as tag_model;

class tag extends controller
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
        $tag = new tag_model();

        return array(
            "guest/tag/list_all",
            array(
                "tags" => $tag->find_all(),
            )
        );
    }




    /**
     * Function slug show.
     *
     */
    public function slug_show()
    {
        $tag = new tag_model();

        if ($tag->get_is_slug(\swdf::$app->request["get"]["slug"]) === FALSE)
        {

            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_slug(\swdf::$app->request["get"]["slug"]);

            return array(
                "guest/tag/show",
                array(
                    "tag" => $tag,
                )
            );
        }
    }
}
?>
