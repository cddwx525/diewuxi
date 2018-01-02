<?php
namespace blog\controllers\admin;

use blog\lib\controllers\admin_base;

class home extends admin_base
{
    public function show($parameters)
    {
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

        $view_name = "admin/home";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
        );
    }
}
?>
