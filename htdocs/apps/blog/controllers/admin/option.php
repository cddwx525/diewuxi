<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\models\option as option_model;

class option extends controller
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
    public function edit()
    {
        return array(
            "admin/option/edit",
            array(
                "user" => \swdf::$app->data["user"],
                "form_stamp" => \swdf::$app->data["user"]->update_form_stamp()->record["form_stamp"],
            )
        );
    }


    /**
     *
     *
     */
    public function update()
    {
        $option = new option_model();

        $ret = $option->validate_update();

        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Update site option",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/option.edit", ""), array(), ""),
                )
            );
        }
        else
        {
            $option->update_data();

            return array(
                "admin/option/update",
                array()
            );
        }
    }

}
?>
