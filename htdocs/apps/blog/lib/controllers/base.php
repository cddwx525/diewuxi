<?php
namespace blog\lib\controllers;

use blog\app_setting;
use blog\lib\url;
use blog\models\option;
use blog\models\user;

class base
{
    public $meta_data = array();
    public $config;
    public $authentication;

    public function __construct()
    {
        // In order.
        $this->set_base_meta_data();
        $this->set_state();

        $this->init();
    }


    public function set_base_meta_data()
    {
        $table_option = new option();

        $options = $table_option->select()["record"];

        foreach ($options as $one_option)
        {
            $this->meta_data["options"][$one_option["name"]] = $one_option["value"];
        }

        $this->meta_data["settings"]["app_space_name"] = app_setting::APP_SPACE_NAME;
        $this->meta_data["settings"]["app_default_name"] = app_setting::APP_DEFAULT_NAME;

        $this->meta_data["settings"]["session_regenerate_time"] = app_setting::SESSION_REGENERATE_TIME;
        $this->meta_data["settings"]["session_old_last_time"] = app_setting::SESSION_OLD_LAST_TIME;
        $this->meta_data["settings"]["cookies_time"] = app_setting::COOKIES_TIME;
        $this->meta_data["settings"]["max_file_size"] = app_setting::MAX_FILE_SIZE;

        $this->meta_data["settings"]["special_actions"] = app_setting::SPECIAL_ACTIONS;

        $main_app_setting_class_name = MAIN_APP . "\\app_setting";
        $this->meta_data["main_app"]["app_space_name"] = $main_app_setting_class_name::APP_SPACE_NAME;
        $this->meta_data["main_app"]["app_default_name"] = $main_app_setting_class_name::APP_DEFAULT_NAME;
        $this->meta_data["main_app"]["special_actions"] = $main_app_setting_class_name::SPECIAL_ACTIONS;
        $this->meta_data["main_app"]["site_name"] = $main_app_setting_class_name::SITE_NAME;

        $this->meta_data["main_app"]["site_description"] = $main_app_setting_class_name::SITE_DESCRIPTION;
        $this->meta_data["main_app"]["site_begin_year"] = $main_app_setting_class_name::SITE_BEGIN_YEAR;
    }


    public function set_state()
    {
        if (
            (isset($this->meta_data["options"]["flag"])) &&
            ($this->meta_data["options"]["flag"] === "on")
        )
        {
            $this->config = TRUE;
        }
        else
        {
            $this->config = FALSE;
        }

        $login_state = $this->get_session_state();

        if ($login_state === "Y")
        {
            $this->authentication = TRUE;
        }
        else
        {
            $this->authentication = FALSE;
        }
    }


    public function get_session_state()
    {
        $table_user = new user();

        session_start();

        if (! isset($_SESSION["name"]))
        {
            /*
             * No session information.
             */
            if (! (isset($_COOKIE["name"]) && isset($_COOKIE["serial"]) && isset($_COOKIE["stamp"])))
            {
                /*
                 * Cookies information uncomplete.
                 */
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

                $state = "N";
            }
            else
            {
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
                $user = $table_user->where($where)->select()["record"];
                if (empty($user))
                {
                    /*
                     * Cookies name and serial wrong.
                     */
                    setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                    setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                    session_unset();

                    $state = "N";
                }
                else
                {
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
                    $user = $table_user->where($where)->select()["record"];
                    if (empty($user))
                    {
                        /*
                         * Stamp wrong, steal cookies.
                         */
                        setcookie("name", $_COOKIE["name"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("serial", $_COOKIE["serial"], time() - 3600, "", "", FALSE, TRUE);
                        setcookie("stamp", $_COOKIE["stamp"], time() - 3600, "", "", FALSE, TRUE);

                        session_unset();

                        $state = "STAMP_STEAL";
                    }
                    else
                    {
                        /*
                         * Cookies information right.
                         */
                        $stamp = bin2hex(openssl_random_pseudo_bytes(32));
                        $where = array(
                            array(
                                "field" => "name",
                                "value" => $_COOKIE["name"],
                                "operator" => "=",
                                "condition" => "",
                            ),
                        );
                        $one_user = $table_user->where($where)->select_first()["record"];
                        try
                        {
                            $user_update = $table_user->update_by_id((int) $one_user["id"], array("stamp" => $stamp));
                        }
                        catch (\PDOException $e)
                        {
                            $state = "USER_UPDATE_FAIL";

                            session_write_close();

                            return $state;
                        }

                        setcookie("name", $_COOKIE["name"], time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("serial", $one_user["serial"], time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);
                        setcookie("stamp", $stamp, time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);

                        session_regenerate_id();

                        $current_time = time();
                        try
                        {
                            $user_update = $table_user->update_by_id((int) $one_user["id"], array("session_time_stamp" => $current_time, "last_session_id" => session_id()));
                        }
                        catch (\PDOException $e)
                        {
                            $state = "USER_UPDATE_FAIL";

                            session_write_close();

                            return $state;
                        }

                        $_SESSION["login_time"] = $current_time;
                        $_SESSION["name"] = $_COOKIE["name"];

                        $state = "Y";
                    }
                }
            }
        }
        else
        {
            $where = array(
                array(
                    "field" => "name",
                    "value" => $_SESSION["name"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $one_user = $table_user->where($where)->select_first()["record"];

            if (
                (session_id() != $one_user["last_session_id"] &&
                ((time() - $_SESSION["login_time"]) > $this->meta_data["settings"]["session_old_last_time"]))
            )
            {
                /*
                 * Old session data access.
                 */
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

                $state = "N";
            }
            else
            {
                if ((time() - $one_user["session_time_stamp"]) > $this->meta_data["settings"]["session_regenerate_time"])
                {
                    session_regenerate_id();

                    $current_time = time();
                    try
                    {
                        $user_update = $table_user->update_by_id((int) $one_user["id"], array("session_time_stamp" => $current_time, "last_session_id" => session_id()));
                    }
                    catch (\PDOException $e)
                    {
                        $state = "USER_UPDATE_FAIL";

                        session_write_close();

                        return $state;
                    }
                }
                else
                {
                }

                $state = "Y";
            }
        }

        session_write_close();

        return $state;
    }
}
?>
