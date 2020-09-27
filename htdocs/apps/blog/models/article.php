<?php
namespace blog\models;

use swdf\base\model;
use blog\models\category;
use blog\models\tag;
use blog\models\article_tag;
use blog\models\comment;

class article extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "article";
    }


    /**
     *
     *
     */
    public function get_article($article)
    {
        $article["full_slug"] = $this->get_full_slug($article);
        $article["category"] = $this->get_category($article);
        $article["tags"] = $this->get_tags($article);
        $article["comment_tree"] = $this->get_comment_tree($article);
        $article["comment_count"] = $this->get_comment_count($article);

        return $article;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_article($this->select_by_id($id)["record"]);
    }




    /**
     *
     *
     */
    public function get_by_full_slug($full_slug)
    {
        $category_model = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);
        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        $category = $category_model->get_by_full_slug($category_model->get_full_slug_by_data($full_category_slug_list));

        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "AND",
            ),
            array(
                "field" => "slug",
                "value" => $article_slug,
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article = $this->where($where)->select_first()["record"];

        return $this->get_article($article);
    }


    /**
     *
     *
     */
    public function get_articles()
    {
        $articles = $this->order(array("`date` DESC"))->select()["record"];

        foreach ($articles as $key => $article)
        {
            $articles[$key] = $this->get_article($article);
        }

        return $articles;
    }


    /**
     *
     *
     */
    public function get_category($article)
    {
        $category_model = new category();

        $category = $category_model->select_by_id((int) $article["category_id"])["record"];

        return $category_model->get_category($category);
    }


    /**
     *
     *
     */
    public function get_tags($article)
    {
        $tag_model = new tag();
        $article_tag_model = new article_tag();

        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $article["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_records = $article_tag_model->where($where)->select()["record"];

        $tags = array();
        foreach ($article_tag_records as $key => $article_tag_record)
        {
            $tag = $tag_model->select_by_id((int) $article_tag_record["tag_id"])["record"];
            $tags[$key] = $tag_model->get_tag($tag);
        }

        return $tags;
    }


    /**
     *
     *
     */
    public function get_full_slug($article)
    {
        $category_model = new category();

        $slug_list = array();
        $slug_list[] = $article["slug"];

        $category = $category_model->select_by_id((int) $article["category_id"])["record"];

        $slug_list[] = $category["slug"];

        while ($category["parent_id"] != NULL)
        {
            $category = $category_model->select_by_id((int) $category["parent_id"])["record"];

            $slug_list[] = $category["slug"];
        }

        krsort($slug_list, SORT_NUMERIC);

        return implode("/", $slug_list);
    }


    /**
     *
     *
     */
    public function get_full_slug_data($full_slug)
    {
        return array(
            array_slice(explode("/", $full_slug), 0, -1),
            array_slice(explode("/", $full_slug), -1)[0],
        );
    }


    /**
     *
     *
     */
    public function get_comment_tree($article)
    {
        $comment_model = new comment();

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
        $top_comments = $comment_model->where($where)->order(array("`number` ASC"))->select()["record"];

        return $comment_model->hierarchy($top_comments);
    }


    /**
     *
     *
     */
    public function get_comment_count($article)
    {
        $comment_model = new comment();

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

        return $comment_model->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_is_full_slug($full_slug)
    {
        $category_model = new category();

        $full_slug_data = $this->get_full_slug_data($full_slug);
        $full_category_slug_list = $full_slug_data[0];
        $article_slug = $full_slug_data[1];

        // Filter wrong category slug.
        if ($category_model->get_is_full_slug($category_model->get_full_slug_by_data($full_category_slug_list)) === TRUE)
        {
            $category = $category_model->get_by_full_slug($category_model->get_full_slug_by_data($full_category_slug_list));

            $where = array(
                array(
                    "field" => "category_id",
                    "value" => (int) $category["id"],
                    "operator" => "=",
                    "condition" => "AND",
                ),
                array(
                    "field" => "slug",
                    "value" => $article_slug,
                    "operator" => "=",
                    "condition" => "",
                ),
            );

            if ($this->where($where)->select_first()["record"] === FALSE)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }
        else
        {
            return FALSE;
        }
    }
}
?>
