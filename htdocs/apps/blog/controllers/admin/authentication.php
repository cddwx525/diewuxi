<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;

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
                        "admin/common/already_login",
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
        $ret = \swdf::$app->data["user"]->login();

        if ($ret["result"] === FALSE)
        {
            return array(
                "common/message",
                array(
                    "source" => "Login",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/authentication.write", ""), array(), ""),
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
        \swdf::$app->data["user"]->logout();

        return array(
            "admin/authentication/logout",
            array()
        );
    }


}
?>
