<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;

class account extends controller
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
            "admin/account/edit",
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
        $ret = \swdf::$app->data["user"]->validate_update();

        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Update account",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/account.edit", ""), array(), ""),
                )
            );
        }
        else
        {
            \swdf::$app->data["user"]->update_data();
            \swdf::$app->data["user"]->logout();

            return array(
                "admin/account/update",
                array(
                    "user" => \swdf::$app->data["user"],
                )
            );
        }
    }
}
?>
