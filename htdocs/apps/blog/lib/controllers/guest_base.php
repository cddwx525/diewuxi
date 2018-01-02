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
