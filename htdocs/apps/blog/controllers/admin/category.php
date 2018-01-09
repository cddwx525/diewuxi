<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\admin_base;
use blog\models\article as article_model;
use blog\models\category as category_model;
use blog\models\user as user_model;

class category extends admin_base
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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
        $categories = $table_category->select()["record"];

        // Add other data to categories.
        foreach ($categories as $key => $category)
        {
            // Add parent data.
            if (is_null($category["parent_id"]))
            {
                $category["parent"] = NULL;
            }
            else
            {
                $category["parent"] = $table_category->select_by_id((int) $category["parent_id"])["record"];
            }

            // Add article count data.
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
        }

        // Get categories tree structure.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $category_sturcture = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        $view_name = "admin/category/list_all";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "categories" => $categories,
            "category_sturcture" => $category_sturcture,
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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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


        $view_name = "admin/category/show";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
        );
    }


    public function write($parameters)
    {
        $table_article = new article_model();
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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

        // Get categories.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        // Generate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        session_start(["read_and_close" => TRUE,]);

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));


        $view_name = "admin/category/write";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "categories" => $categories,
            "form_stamp" => $form_stamp,
        );
    }


    /*
     * Add
     */
    public function add($parameters)
    {
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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

        // Get user.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong form stamp.
        if (
            (! isset($parameters["post"]["form_stamp"])) ||
            ($parameters["post"]["form_stamp"] != $one_user["form_stamp"])
        )
        {
            $view_name = "admin/category/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["name"])) ||
            ($parameters["post"]["name"] === "") ||
            (! isset($parameters["post"]["slug"])) ||
            ($parameters["post"]["slug"] === "") ||
            (! isset($parameters["post"]["parent"])) ||
            ($parameters["post"]["parent"] === "")
        )
        {
            $view_name = "admin/category/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "UNCOMPLETE",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get category parent id.
        if ($parameters["post"]["parent"] === "NULL")
        {
            $parent_id = NULL;
        }
        else
        {
            // Get parent category.
            $where = array(
                array(
                    "field" => "name",
                    "value" => $parameters["post"]["parent"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $parent_category = $table_category->where($where)->select_first()["record"];

            // Filter non exist category name.
            if ($parent_category === FALSE)
            {
                $view_name = "admin/category/add";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => "PARENT_CATEGORY_NOT_EXIST",
                    "parameters" => $parameters,
                );
            }
            else
            {
            }

            $parent_id = (int) $parent_category["id"];
        }


        // Add category.
        $data_category = array(
            "name"          => $parameters["post"]["name"],
            "slug"          => $parameters["post"]["slug"],
            "description"   => $parameters["post"]["description"],
            "parent_id"     => $parent_id,
        );

        try
        {
            $category_add = $table_category->add($data_category);
        }
        catch (\PDOException $e)
        {
            // Filter category add fail.
            $view_name = "admin/category/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "CATEGORY_ADD_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/category/add";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
            "category_add" => $category_add,
        );
    }


    public function edit($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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

        // Get categories tree.
        $where = array(
            array(
                "field" => "parent_id",
                "operator" => "IS NULL",
                "condition" => "",
            ),
        );
        $categories = $this->category_hierarchy($table_category->where($where)->select()["record"], $table_category, $table_article);

        // Get category record.
        $category = $table_category->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add parent to category.
        if ($category["parent_id"] === NULL)
        {
            $category["parent"] = "NULL";
        }
        else
        {
            $parent_category = $table_category->select_by_id((int) $category["parent_id"])["record"];
            $category["parent"] = $parent_category["name"];
        }

        // Generate form stamp
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));
        session_start(["read_and_close" => TRUE,]);

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));

        $view_name = "admin/category/edit";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
            "categories" => $categories,
            "form_stamp" => $form_stamp,
        );
    }


    public function update($parameters)
    {
        $table_category = new category_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_category->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/category/update";

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

        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong form stamp.
        if (
            (! isset($parameters["post"]["form_stamp"])) ||
            ($parameters["post"]["form_stamp"] != $one_user["form_stamp"])
        )
        {
            $view_name = "admin/category/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "XSRF",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter uncomplete.
        if (
            (! isset($parameters["post"]["name"])) ||
            ($parameters["post"]["name"] === "") ||
            (! isset($parameters["post"]["slug"])) ||
            ($parameters["post"]["slug"] === "") ||
            (! isset($parameters["post"]["parent"])) ||
            ($parameters["post"]["parent"] === "")
        )
        {
            $view_name = "admin/category/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "UNCOMPLETE",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get category parent id.
        if ($parameters["post"]["parent"] === "NULL")
        {
            $parent_id = NULL;
        }
        else
        {
            // Get parent category.
            $where = array(
                array(
                    "field" => "name",
                    "value" => $parameters["post"]["parent"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $parent_category = $table_category->where($where)->select_first()["record"];

            // Filter non exist category name.
            if ($parent_category === FALSE)
            {
                $view_name = "admin/category/update";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => "PARENT_CATEGORY_NOT_EXIST",
                    "parameters" => $parameters,
                );
            }
            else
            {
            }

            $parent_id = (int) $parent_category["id"];
        }

        // Update category.
        $data_category = array(
            "name"          => $parameters["post"]["name"],
            "slug"          => $parameters["post"]["slug"],
            "description"   => $parameters["post"]["description"],
            "parent_id"     => $parent_id,
        );

        try
        {
            $category_update = $table_category->update_by_id((int) $parameters["post"]["id"], $data_category);
        }
        catch (\PDOException $e)
        {
            // Filter category update fail.
            $view_name = "admin/category/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "CATEGORY_UPDATE_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/category/update";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }


    public function delete_confirm($parameters)
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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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

        // Get category record.
        $category = $table_category->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add article count data to category.
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

        $view_name = "admin/category/delete_confirm";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "category" => $category,
        );
    }


    public function delete($parameters)
    {
        $url = new url();
        $table_category = new category_model();
        $table_article = new article_model();
        $table_user = new user_model();

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

        //Filter authentication.
        if ($this->authentication === FALSE)
        {
            $view_name = "common/not_login";

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
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_category->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/category/update";

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


        // Get user record.
        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $one_user = $table_user->where($where)->select_first()["record"];

        // Filter wrong password.
        if (password_verify($parameters["post"]["password"], $one_user["password_hash"]) === FALSE)
        {
            $view_name = "admin/category/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "PASSWORD_WRONG",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get subcategory count.
        $where = array(
            array(
                "field" => "parent_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $subcategory_count = $table_category->where($where)->select_count()["record"];

        // Get article count.
        $where = array(
            array(
                "field" => "category_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_count = $table_article->where($where)->select_count()["record"];

        // Filter delete deny fail.
        if (($subcategory_count != 0) || ($article_count != 0))
        {
            $view_name = "admin/category/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "DELETE_DENY",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Delete category.
        try
        {
            $category_delete = $table_category->delete_by_id((int) $parameters["post"]["id"]);
        }
        catch (\PDOException $e)
        {
            // Filter category delete fail..
            $view_name = "admin/category/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/category/delete";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
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
