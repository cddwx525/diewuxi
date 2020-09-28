<?php
namespace blog\controllers\admin;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\models\option;
use blog\models\page;
use blog\models\user;

class config extends controller
{
    /**
     *
     *
     */
    protected function get_behaviors()
    {
        return array(
            array(
                "class" => init::class,
                "actions" => array(),
                "rule" => array(
                    "true" => array(
                        "common/already_config",
                        array()
                    ),
                    "false" => TRUE,
                ),
            ),
        );
    }


    /**
     *
     *
     */
    public function write()
    {
        return array(
            "admin/config/write",
            array()
        );
    }


    /**
     *
     *
     */
    public function save()
    {
        $option_model = new option();
        $user_model = new user();
        $page_model = new page();

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["blog_name"])) ||
            ($parameters["post"]["blog_name"] === "") ||
            (! isset($parameters["post"]["name"])) ||
            ($parameters["post"]["name"] === "") ||
            (! isset($parameters["post"]["password"])) ||
            ($parameters["post"]["password"] === "")
        )
        {
            $view_name = "admin/config/save";

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

        // Add data.
        $data_option = array(
            array(
                "name" => "flag",
                "value" => "on",
            ),
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
                "value" => "1",
            ),
            array(
                "name" => "about_page",
                "value" => "2",
            ),
        );

        foreach ($data_option as $one_data)
        {
            try
            {
                $option_add = $table_option->add($one_data);
            }
            catch (\PDOException $e)
            {
                $view_name = "admin/config/save";
                $state = "OPTION_ADD_FAIL";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => $state,
                    "parameters" => $parameters,
                );
            }
        }


        /*
         * Add page.
         */
        $data_page = array(
            array(
                "id"            => 1,
                "slug"          => "default-page-1",
                "date"          => date("Y-m-d H:i:s"),
                "content"       => "This is default page 1",
            ),
            array(
                "id"            => 2,
                "slug"          => "default-page-2",
                "date"          => date("Y-m-d H:i:s"),
                "content"       => "This is default page 2",
            ),
        );
        foreach ($data_page as $one_data)
        {
            try
            {
                $page_add = $table_page->add($one_data);
            }
            catch (\PDOException $e)
            {
                $view_name = "admin/config/save";
                $state = "PAGE_ADD_FAIL";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => $state,
                    "parameters" => $parameters,
                );
            }
        }


        /*
         * Add user.
         */
        $data_user = array(
            "name" => $parameters["post"]["name"],
            "password_hash" => password_hash($parameters["post"]["password"], PASSWORD_DEFAULT),
            "serial" => bin2hex(openssl_random_pseudo_bytes(32)),
            "stamp" => bin2hex(openssl_random_pseudo_bytes(32)),
            "session_time_stamp" => time(),
            "last_session_id" => bin2hex(openssl_random_pseudo_bytes(32)),
        );
        try
        {
            $user_add = $table_user->add($data_user);
        }
        catch (\PDOException $e)
        {
            $view_name = "admin/config/save";
            $state = "USER_ADD_FAIL";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => $state,
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/config/save";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }
}
?>
