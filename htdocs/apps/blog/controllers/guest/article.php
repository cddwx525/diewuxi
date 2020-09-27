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
use blog\lib\Michelf\MarkdownExtra;


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
        $article_model = new article_model();

        $articles = $article_model->get_articles();

        return array(
            "guest/article/list_all",
            array(
                "articles" => $articles,
            )
        );
    }


    /**
     * Function slug_list_category.
     */
    public function slug_list_category()
    {
        $category_model = new category();

        $full_category_slug = \swdf::$app->request["get"]["full_category_slug"];

        if ($category_model->get_is_full_slug($full_category_slug) === TRUE)
        {
            $category = $category_model->get_by_full_slug($full_category_slug);
            $articles = $category_model->get_articles($category);


            return array(
                "guest/article/list_category",
                array(
                    "category" => $category,
                    "articles" => $articles,
                )
            );
        }
        else
        {
            return array(
                "common/not_found",
                array()
            );
        }
    }


    /*
     * Function slug_list_tag.
     */
    public function slug_list_tag()
    {
        $tag_model = new tag();

        $tag_slug = \swdf::$app->request["get"]["tag_slug"];

        if ($tag_model->get_is_slug($tag_slug) === FALSE)
        {
            return array(
                "common/not_found",
                array()
            );
        }
        else
        {
            $tag = $tag_model->get_by_slug($tag_slug);
            $articles = $tag_model->get_articles($tag);

            return array(
                "guest/article/list_tag",
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
        $article_model = new article_model();

        $full_article_slug = \swdf::$app->request["get"]["full_slug"];

        if ($article_model->get_is_full_slug($full_article_slug) === TRUE)
        {
            $article = $article_model->get_by_full_slug($full_article_slug);

            // Convert markdown to html.
            $article["content"] = MarkdownExtra::defaultTransform($article["content"]);

            return array(
                "guest/article/show",
                array(
                    "article" => $article,
                )
            );
        }
        else
        {
            return array(
                "common/not_found",
                array()
            );
        }
    }
}
?>
