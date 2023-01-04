<?php
namespace blog\controllers\admin;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\models\option;
use blog\models\page;

class config extends controller
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
                    "true" => array(
                        "common/already_config",
                        array()
                    ),
                    "false" => TRUE,
                ),
            ),
        );
    }


    /**
     *
     *
     */
    public function write()
    {
        return array(
            "admin/config/write",
            array()
        );
    }


    /**
     *
     *
     */
    public function save()
    {
        $option = new option();

        $ret = $option->validate();

        if ($ret["result"] === FALSE)
        {
            return array(
                "common/message",
                array(
                    "source" => "Save option",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/config.write", ""), array(), ""),
                )
            );
        }
        else
        {
            $option->add_data();

            return array(
                "admin/config/save",
                array(
                )
            );
        }
    }
}
?>
