<?php
namespace blog\controllers\admin;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\models\user;

class authentication extends controller
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
                "actions" => array("write", "login"),
                "rule" => array(
                    "true" => array(
                        "common/already_login",
                        array()
                    ),
                    "false" => TRUE,
                )
            ),
            array(
                "class" => user_data::class,
                "actions" => array("logout"),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_login",
                        array()
                    ),
                )
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
            "admin/authentication/write",
            array()
        );
    }


    /**
     *
     *
     */
    public function login()
    {
        $user_model = new user();

        $result = $user_model->login(\swdf::$app->request["post"]);
        if (! $result["result"])
        {
            return array(
                "common/message",
                array(
                    "source" => "Login",
                    "message" => $result["message"],
                )
            );
        }
        else
        {
            return array(
                "admin/authentication/login",
                array()
            );
        }
    }


    /**
     *
     *
     */
    public function logout()
    {
        $user_model = new user();
        $user_model->logout();

        return array(
            "admin/authentication/logout",
            array()
        );
    }


}
?>
