<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\config_state;
use blog\filters\init;
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
        $tag_model = new tag_model();

        $tags = $tag_model->get_tags();

        return array(
            "guest/tag/list_all",
            array(
                "tags" => $tags,
            )
        );
    }




    /**
     * Function slug show.
     *
     */
    public function slug_show()
    {
        $tag_model = new tag_model();

        if ($tag_model->get_is_slug(\swdf::$app->request["get"]["slug"]) === FALSE)
        {

            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $tag = $tag_model->get_by_slug(\swdf::$app->request["get"]["slug"]);

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
