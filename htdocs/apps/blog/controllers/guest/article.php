<?php
namespace blog\controllers\guest;

use swdf\base\controller;
use blog\filters\init;
use blog\filters\side_data;
use blog\models\article as article_model;
use blog\models\category;
use blog\models\tag;
use blog\models\comment;
use blog\models\article_tag;


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
                "class" => side_data::class,
                "actions" => array(),
                "rule" => array(
                    "true" => TRUE,
                    "false" => TRUE,
                )
            ),
        );
    }


    public function list_all()
    {
        $article = new article_model();

        return array(
            "guest/article/list_all",
            array(
                "articles" => $article->find_all(),
            )
        );
    }


    /**
     * Function slug_list_category.
     */
    public function slug_list_by_category()
    {
        $category = new category();

        if ($category->get_is_full_slug(\swdf::$app->request["get"]["full_category_slug"]) === FALSE)
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $category->get_by_full_slug(\swdf::$app->request["get"]["full_category_slug"]);
            $articles = $category->get_articles();

            return array(
                "guest/article/slug_list_by_category",
                array(
                    "category" => $category,
                    "articles" => $articles,
                )
            );
        }
    }


    /*
     * Function slug_list_tag.
     */
    public function slug_list_by_tag()
    {
        $tag = new tag();

        if ($tag->get_is_slug(\swdf::$app->request["get"]["tag_slug"]) === FALSE)
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $tag->get_by_slug(\swdf::$app->request["get"]["tag_slug"]);
            $articles = $tag->get_articles();

            return array(
                "guest/article/slug_list_by_tag",
                array(
                    "tag" => $tag,
                    "articles" => $articles,
                )
            );
        }
    }


    /*
     * Function Slug show.
     */
    public function slug_show()
    {
        $article = new article_model();

        if ($article->get_is_full_slug(\swdf::$app->request["get"]["full_slug"]) === FALSE)
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $article->get_by_full_slug(\swdf::$app->request["get"]["full_slug"]);

            //$article["content"] = MarkdownExtra::defaultTransform($article["content"]);

            return array(
                "guest/article/slug_show",
                array(
                    "article" => $article,
                    "root_comments" => $article->get_root_comments(),
                )
            );
        }
    }
}
?>
