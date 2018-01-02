<?php
namespace blog\controllers\guest;

use blog\lib\url;
use blog\lib\controllers\guest_base;
use blog\models\tag as tag_model;
use blog\models\article_tag as article_tag_model;

class tag extends guest_base
{
    public function list_all($parameters)
    {
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

        // Get tags record.
        $tags = $table_tag->select()["record"];

        // Add article count to tag.
        foreach ($tags as $key => $tag)
        {
            $where = array(
                array(
                    "field" => "tag_id",
                    "value" => (int) $tag["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $article_count = $table_article_tag->where($where)->select_count()["record"];
            $tag["article_count"] = $article_count;

            $tags[$key] = $tag;
        }

        $view_name = "guest/tag/list_all";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tags" => $tags,
        );
    }


    public function show($parameters)
    {
        $url = new url();
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

        // Filter wrong tag id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_tag->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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

        // Get tag record.
        $tag = $table_tag->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add article count to tag.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $tag["article_count"] = $table_article_tag->where($where)->select_count()["record"];

        $view_name = "guest/tag/show";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
        );
    }
}
?>
