<?php
namespace blog\controllers\common;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;

class not_found extends controller
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
    public function show()
    {

        return array(
            "common/not_found",
            array()
        );
    }
}
?>
