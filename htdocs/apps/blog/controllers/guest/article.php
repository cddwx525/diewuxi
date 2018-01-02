<?php
namespace blog\controllers\guest;

use blog\lib\url;
use blog\lib\Michelf\MarkdownExtra;
use blog\lib\controllers\guest_base;
use blog\models\article as article_model;
use blog\models\category as category_model;
use blog\models\tag as tag_model;
use blog\models\comment as comment_model;
use blog\models\article_tag as article_tag_model;


class article extends guest_base
{
    public function list_all($parameters)
    {
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_article_tag = new article_tag_model();

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


        // Get articles record.
        $articles = $table_article->order(array("`date` DESC"))->select()["record"];

        // Add relate data.
        foreach ($articles as $key => $article)
        {
            // Add category data.
            $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

            // Add tags data.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations as $article_tag_relation)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            $articles[$key] = $article;
        }

        $view_name = "guest/article/list_all";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "articles" => $articles,
        );
    }


    public function list_category($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_article_tag = new article_tag_model();

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

        // Filter wrong category_id.
        if (
            (! isset($parameters["get"]["category_id"])) ||
            ($parameters["get"]["category_id"] === "") ||
            ($table_category->select_by_id((int) $parameters["get"]["category_id"])["record"] === FALSE)
        )
        {
            $view_name = "common/not_found";

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

        // Get category.
        $category = $table_category->select_by_id((int) $parameters["get"]["category_id"])["record"];

        // Get articles belonged to category.
        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $articles = $table_article->where($where)->select()["record"];

        // Add relate data to article.
        foreach ($articles as $key => $article)
        {
            // Add category.
            $article["category"] = $category;

            // Add tags.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations as $article_tag_relation)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            $articles[$key] = $article;
        }

        $view_name = "guest/article/list_category";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
            "articles" => $articles,
        );
    }

    public function list_tag($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_article_tag = new article_tag_model();

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

        // Filter wrong tag_id.
        if (
            (! isset($parameters["get"]["tag_id"])) ||
            ($parameters["get"]["tag_id"] === "") ||
            ($table_tag->select_by_id((int) $parameters["get"]["tag_id"])["record"] === FALSE)
        )
        {
            $view_name = "common/not_found";

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

        // Get tag.
        $tag = $table_tag->select_by_id((int) $parameters["get"]["tag_id"])["record"];

        // Get article_tag_relations.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];

        // Get articles belonged to tag.
        $articles = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            // Get one article.
            $article = $table_article->select_by_id((int) $article_tag_relation["article_id"])["record"];

            // Add category data.
            $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

            // Add tags data.
            $where = array(
                array(
                    "field" => "article_id",
                    "value" => (int) $article["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_tag_relations_second = $table_article_tag->where($where)->select()["record"];
            $article_tag = array();
            foreach ($article_tag_relations_second as $article_tag_relation_second)
            {
                $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation_second["tag_id"])["record"];
            }
            $article["tag"] = $article_tag;

            $articles[] = $article;
        }

        $view_name = "guest/article/list_tag";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
            "articles" => $articles,
        );
    }


    public function show($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_tag = new tag_model();
        $table_comment = new comment_model();
        $table_article_tag = new article_tag_model();

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

        // Fiter wrong article_id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "common/not_found";

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

        // Get article record.
        $article = $table_article->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add category data.
        $article["category"] = $table_category->select_by_id((int) $article["category_id"])["record"];

        // Add tags data.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_relations = $table_article_tag->where($where)->select()["record"];
        $article_tag = array();
        foreach ($article_tag_relations as $article_tag_relation)
        {
            $article_tag[] = $table_tag->select_by_id((int) $article_tag_relation["tag_id"])["record"];
        }
        $article["tag"] = $article_tag;

        // Convert markdown to html.
        $article["content"] = MarkdownExtra::defaultTransform($article["content"]);

        // Get comment count.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "target_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $comment_count = $table_comment->where($where)->select_count()["record"];

        // Get comments.
        $comments = $this->comment_hierarchy($table_comment->where($where)->order(array("`number` ASC"))->select()["record"], $table_comment);

        $view_name = "guest/article/show";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "article" => $article,
            "comment_count" => $comment_count,
            "comments" => $comments,
        );
    }


    private function comment_hierarchy($comments, $table_comment)
    {
        foreach ($comments as $key => $comment)
        {
            $where = array(
                array(
                    "field" => "target_id",
                    "value" => (int) $comment["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $subcomments = $table_comment->where($where)->order(array("`date` ASC"))->select()["record"];
            if (! empty($subcomments))
            {
                $comments[$key]["reply"] = $this->comment_hierarchy($subcomments, $table_comment);
            }
            else
            {
            }
        }
        return $comments;
    }
}
?>
