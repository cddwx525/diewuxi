<?php
namespace blog\models;

use swdf\base\model;
use blog\models\user;

class option extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "option";
    }



    /**
     *
     *
     */
    public function validate()
    {
        if (
            (isset(\swdf::$app->request["post"]["blog_name"])   === FALSE) ||
            (isset(\swdf::$app->request["post"]["name"])        === FALSE) ||
            (isset(\swdf::$app->request["post"]["password"])    === FALSE)
        )
        {
            return array(
                "result" => FALSE,
                "message" => "Form uncomplete, one or more field not set.",
            );
        }
        else
        {
            if (
                (\swdf::$app->request["post"]["blog_name"]  === "") ||
                (\swdf::$app->request["post"]["name"]       === "") ||
                (\swdf::$app->request["post"]["password"]   === "")
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more necessary field is empty."
                );
            }
            else
            {
                return array(
                    "result" => TRUE,
                );
            }
        }
    }



    /**
     *
     *
     */
    public function add_data()
    {
        $data_option = array(
            array(
                "name" => "flag",
                "value" => "on",
            ),
            array(
                "name" => "blog_name",
                "value" => \swdf::$app->request["post"]["blog_name"],
            ),
            array(
                "name" => "blog_description",
                "value" => \swdf::$app->request["post"]["blog_description"],
            ),
        );

        foreach ($data_option as $one_data)
        {
            $this->add($one_data);
        }


        $data_user = array(
            "name"          => \swdf::$app->request["post"]["name"],
            "password_hash" => password_hash(\swdf::$app->request["post"]["password"], PASSWORD_DEFAULT),
            "serial"        => bin2hex(openssl_random_pseudo_bytes(32)),
            "stamp"         => bin2hex(openssl_random_pseudo_bytes(32)),
            "session_time_stamp"    => time(),
            "last_session_id"       => bin2hex(openssl_random_pseudo_bytes(32)),
        );

        \swdf::$app->data["user"]->add($data_user);
    }




    /**
     *
     *
     */
    public function validate_update()
    {
        $ret = self::validate_basic();

        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            return array(
                "result" => TRUE,
            );
        }
    }




    /**
     *
     *
     */
    public function update_data()
    {
        $data_option = array(
            array(
                "name" => "blog_name",
                "value" => \swdf::$app->request["post"]["blog_name"],
            ),
            array(
                "name" => "blog_description",
                "value" => \swdf::$app->request["post"]["blog_description"],
            ),
        );

        foreach ($data_option as $one_data)
        {
            $where = array(
                array(
                    "field" => "name",
                    "value" => $one_data["name"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $this->where($where)->update($one_data);
        }
    }



    /**
     *
     *
     */
    private static function validate_basic()
    {
        if (
            (isset(\swdf::$app->request["post"]["form_stamp"]) === FALSE) ||
            (\swdf::$app->request["post"]["form_stamp"] !== \swdf::$app->data["user"]->record["form_stamp"])
        )
        {
            return array(
                "result" => FALSE,
                "message" => "XSRF."
            );
        }
        else
        {
            if (
                (isset(\swdf::$app->request["post"]["blog_name"]) === FALSE)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more field not set."
                );
            }
            else
            {
                if (
                    (\swdf::$app->request["post"]["blog_name"] === "")
                )
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Form uncomplete, one or more necessary field is empty."
                    );
                }
                else
                {
                    return array(
                        "result" => TRUE,
                    );
                }
            }
        }
    }
}
?>
