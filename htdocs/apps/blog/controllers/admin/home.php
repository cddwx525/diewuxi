<?php
namespace blog\controllers\admin;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;

class home extends controller
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
                "class" => user_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_login",
                        array()
                    )
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
            "admin/home",
            array()
        );
    }
}
?>
