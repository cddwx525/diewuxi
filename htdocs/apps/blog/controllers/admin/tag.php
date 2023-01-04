<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\article;
use blog\models\category;
use blog\models\tag as tag_model;

class tag extends controller
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
        $tag= new tag_model();

        $tags = $tag->find_all();

        return array(
            $view_name = "admin/tag/list_all",
            array(
                "tags" => $tags,
            )
        );
    }


    /**
     *
     *
     */
    public function show()
    {
        $tag= new tag_model();

        if ($tag->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/tag/show",
                array(
                    "tag" => $tag,
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
        $tag = new tag_model();

        $tags = $tag->find_all();

        return array(
            "admin/tag/write",
            array(
                "tags" => $tags,
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
        $tag = new tag_model();

        $ret = $tag->validate_add();
        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Add tag",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/tag.write", ""), array(), ""),
                )
            );
        }
        else
        {
            $tag->add_data();

            return array(
                "admin/tag/add",
                array(
                    "tag" => $tag,
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
        $tag = new tag_model();

        if ($tag->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["get"]["id"]);
            $tags = $tag->find_all();

            return array(
                "admin/tag/edit",
                array(
                    "tag" => $tag,
                    "tags" => $tags,
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
        $tag = new tag_model();

        if ($tag->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $tag->validate_update();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Update tag",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/tag.edit", ""), array("id" => $tag->record["id"]), ""),
                    )
                );
            }
            else
            {
                $tag->update_data();

                return array(
                    "admin/tag/update",
                    array(
                        "tag" => $tag,
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
        $tag = new tag_model();

        if ($tag->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/tag/delete_confirm",
                array(
                    "tag" => $tag,
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
        $tag = new tag_model();

        if ($tag->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $tag->validate_delete();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Delete tag",
                        "message" => $ret["message"],
                        "back_url" => url::get(
                            array(\swdf::$app->name, "admin/tag.delete_confirm", ""),
                            array("id" => $tag->record["id"]),
                            ""
                        ),
                    )
                );
            }
            else
            {

                $tag->delete_data();

                return array(
                    "admin/tag/delete",
                    array(
                        "tag" => $tag
                    )
                );
            }
        }
    }
}
?>
