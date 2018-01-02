<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\login_base;
use blog\models\user as user_model;

class authentication extends login_base
{
    public function write($parameters)
    {
        $url = new url();

        //Filter config.
        if ($this->config === FALSE)
        {
            $view_name = "common/not_config";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        //Filter authentication.
        if ($this->authentication === TRUE)
        {
            $view_name = "common/already_login";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        $view_name = "admin/authentication/write";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
        );
    }


    public function login($parameters)
    {
        $table_user = new user_model();

        //Filter config.
        if ($this->config === FALSE)
        {
            $view_name = "common/not_config";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        //Filter authentication.
        if ($this->authentication === TRUE)
        {
            $view_name = "common/already_login";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        $state = $this->login_verify($table_user, $parameters);
        $view_name = "admin/authentication/login";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => $state,
            "parameters" => $parameters,
        );
    }



    public function logout($parameters)
    {
        $url = new url();

        //Filter config.
        if ($this->config === FALSE)
        {
            $view_name = "common/not_config";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "Y",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Unset cookies.
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

        $state = "SUCCESS";
        $view_name = "admin/authentication/logout";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => $state,
            "parameters" => $parameters,
        );
    }


    private function login_verify($table_user, $parameters)
    {
        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["name"])) ||
            ($parameters["post"]["name"] === "") ||
            (! isset($parameters["post"]["password"])) ||
            ($parameters["post"]["password"] === "")
        )
        {
            $state =  "UNCOMPLETE";
            return $state;
        }
        else
        {
        }

        $where = array(
            array(
                "field" => "name",
                "value" => $parameters["post"]["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $user = $table_user->where($where)->select()["record"];

        if (empty($user))
        {
            // Fiter wrong username.
            $state = "USERNAME_WRONG";
            return $state;
        }
        else
        {
        }

        $one_user = $table_user->where($where)->select_first()["record"];

        // Fiter wrong password.
        if (password_verify($parameters["post"]["password"], $one_user["password_hash"]) === FALSE)
        {
            $state = "PASSWORD_WRONG";
            return $state;
        }
        else
        {
        }


        session_start();

        session_regenerate_id();

        session_write_close();

        $current_time = time();

        // Update user infomation.
        try
        {
            $user_update = $table_user->update_by_id((int) $one_user["id"], array("session_time_stamp" => $current_time, "last_session_id" => session_id()));
        }
        catch (\PDOException $e)
        {
            // Fiter update fail.
            $state = "USER_UPDATE_FAIL";
            return $state;
        }

        session_start();

        $_SESSION["login_time"] = $current_time;
        $_SESSION["name"] = $parameters["post"]["name"];

        session_write_close();


        // Set cookies to remember.
        if (isset($parameters["post"]["remember"]))
        {
            $stamp = bin2hex(openssl_random_pseudo_bytes(32));

            // Update user information.
            try
            {
                $user_update = $table_user->update_by_id((int) $one_user["id"], array("stamp" => $stamp));
            }
            catch (\PDOException $e)
            {
                // Fiter update fail.
                $state = "USER_UPDATE_FAIL";
                return $state;
            }

            setcookie("name", $parameters["post"]["name"], time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);
            setcookie("serial", $one_user["serial"], time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);
            setcookie("stamp", $stamp, time() + $this->meta_data["settings"]["cookies_time"], "", "", FALSE, TRUE);
        }
        else
        {
        }

        $state = "SUCCESS";

        return $state;
    }
}
?>
