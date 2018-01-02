<?php
namespace blog\controllers\guest;

use blog\lib\url;
use blog\lib\controllers\guest_base;
use blog\models\article as article_model;
use blog\models\category as category_model;

class category extends guest_base
{
    public function list_all($parameters)
    {
        $table_category = new category_model();
        $table_article = new article_model();

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

        // Get categories record.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        $view_name = "guest/category/list_all";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "categories" => $categories,
        );
    }


    public function show($parameters)
    {
        $url = new url();
        $table_category = new category_model();
        $table_article = new article_model();

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

        // Filter wrong category id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_category->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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
        $category = $table_category->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add article_count data to category.
        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category["article_count"] = $table_article->where($where)->select_count()["record"];

        // Add son categories data to category.
        $where = array(
            array(
                "field" => "parent_id",
                "value" => (int) $category["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category["son"] = $table_category->where($where)->select()["record"];


        $view_name = "guest/category/show";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
        );
    }


    private function category_hierarchy($categories, $table_category, $table_article)
    {
        foreach ($categories as $key => $category)
        {
            // Add article count data to categories.
            $where = array(
                array(
                    "field" => "category_id",
                    "value" => (int) $category["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $category["article_count"] = $table_article->where($where)->select_count()["record"];

            $categories[$key] = $category;

            // Get sub categories.
            $where = array(
                array(
                    "field" => "parent_id",
                    "value" => (int) $category["id"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $subcategories = $table_category->where($where)->select()["record"];

            if (! empty($subcategories))
            {
                $categories[$key]["son"] = $this->category_hierarchy($subcategories, $table_category, $table_article);
            }
            else
            {
            }
        }

        return $categories;
    }
}
?>
