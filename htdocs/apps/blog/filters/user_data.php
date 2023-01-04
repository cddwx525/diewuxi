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
        $user = new user();
        \swdf::$app->data["user"] = $user;

        if ($this->get_is_login())
        {
            $user->get_by_name($_SESSION["name"]);

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

                if (empty(\swdf::$app->data["user"]->where($where)->select()["record"]))
                {
                    // Cookies name and serial wrong, return.

                    setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                    session_unset();
                    session_write_close();

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

                    if (empty(\swdf::$app->data["user"]->where($where)->select()["record"]))
                    {
                        // Stamp wrong, steal cookies, return.

                        setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                        session_unset();
                        session_write_close();

                        return FALSE;
                    }
                    else
                    {
                        // Cookies information right, update database and cookies, return.

                        $stamp = bin2hex(openssl_random_pseudo_bytes(32));

                        \swdf::$app->data["user"]->get_by_name($_COOKIE["name"]);

                        \swdf::$app->data["user"]->update_by_id((int) \swdf::$app->data["user"]->record["id"], array("stamp" => $stamp));

                        setcookie("name", $_COOKIE["name"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("serial", \swdf::$app->data["user"]->record["serial"], time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("stamp", $stamp, time() + \swdf::$app->config["cookies_time"], "", "", FALSE, TRUE);

                        session_regenerate_id();

                        $current_time = time();
                        $data_user = array(
                            "session_time_stamp" => $current_time,
                            "last_session_id" => session_id()
                        );

                        \swdf::$app->data["user"]->update_by_id((int) \swdf::$app->data["user"]->record["id"], $data_user);

                        $_SESSION["login_time"] = $current_time;
                        $_SESSION["name"] = $_COOKIE["name"];

                        session_write_close();

                        return TRUE;
                    }
                }
            }
        }
        else
        {
            // Has session information, test whether is old session.

            \swdf::$app->data["user"]->get_by_name($_SESSION["name"]);

            if (
                (session_id() !== \swdf::$app->data["user"]->record["last_session_id"] &&
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

                return FALSE;
            }
            else
            {
                // Normal session information, test whether need regenerate.

                if ((time() - \swdf::$app->data["user"]->record["session_time_stamp"]) > \swdf::$app->config["session_regenerate_time"])
                {
                    // Regenerate session id.

                    session_regenerate_id();

                    $current_time = time();
                    $data_user = array(
                        "session_time_stamp" => $current_time,
                        "last_session_id" => session_id()
                    );

                    \swdf::$app->data["user"]->update_by_id((int) \swdf::$app->data["user"]->record["id"], $data_user);
                }
                else
                {
                    // No need regenerate session id, return.

                }

                session_write_close();

                return TRUE;
            }
        }
    }
}
?>
