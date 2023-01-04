<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\article;
use blog\models\file as file_model;
use blog\models\article_file;

class file extends controller
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
        $file = new file_model();

        $files = $file->find_all();

        return array(
            "admin/file/list_all",
            array(
                "files" => $files,
            )
        );
    }


    /**
     *
     *
     */
    public function list_by_article()
    {
        $article = new article();

        if ($article->get_is_id(\swdf::$app->request["get"]["article_id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["article_id"]);

            //print "<pre>";
            //print_r($article);
            //print "</pre>";

            $files = $article->get_files();

            return array(
                "admin/file/list_by_article",
                array(
                    "article" => $article,
                    "files" => $files,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function show()
    {
        $file = new file_model();

        if ($file->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id((int) \swdf::$app->request["get"]["id"]);

            return array(
                "admin/file/show",
                array(
                    "file" => $file,
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
        return array(
            "admin/file/write",
            array(
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
        $file = new file_model();

        $ret = $file->validate_add();
        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Add file",
                    "message" => $ret["message"],
                    "back_url" => url::get(
                        array(\swdf::$app->name, "admin/file.write", ""),
                        array(),
                        ""
                    ),
                )
            );
        }
        else
        {
            $ret = $file->add_data();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Add file",
                        "message" => $ret["message"],
                        "back_url" => url::get(
                            array(\swdf::$app->name, "admin/file.write", ""),
                            array(),
                            ""
                        ),
                    )
                );
            }
            else
            {
                return array(
                    "admin/file/add",
                    array(
                        "file" => $file,
                    )
                );
            }
        }
    }


    /**
     *
     *
     */
    public function edit()
    {
        $file = new file_model();

        if ($file->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id((int) \swdf::$app->request["get"]["id"]);

            return array(
                "admin/file/edit",
                array(
                    "file" => $file,
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
        $file = new file_model();

        if ($file->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $file->validate_update();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Update file",
                        "message" => $ret["message"],
                        "back_url" => url::get(
                            array(\swdf::$app->name, "admin/file.edit", ""),
                            array("id" => $file->record["id"]),
                            ""
                        ),
                    )
                );
            }
            else
            {
                $ret = $file->update_data();
                if ($ret["result"] === FALSE)
                {
                    return array(
                        "admin/common/message",
                        array(
                            "source" => "Update file",
                            "message" => $ret["message"],
                            "back_url" => url::get(
                                array(\swdf::$app->name, "admin/file.edit", ""),
                                array("id" => $file->record["id"]),
                                ""
                            ),
                        )
                    );
                }
                else
                {
                    return array(
                        "admin/file/update",
                        array(
                            "file" => $file,
                        )
                    );
                }
            }
        }
    }




    /**
     *
     *
     */
    public function delete_confirm()
    {
        $file = new file_model();

        if ($file->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/file/delete_confirm",
                array(
                    "file" => $file,
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
        $article_file = new article_file();
        $file = new file_model();

        if ($file->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $file->validate_delete();
            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Delete file",
                        "message" => $ret["message"],
                        "back_url" => url::get(
                            array(\swdf::$app->name, "admin/file.delete_confirm", ""),
                            array("id" => $file->record["id"]),
                            ""
                        ),
                    )
                );
            }
            else
            {
                $ret = $file->delete_data();
                if ($ret["result"] === FALSE)
                {
                    return array(
                        "admin/common/message",
                        array(
                            "source" => "Delete file",
                            "message" => $ret["message"],
                            "back_url" => url::get(
                                array(\swdf::$app->name, "admin/file.delete_confirm", ""),
                                array("id" => $file->record["id"]),
                                ""
                            ),
                        )
                    );
                }
                else
                {
                    return array(
                        "admin/file/delete",
                        array(
                            "file" => $file
                        )
                    );
                }
            }
        }

    }
}
?>
