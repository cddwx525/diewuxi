<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\models\article as article_model;
use blog\models\tag;
use blog\models\category;
use blog\models\media;
use blog\models\comment;
use blog\models\article_tag;
use blog\models\file;

class article extends controller
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
        $article = new article_model();

        return array(
            "admin/article/list_all",
            array(
                "articles" => $article->find_all(),
            )
        );
    }


    /**
     *
     *
     */
    public function list_by_category()
    {
        $category = new category();

        if ($category->get_is_id(\swdf::$app->request["get"]["category_id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_id(\swdf::$app->request["get"]["category_id"]);
            $articles = $category->get_articles();

            return array(
                "admin/article/list_by_category",
                array(
                    "category" => $category,
                    "articles" => $articles,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function list_by_tag()
    {
        $tag = new tag();

        if ($tag->get_is_id(\swdf::$app->request["get"]["tag_id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_id(\swdf::$app->request["get"]["tag_id"]);
            $articles = $tag->get_articles();

            return array(
                "admin/article/list_by_tag",
                array(
                    "tag" => $tag,
                    "articles" => $articles,
                )
            );
        }
    }


    /**
     *
     *
     */
    public function list_by_file()
    {
        $file = new file();

        if ($file->get_is_id(\swdf::$app->request["get"]["file_id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $file->get_by_id(\swdf::$app->request["get"]["file_id"]);
            $articles = $file->get_articles();

            return array(
                "admin/article/list_by_file",
                array(
                    "file" => $file,
                    "articles" => $articles,
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
        $article = new article_model();

        if ($article->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/article/show",
                array(
                    "article" => $article,
                    "root_comments" => $article->get_root_comments(),
                    "form_stamp" => \swdf::$app->data["user"]->update_form_stamp()->record["form_stamp"],
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
        $category = new category();
        $tag = new tag();

        $root_categories = $category->get_root();
        $tags = $tag->find_all();

        return array(
            "admin/article/write",
            array(
                "root_categories" => $root_categories,
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
        $article = new article_model();

        $ret = $article->validate_add();

        if ($ret["result"] === FALSE)
        {
            return array(
                "admin/common/message",
                array(
                    "source" => "Add article",
                    "message" => $ret["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/article.write", ""), array(), ""),
                )
            );
        }
        else
        {
            $article->add_data();

            return array(
                "admin/article/add",
                array(
                    "article" => $article,
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
        $article = new article_model();
        $category = new category();
        $tag = new tag();

        if ($article->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["id"]);
            $root_categories = $category->get_root();
            $tags = $tag->find_all();

            return array(
                "admin/article/edit",
                array(
                    "article" => $article,
                    "root_categories" => $root_categories,
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
        $article = new article_model();

        if ($article->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = $article->validate_update();

            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Update article",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/article.edit", ""), array("id" => $article->record["id"]), ""),
                    )
                );
            }
            else
            {
                $article->update_data();

                return array(
                    "admin/article/update",
                    array(
                        "article" => $article,
                    )
                );
            }
        }
    }


    /**
     *
     *
     */
    public function delete_confirm()
    {
        $article = new article_model();

        if ($article->get_is_id(\swdf::$app->request["get"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["get"]["id"]);

            return array(
                "admin/article/delete_confirm",
                array(
                    "article" => $article,
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
        $article = new article_model();

        if ($article->get_is_id(\swdf::$app->request["post"]["id"]) === FALSE)
        {
            return array(
                "admin/common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_id(\swdf::$app->request["post"]["id"]);

            $ret = \swdf::$app->data["user"]->validate_password(\swdf::$app->request["post"]["password"]);

            if ($ret["result"] === FALSE)
            {
                return array(
                    "admin/common/message",
                    array(
                        "source" => "Delete article",
                        "message" => $ret["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/article.delete_confirm", ""), array("id" => $article->record["id"]), ""),
                    )
                );
            }
            else
            {
                $article->delete_data();

                return array(
                    "admin/article/delete",
                    array(
                        "article" => $article
                    )
                );
            }
        }
    }
}
?>
