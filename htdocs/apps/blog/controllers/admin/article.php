<?php
namespace blog\controllers\admin;

use swdf\helpers\url;
use swdf\base\controller;
use blog\filters\init;
use blog\filters\user_data;
use blog\lib\Michelf\MarkdownExtra;
use blog\models\article as article_model;
use blog\models\tag;
use blog\models\category;
use blog\models\media;
use blog\models\comment;
use blog\models\article_tag;
use blog\models\user;

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
        $article_model = new article_model();

        $articles = $article_model->get_articles();

        return array(
            "admin/article/list_all",
            array(
                "articles" => $articles,
            )
        );
    }


    /**
     *
     *
     */
    public function list_category()
    {
        $category_model = new category();

        if (! $category_model->get_is_id(\swdf::$app->request["get"]["category_id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $category = $category_model->get_by_id(\swdf::$app->request["get"]["category_id"]);
            $articles = $category_model->get_articles($category);

            return array(
                "admin/article/list_category",
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
    public function list_tag()
    {
        $tag_model = new tag();

        if (! $tag_model->get_is_id(\swdf::$app->request["get"]["tag_id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $tag = $tag_model->get_by_id(\swdf::$app->request["get"]["tag_id"]);
            $articles = $tag_model->get_articles($tag);

            return array(
                "admin/article/list_tag",
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
    public function show()
    {
        $article_model = new article_model();
        $user_model = new user();

        if (! $article_model->get_is_id(\swdf::$app->request["get"]["id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id(\swdf::$app->request["get"]["id"]);
            $article["content"] = MarkdownExtra::defaultTransform($article["content"]);

            $form_stamp = $user_model->generate_form_stamp(\swdf::$app->data["user"]);

            return array(
                "admin/article/show",
                array(
                    "article" => $article,
                    "form_stamp" => $form_stamp,
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
        $category_model = new category();
        $tag_model = new tag();
        $user_model = new user();

        $category_tree = $category_model->get_tree();
        $tags = $tag_model->get_tags();

        $form_stamp = $user_model->generate_form_stamp(\swdf::$app->data["user"]);

        return array(
            "admin/article/write",
            array(
                "category_tree" => $category_tree,
                "tags" => $tags,
                "form_stamp" => $form_stamp,
            )
        );
    }


    /**
     *
     *
     */
    public function add()
    {
        $article_model = new article_model();

        $validate = $article_model->validate(\swdf::$app->request["post"], \swdf::$app->data["user"]);

        if (! $validate["result"])
        {
            return array(
                "common/message",
                array(
                    "source" => "Add article",
                    "message" => $validate["message"],
                    "back_url" => url::get(array(\swdf::$app->name, "admin/article.write", ""), array(), ""),
                )
            );
        }
        else
        {
            $article_add = $article_model->add_data(\swdf::$app->request["post"]);

            return array(
                "admin/article/add",
                array(
                    "article_add" => $article_add,
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
        $article_model = new article_model();
        $category_model = new category();
        $tag_model = new tag();
        $user_model = new user();

        if (! $article_model->get_is_id(\swdf::$app->request["get"]["id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id((int) \swdf::$app->request["get"]["id"]);
            $category_tree = $category_model->get_tree();
            $tags = $tag_model->get_tags();

            $form_stamp = $user_model->generate_form_stamp(\swdf::$app->data["user"]);


            return array(
                "admin/article/edit",
                array(
                    "article" => $article,
                    "category_tree" => $category_tree,
                    "tags" => $tags,
                    "form_stamp" => $form_stamp,
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
        $article_model = new article_model();

        if (! $article_model->get_is_id(\swdf::$app->request["post"]["id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id(\swdf::$app->request["post"]["id"]);

            $validate = $article_model->validate(\swdf::$app->request["post"], \swdf::$app->data["user"]);

            if (! $validate["result"])
            {
                return array(
                    "common/message",
                    array(
                        "source" => "Update article",
                        "message" => $validate["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/article.edit", ""), array("id" => \swdf::$app->request["post"]["id"]), ""),
                    )
                );
            }
            else
            {
                $article_update = $article_model->update_data(\swdf::$app->request["post"]);

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
        $article_model = new article_model();

        if (! $article_model->get_is_id(\swdf::$app->request["get"]["id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id(\swdf::$app->request["get"]["id"]);

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
        $article_model = new article_model();

        if (! $article_model->get_is_id(\swdf::$app->request["post"]["id"]))
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article = $article_model->get_by_id(\swdf::$app->request["post"]["id"]);

            $validate = $article_model->validate_password(\swdf::$app->request["post"], \swdf::$app->data["user"]);

            if (! $validate["result"])
            {
                return array(
                    "common/message",
                    array(
                        "source" => "Delete article",
                        "message" => $validate["message"],
                        "back_url" => url::get(array(\swdf::$app->name, "admin/article.delete_confirm", ""), array("id" => $article["id"]), ""),
                    )
                );
            }
            else
            {
                $article_delete = $article_model->delete_data(\swdf::$app->request["post"]);

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
