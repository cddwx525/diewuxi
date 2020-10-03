<?php
namespace blog\models;

use swdf\base\model;
use blog\models\article;
use blog\models\article_tag;

class tag extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "tag";
    }


    /**
     *
     *
     */
    public function get_tag($tag)
    {
        $tag["article_count"] = $this->get_article_count($tag);

        return $tag;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        return $this->get_tag($this->select_by_id($id)["record"]);
    }


    /**
     *
     *
     */
    public function get_by_slug($slug)
    {
        $where = array(
            array(
                "field" => "slug",
                "value" => $slug,
                "operator" => "=",
                "condition" => "",
            ),
        );
        $tag = $this->where($where)->select_first()["record"];

        return $this->get_tag($tag);
    }


    /**
     *
     *
     */
    public function get_is_slug($slug)
    {
        $where = array(
            array(
                "field" => "slug",
                "value" => $slug,
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


    /**
     *
     *
     */
    public function get_is_id($id)
    {
        if (
            (! isset($id))
        )
        {
            return FALSE;
        }
        else
        {
            if (
                ($id === "")
            )
            {
                return FALSE;
            }
            else
            {
                if (
                    ($this->select_by_id((int) $id)["record"] === FALSE)
                )
                {
                    return FALSE;
                }
                else
                {
                    return TRUE;
                }
            }
        }
    }


    /**
     * Tag array.
     *
     */
    public function get_tags()
    {
        $article_tag_model = new article_tag();

        $tags = $this->select()["record"];

        foreach ($tags as $key => $tag)
        {
            $tags[$key] = $this->get_tag($tag);
        }

        return $tags;
    }


    /**
     *
     *
     */
    public function get_articles($tag)
    {
        $article_model = new article();
        $article_tag_model = new article_tag();

        // Get article_tag_relations.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_tag_records = $article_tag_model->where($where)->select()["record"];

        // Get articles belonged to tag.
        $articles = array();
        foreach ($article_tag_records as $article_tag_record)
        {
            $article = $article_model->select_by_id((int) $article_tag_record["article_id"])["record"];
            $articles[] = $article_model->get_article($article);
        }

        return $articles;
    }


    /**
     * Get article_count.
     *
     */
    public function get_article_count($tag)
    {
        $article_tag_model = new article_tag();

        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        return $article_tag_model->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function add_data($data)
    {
        $data_tag = array(
            "name"          => $data["name"],
            "slug"          => $data["slug"],
            "description"   => $data["description"],
        );

        return $this->add($data_tag);
    }
}
?>
