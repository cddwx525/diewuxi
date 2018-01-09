<?php
namespace blog\lib\controllers;

use blog\lib\controllers\base;
use blog\models\option;
use blog\models\category;
use blog\models\article;
use blog\models\tag;
use blog\models\article_tag;

class guest_base extends base
{
    public function init()
    {
        $this->set_meta_data();
    }

    public function set_meta_data()
    {
        $table_category = new category();
        $table_article = new article();
        $table_tag = new tag();
        $table_article_tag = new article_tag();

        // Get categories tree.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);


        // Get tags record.
        $tags = $table_tag->select()["record"];

        // Add article count to tags.
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
            $tag["article_count"] = $table_article_tag->where($where)->select_count()["record"];

            $tags[$key] = $tag;
        }

        $this->meta_data["categories"] = $categories;
        $this->meta_data["tags"] = $tags;
    }


    public function get_full_category_slug($category, $table_category)
    {
        $slug_list = array();
        $slug_list[] = $category["slug"];

        while ($category["parent_id"] != NULL)
        {
            $category = $table_category->select_by_id((int) $category["parent_id"])["record"];

            $slug_list[] = $category["slug"];
        }

        krsort($slug_list, SORT_NUMERIC);

        return implode("/", $slug_list) . "/";
    }


    public function get_full_category_list($category, $table_category)
    {
        $category_list = array();

        $category["full_slug"] = $this->get_full_category_slug($category, $table_category);
        $category_list[] = $category;

        while ($category["parent_id"] != NULL)
        {
            $category = $table_category->select_by_id((int) $category["parent_id"])["record"];
            $category["full_slug"] = $this->get_full_category_slug($category, $table_category);

            $category_list[] = $category;
        }

        krsort($category_list, SORT_NUMERIC);

        return $category_list;
    }


    public function get_full_article_slug($article, $table_article, $table_category)
    {
        $slug_list = array();
        $slug_list[] = $article["slug"];

        $category = $table_category->select_by_id((int) $article["category_id"])["record"];

        $slug_list[] = $category["slug"];

        while ($category["parent_id"] != NULL)
        {
            $category = $table_category->select_by_id((int) $category["parent_id"])["record"];

            $slug_list[] = $category["slug"];
        }

        krsort($slug_list, SORT_NUMERIC);

        return implode("/", $slug_list);
    }


    public function verify_full_category_slug($full_category_slug, $table_category)
    {
        $full_category_slug_list = array_slice(explode("/", $full_category_slug), 0, -1);
        //print_r($full_category_slug_list);

        // Filter wrong category slug.
        foreach ($full_category_slug_list as $key => $value)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $value,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $category = $table_category->where($where)->select_first()["record"];

            // Filter not exist category.
            if (
                ($category === FALSE)
            )
            {
                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => "common/not_found",
                    "parameters" => $this->parameters,
                    "state" => "CATEGORY_NOT_EXIST",
                );
            }
            else
            {
            }

            // Filter not root category.
            if (
                ($key === 0) 
            )
            {
                if (
                    ($category["parent_id"] != NULL)
                )
                {
                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => "common/not_found",
                        "parameters" => $this->parameters,
                        "state" => "CATEGORY_NOT_EXIST",
                    );
                }
                else
                {
                }
            }
            else
            {
                $parent_category = $table_category->select_by_id((int) $category["parent_id"])["record"];

                // Filter not son category of previous.
                if (
                    ($parent_category === FALSE) ||
                    ($parent_category["slug"] != $full_category_slug_list[$key - 1])
                )
                {
                    $view_name = "common/not_found";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "parameters" => $this->parameters,
                        "state" => "NOT_SON_OF_PREVIOUS",
                    );
                }
                else
                {
                }
            }
        }

        $where = array(
            array(
                "field" => "slug",
                "value" => array_slice($full_category_slug_list, -1)[0],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category = $table_category->where($where)->select_first()["record"];

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => "",
            "parameters" => $this->parameters,
            "state" => "Y",
            "category" => $category,
        );
    }


    public function verify_full_article_slug($full_article_slug, $table_article, $table_category)
    {
        $full_article_slug_list = explode("/", $full_article_slug);
        $full_category_slug_list = array_slice(explode("/", $full_article_slug), 0, -1);
        //print_r($full_category_slug_list);

        // Filter wrong category slug.
        foreach ($full_category_slug_list as $key => $value)
        {
            $where = array(
                array(
                    "field" => "slug",
                    "value" => $value,
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $category = $table_category->where($where)->select_first()["record"];

            // Filter not exist category.
            if (
                ($category === FALSE)
            )
            {
                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => "common/not_found",
                    "parameters" => $this->parameters,
                    "state" => "CATEGORY_NOT_EXIST",
                );
            }
            else
            {
            }

            // Filter not root category.
            if (
                ($key === 0) 
            )
            {
                if (
                    ($category["parent_id"] != NULL)
                )
                {
                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => "common/not_found",
                        "parameters" => $this->parameters,
                        "state" => "CATEGORY_NOT_EXIST",
                    );
                }
                else
                {
                }
            }
            else
            {
                $parent_category = $table_category->select_by_id((int) $category["parent_id"])["record"];

                // Filter not son category of previous.
                if (
                    ($parent_category === FALSE) ||
                    ($parent_category["slug"] != $full_category_slug_list[$key - 1])
                )
                {
                    $view_name = "common/not_found";

                    return array(
                        "meta_data" => $this->meta_data,
                        "view_name" => $view_name,
                        "parameters" => $this->parameters,
                        "state" => "NOT_SON_OF_PREVIOUS",
                    );
                }
                else
                {
                }
            }
        }

        $where = array(
            array(
                "field" => "slug",
                "value" => array_slice($full_category_slug_list, -1)[0],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $category = $table_category->where($where)->select_first()["record"];

        $where = array(
            array(
                "field" => "slug",
                "value" => array_slice($full_article_slug_list, -1)[0],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article = $table_article->where($where)->select_first()["record"];

        // Filter wrong article.
        if (
            ($article === FALSE) ||
            ($article["category_id"] != $category["id"])
        )
        {
            $view_name = "common/not_found";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "parameters" => $this->parameters,
                "state" => "ARTICLE_WRONG",
            );
        
        }
        else
        {
        }

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => "",
            "parameters" => $this->parameters,
            "state" => "Y",
            "article" => $article,
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
            $category["full_slug"] = $this->get_full_category_slug($category, $table_category);

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
