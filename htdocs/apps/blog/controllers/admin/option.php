<?php
namespace blog\controllers\admin;

use blog\lib\controllers\admin_base;
use blog\models\option as option_model;
use blog\models\user as user_model;

class option extends admin_base
{
    public function edit($parameters)
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

        $form_stamp = $this->get_form_stamp();

        $view_name = "admin/option/edit";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "form_stamp" => $form_stamp,
        );
    }


    public function update($parameters)
    {
        $table_option = new option_model();

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

        // Filter wrong form stamp.
        if (
            (! isset($parameters["post"]["form_stamp"])) ||
            ($parameters["post"]["form_stamp"] != $this->meta_data["session"]["user"]["form_stamp"])
        )
        {
            $view_name = "admin/option/update";
            $state = "XSRF";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => $state,
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        /*
         * TODO: page exist check.
         */
        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["blog_name"])) ||
            ($parameters["post"]["blog_name"] === "") ||
            (! isset($parameters["post"]["home_page"])) ||
            ($parameters["post"]["home_page"] === "") ||
            (! isset($parameters["post"]["about_page"])) ||
            ($parameters["post"]["about_page"] === "")
        )
        {
            $view_name = "admin/option/update";
            $state = "UNCOMPLETE";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => $state,
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Add data.
        $data_option = array(
            array(
                "name" => "blog_name",
                "value" => $parameters["post"]["blog_name"],
            ),
            array(
                "name" => "blog_description",
                "value" => $parameters["post"]["blog_description"],
            ),
            array(
                "name" => "home_page",
                "value" => (int) $parameters["post"]["home_page"],
            ),
            array(
                "name" => "about_page",
                "value" => (int) $parameters["post"]["about_page"],
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
            try
            {
                $option_update = $table_option->where($where)->update($one_data);
            }
            catch (\PDOException $e)
            {
                // Filter option update fail.
                $view_name = "admin/option/update";
                $state = "OPTION_UPDATE_FAIL";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => $state,
                    "parameters" => $parameters,
                );
            }
        }

        $view_name = "admin/option/update";
        $state = "SUCCESS";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => $state,
            "parameters" => $parameters,
        );
    }
}
?>
