<?php
namespace blog\filters;

use blog\models\user;

class user_data
{
    /**
     *
     *
     */
    public function run()
    {
        return $this->set_data();
    }


    /**
     *
     *
     */
    public function set_data()
    {
        $user_model = new user();

        if ($this->get_is_login())
        {
            $where = array(
                array(
                    "field" => "name",
                    "value" => $_SESSION["name"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $user = $user_model->where($where)->select_first()["record"];
            $user = $user_model->get_user($user);

            \swdf::$app->data["user"] = $user;

            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }


    /**
     *
     *
     */
    public function get_is_login()
    {
        $user_model = new user();

        session_start();

        if (! isset($_SESSION["name"]))
        {
            // No session information, check cookies.

            if (! (isset($_COOKIE["name"]) && isset($_COOKIE["serial"]) && isset($_COOKIE["stamp"])))
            {
                // Cookies information uncomplete, remove cookies, return.

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

                session_unset();
                session_write_close();

                //$state = "N";
                return FALSE;
            }
            else
            {
                // Cookies information complete, test name and serial.

                $where = array(
                    array(
                        "field" => "name",
                        "value" => $_COOKIE["name"],
                        "operator" => "=",
                        "condition" => "AND",
                    ),
                    array(
                        "field" => "serial",
                        "value" => $_COOKIE["serial"],
                        "operator" => "=",
                        "condition" => "",
                    ),
                );
                $user = $user_model->where($where)->select()["record"];

                if (empty($user))
                {
                    // Cookies name and serial wrong, return.

                    setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                    session_unset();
                    session_write_close();

                    //$state = "N";
                    return FALSE;
                }
                else
                {
                    // Cookies name and serial OK, test name, serial, stamp.

                    $where = array(
                        array(
                            "field" => "name",
                            "value" => $_COOKIE["name"],
                            "operator" => "=",
                            "condition" => "AND",
                        ),
                        array(
                            "field" => "serial",
                            "value" => $_COOKIE["serial"],
                            "operator" => "=",
                            "condition" => "AND",
                        ),
                        array(
                            "field" => "stamp",
                            "value" => $_COOKIE["stamp"],
                            "operator" => "=",
                            "condition" => "",
                        ),
                    );
                    $user = $user_model->where($where)->select()["record"];

                    if (empty($user))
                    {
                        // Stamp wrong, steal cookies, return.

                        setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                        session_unset();
                        session_write_close();

                        //$state = "STAMP_STEAL";
                        return FALSE;
                    }
                    else
                    {
                        // Cookies information right, update database and cookies, return.

                        $stamp = bin2hex(openssl_random_pseudo_bytes(32));
                        $where = array(
                            array(
                                "field" => "name",
                                "value" => $_COOKIE["name"],
                                "operator" => "=",
                                "condition" => "",
                            ),
                        );
                        $user = $user_model->where($where)->select_first()["record"];

                        $user_update = $user_model->update_by_id((int) $user["id"], array("stamp" => $stamp));

                        setcookie("name", $_COOKIE["name"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("serial", $user["serial"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("stamp", $stamp, time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);

                        session_regenerate_id();

                        $current_time = time();
                        $data_user = array(
                            "session_time_stamp" => $current_time,
                            "last_session_id" => session_id()
                        );

                        $user_update = $user_model->update_by_id((int) $user["id"], $data_user);
                        $_SESSION["login_time"] = $current_time;
                        $_SESSION["name"] = $_COOKIE["name"];

                        session_write_close();

                        //$state = "Y";
                        return TRUE;
                    }
                }
            }
        }
        else
        {
            // Has session information, test whether is old session.

            $where = array(
                array(
                    "field" => "name",
                    "value" => $_SESSION["name"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $user = $user_model->where($where)->select_first()["record"];

            if (
                (session_id() != $user["last_session_id"] &&
                ((time() - $_SESSION["login_time"]) > \swdf::$app->config["session_old_last_time"]))
            )
            {
                // Old session data access, remove cookies, return.

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

                session_unset();
                session_write_close();

                //$state = "N";
                return FALSE;
            }
            else
            {
                // Normal session information, test whether need regenerate.

                if ((time() - $user["session_time_stamp"]) > \swdf::$app->config["session_regenerate_time"])
                {
                    // Regenerate session id.

                    session_regenerate_id();

                    $current_time = time();
                    $data_user = array(
                        "session_time_stamp" => $current_time,
                        "last_session_id" => session_id()
                    );

                    $user_update = $user_model->update_by_id((int) $user["id"], $data_user);
                }
                else
                {
                    // No need regenerate session id, return.

                }

                session_write_close();
                //$state = "Y";

                return TRUE;
            }
        }
    }
}
?>
