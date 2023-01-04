<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\article;
use blog\models\tag;
use blog\models\category as category_model;


class category extends controller
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
                    "true" => TRUE,
                    "false" => array(
                        "common/not_config",
                        array()
                    )
                ),
            ),
            array(
                "class" => user_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => array(
                        "common/not_login",
                        array()
                    )
                )
            ),
        );
    }


    /**
     *
     *
     */
    public function list_all()
    {
        $category = new category_model();

        $categories = $category->find_all();
        $root_categories = $category->get_root();

        return array(
            $view_name = "admin/category/list_all",
            array(
                "categories" => $categories,
                "root_categories" => $root_categories,
            )
        );
    }


    /**
     *
     *
     */
    public function show()
    {
        $category = new category_model();

        if ($category->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id((int) \swdf::$app->request["get"]["id"]);

            return array(
                "admin/category/show",
                array(
                    "category" => $category,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function write()
    {
        $category = new category_model();

        return array(
            "admin/category/write",
            array(
                "root_categories" => $category->get_root(),
                "form_stamp" => \swdf::$app->data["user"]->update_form_stamp()->record["form_stamp"],
            )
        );
    }


    /**
     *
     *
     */
    public function add()
    {
        $category = new category_model();

        $ret = $category->validate_add();
        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Add category",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/category.write", ""), array(), ""),
                )
            );
        }
        else
        {
            $category->add_data();

            return array(
                "admin/category/add",
                array(
                    "category" => $category,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function edit()
    {
        $category = new category_model();

        if ($category->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id(\swdf::$app->request["get"]["id"]);
            $root_categories = $category->get_root();

            return array(
                "admin/category/edit",
                array(
                    "category" => $category,
                    "root_categories" => $root_categories,
                    "form_stamp" => \swdf::$app->data["user"]->update_form_stamp()->record["form_stamp"],
                )
            );
        }
    }


    /**
     *
     *
     */
    public function update()
    {
        $category = new category_model();

        if ($category->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $category->validate_update();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Update category",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/category.edit", ""), array("id" => $category->record["id"]), ""),
                    )
                );
            }
            else
            {
                $category->update_data();

                return array(
                    "admin/category/update",
                    array(
                        "category" => $category,
                    )
                );
            }
        }
    }


    /*
     *
     *
     */
    public function delete_confirm()
    {
        $category = new category_model();

        if ($category->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/category/delete_confirm",
                array(
                    "category" => $category,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function delete()
    {
        $category = new category_model();

        if ($category->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $category->validate_delete();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Delete category",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/category.delete_confirm", ""), array("id" => $category->record["id"]), ""),
                    )
                );
            }
            else
            {

                $category->delete_data();

                return array(
                    "admin/category/delete",
                    array(
                        "category" => $category
                    )
                );
            }
        }
    }
}
?>
