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
    public function get_user($user)
    {
        return $user;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_user($user);
    }


    /**
     *
     *
     */
    public function generate_form_stamp($user)
    {
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        $this->update_by_id((int) $user["id"], array("form_stamp" => $form_stamp,));

        return $form_stamp;
    }


    /**
     *
     *
     */
    public function login($data)
    {
        if (
            (! isset($data["name"])) ||
            (! isset($data["password"]))
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
                ($data["name"] === "") ||
                ($data["password"] === "")
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
                        "value" => $data["name"],
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
                $user = $this->where($where)->select()["record"];

                if (empty($user))
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Username or password wrong."
                    );
                }
                else
                {
                    $one_user = $this->where($where)->select_first()["record"];

                    if (password_verify($data["password"], $one_user["password_hash"]) === FALSE)
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Username or password wrong."
                        );
                    }
                    else
                    {
                        session_start();
                        session_regenerate_id();
                        session_write_close();

                        $current_time = time();
                        $update_data = array(
                            "session_time_stamp" => $current_time,
                            "last_session_id" => session_id()
                        );

                        $user_update = $this->update_by_id((int) $one_user["id"], $update_data);

                        session_start();
                        $_SESSION["login_time"] = $current_time;
                        $_SESSION["name"] = $data["name"];
                        session_write_close();

                        // Set cookies to remember.
                        if (isset($data["remember"]))
                        {
                            $stamp = bin2hex(openssl_random_pseudo_bytes(32));
                            $user_update = $this->update_by_id((int) $one_user["id"], array("stamp" => $stamp));

                            setcookie("name", $data["name"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                            setcookie("serial", $one_user["serial"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                            setcookie("stamp", $stamp, time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        }
                        else
                        {
                        }

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
}
?>
