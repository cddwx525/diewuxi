<?php
namespace blog\models;

use swdf\base\model;

class user extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "user";
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        $this->record = $this->select_by_id($id)["record"];

        return $this;
    }



    /**
     *
     *
     */
    public function get_by_name($name)
    {
        $where = array(
            array(
                "field" => "name",
                "value" => $name,
                "operator" => "=",
                "condition" => "",
            ),
        );

        $this->record = $this->where($where)->select_first()["record"];

        return $this;
    }



    /**
     *
     *
     */
    public function update_form_stamp()
    {
        $this->update_by_id($this->record["id"], array("form_stamp" => bin2hex(openssl_random_pseudo_bytes(32)),));

        return $this->get_by_id($this->record["id"]);
    }



    /**
     *
     *
     */
    public function update_data()
    {
        $data_user = array(
            "name"          => \swdf::$app->request["post"]["name"],
            "password_hash" => password_hash(\swdf::$app->request["post"]["password"], PASSWORD_DEFAULT),
            "serial"        => bin2hex(openssl_random_pseudo_bytes(32)),
        );

        $this->update_by_id($this->record["id"], $data_user);

        $this->get_by_id($this->record["id"]);
    }



    /**
     *
     *
     */
    public function login()
    {
        if (
            (isset(\swdf::$app->request["post"]["name"])        === FALSE) ||
            (isset(\swdf::$app->request["post"]["password"])    === FALSE)
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
                $where = array(
                    array(
                        "field" => "name",
                        "value" => \swdf::$app->request["post"]["name"],
                        "operator" => "=",
                        "condition" => "",
                    ),
                );

                if (empty($this->where($where)->select()["record"]) === TRUE)
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Username or password wrong."
                    );
                }
                else
                {
                    $record = $this->where($where)->select_first()["record"];

                    if (password_verify(\swdf::$app->request["post"]["password"], $record["password_hash"]) === FALSE)
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Username or password wrong."
                        );
                    }
                    else
                    {
                        //
                        // Login OK.
                        //

                        session_start();
                        session_regenerate_id();
                        session_write_close();

                        $current_time = time();
                        $data_user = array(
                            "session_time_stamp"    => $current_time,
                            "last_session_id"       => session_id()
                        );

                        $this->update_by_id($record["id"], $data_user);

                        session_start();
                        $_SESSION["login_time"]     = $current_time;
                        $_SESSION["name"]           = \swdf::$app->request["post"]["name"];
                        session_write_close();

                        // Set cookies to remember.
                        if (isset(\swdf::$app->request["post"]["remember"]) === TRUE)
                        {
                            $stamp = bin2hex(openssl_random_pseudo_bytes(32));
                            $this->update_by_id($record["id"], array("stamp" => $stamp));

                            setcookie("name", \swdf::$app->request["post"]["name"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                            setcookie("serial", $record["serial"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                            setcookie("stamp", $stamp, time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        }
                        else
                        {
                        }

                        $this->get_by_id($record["id"]);

                        return array(
                            "result" => TRUE,
                        );
                    }
                }
            }
        }
    }


    /**
     *
     *
     */
    public function logout()
    {
        // Unset cookies if set.
        if (isset($_COOKIE["name"]))
        {
            setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
        }
        else
        {
        }

        if (isset($_COOKIE["serial"]))
        {
            setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
        }
        else
        {
        }

        if (isset($_COOKIE["stamp"]))
        {
            setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);
        }
        else
        {
        }

        // Unset session.
        session_start();
        session_unset();
        session_destroy();
        //session_regenerate_id(TRUE);
        session_write_close();

        return TRUE;
    }




    /**
     *
     *
     */
     public function validate_password($password)
     {
        // Filter password uncomplete.
        if (
            (isset($password) === FALSE) ||
            ($password === "")
        )
        {
            return array(
                "result" => FALSE,
                "message" => "Password not set or empty."
            );
        }
        else
        {
            // Filter password wrong.
            if (password_verify($password, $this->record["password_hash"]) === FALSE)
            {
                return array(
                    "result" => FALSE,
                    "message" => "Password wrong."
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
    public function validate()
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
                (isset(\swdf::$app->request["post"]["name"])                === FALSE) ||
                (isset(\swdf::$app->request["post"]["password"])            === FALSE) ||
                (isset(\swdf::$app->request["post"]["confirm_password"])    === FALSE) ||
                (isset(\swdf::$app->request["post"]["current_password"])    === FALSE)
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
                    (\swdf::$app->request["post"]["name"]               === "") ||
                    (\swdf::$app->request["post"]["password"]           === "") ||
                    (\swdf::$app->request["post"]["confirm_password"]   === "") ||
                    (\swdf::$app->request["post"]["current_password"]   === "")
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



    /**
     *
     *
     */
    public function validate_update()
    {
        $ret = $this->validate();

        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            // Filter password confirm wrong.
            if (\swdf::$app->request["post"]["password"] !== \swdf::$app->request["post"]["confirm_password"])
            {
                return array(
                    "result" => FALSE,
                    "message" => "Password confirm wrong."
                );
            }
            else
            {
                // Filter current password wrong.
                if (password_verify(\swdf::$app->request["post"]["current_password"], $this->record["password_hash"]) === FALSE)
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Current password wrong."
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
