<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\admin_base;
use blog\models\option as option_model;
use blog\models\user as user_model;

class account extends admin_base
{
    public function edit($parameters)
    {
        $table_option = new option_model();
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

        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $user = $table_user->where($where)->select_first()["record"];

        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));

        // Update form_stamp.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));

        $view_name = "admin/account/edit";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "user" => $user,
            "form_stamp" => $form_stamp,
        );
    }


    public function update($parameters)
    {
        $url = new url();
        $table_option = new option_model();
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

        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter form stamp problem.
        if (
            (! isset($parameters["post"]["form_stamp"])) ||
            ($parameters["post"]["form_stamp"] != $one_user["form_stamp"])
        )
        {
            $view_name = "admin/account/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        // Filter uncomplete problem.
        if (
            (! isset($parameters["post"]["name"])) ||
            ($parameters["post"]["name"] === "") ||
            (! isset($parameters["post"]["password"])) ||
            ($parameters["post"]["password"] === "") ||
            (! isset($parameters["post"]["confirm_password"])) ||
            ($parameters["post"]["confirm_password"] === "") ||
            (! isset($parameters["post"]["current_password"])) ||
            ($parameters["post"]["current_password"] === "")
        )
        {
            $view_name = "admin/account/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "UNCOMPLETE",
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        // Filter password input problem.
        if ($parameters["post"]["password"] != $parameters["post"]["confirm_password"])
        {
            $view_name = "admin/account/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "PASSWORD_CONFIRM_WRONG",
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong password.
        if (password_verify($parameters["post"]["current_password"], $one_user["password_hash"]) === FALSE)
        {
            $view_name = "admin/account/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "CURRENT_PASSWORD_WRONG",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Update user information.
        $data_user = array(
            "name" => $parameters["post"]["name"],
            "password_hash" => password_hash($parameters["post"]["password"], PASSWORD_DEFAULT),
            "serial" => bin2hex(openssl_random_pseudo_bytes(32)),
        );
        try
        {
            $user_update = $table_user->update_by_id((int) $one_user["id"], $data_user);
        }
        catch (\PDOException $e)
        {
            // Filter add fail.
            $view_name = "admin/account/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "USER_ADD_FAIL",
                "parameters" => $parameters,
            );
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

        session_start();
        session_unset();
        session_destroy();

        session_regenerate_id(TRUE);

        $view_name = "admin/account/update";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }
}
?>
