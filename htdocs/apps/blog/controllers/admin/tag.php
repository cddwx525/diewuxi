<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\admin_base;
use blog\models\tag as tag_model;
use blog\models\article_tag as article_tag_model;
use blog\models\user as user_model;

class tag extends admin_base
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

        $view_name = "admin/tag/list_all";


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

        $view_name = "admin/tag/show";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
        );
    }


    public function write($parameters)
    {
        $table_tag = new tag_model();
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

        // Get tags record.
        $tags = $table_tag->select()["record"];

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

        $view_name = "admin/tag/write";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tags" => $tags,
            "form_stamp" => $form_stamp,
        );
    }


    public function add($parameters)
    {
        $table_tag = new tag_model();
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
            $view_name = "admin/tag/add";

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
            ($parameters["post"]["name"] === "")
        )
        {
            $view_name = "admin/tag/add";

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

        // Add tag.
        $data_tag = array(
            "name"          => $parameters["post"]["name"],
            "slug"          => $parameters["post"]["slug"],
            "description"   => $parameters["post"]["description"],
        );

        try
        {
            $tag_add = $table_tag->add($data_tag);
        }
        catch (\PDOException $e)
        {
            // Filter tag add fail.
            $view_name = "admin/tag/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "TAG_ADD_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/tag/add";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
            "tag_add" => $tag_add,
        );
    }


    public function edit($parameters)
    {
        $url = new url();
        $table_tag = new tag_model();
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

        // Get tags record.
        $tags = $table_tag->select()["record"];

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

        $view_name = "admin/tag/edit";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
            "tags" => $tags,
            "form_stamp" => $form_stamp,
        );
    }


    public function update($parameters)
    {
        $url = new url();
        $table_tag = new tag_model();
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

        // Filter wrong tag id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_tag->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/tag/update";

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
            $view_name = "admin/tag/update";

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
            ($parameters["post"]["name"] === "")
        )
        {
            $view_name = "admin/tag/update";

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

        // Update tag.
        $data_tag = array(
            "name"          => $parameters["post"]["name"],
            "slug"          => $parameters["post"]["slug"],
            "description"   => $parameters["post"]["description"],
        );

        try
        {
            $tag_update = $table_tag->update_by_id((int) $parameters["post"]["id"], $data_tag);
        }
        catch (\PDOException $e)
        {
            // Filter tag update fail.
            $view_name = "admin/tag/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "TAG_UPDATE_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/tag/update";

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

        // Add article count data to tag.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $tag["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $tag["article_count"] = $table_article_tag->where($where)->select_count()["record"];

        $view_name = "admin/tag/delete_confirm";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "tag" => $tag,
        );
    }


    public function delete($parameters)
    {
        $url = new url();
        $table_tag = new tag_model();
        $table_article_tag = new article_tag_model();
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

        // Filter wrong tag id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_tag->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/tag/delete";

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
            $view_name = "admin/tag/delete";

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

        // Get article count.
        $where = array(
            array(
                "field" => "tag_id",
                "value" => (int) $parameters["post"]["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $article_count = $table_article_tag->where($where)->select_count()["record"];


        // Filter tag delte deny.
        if ($article_count != 0)
        {
            $view_name = "admin/tag/delete";

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

        // Delete tag.
        try
        {
            $tag_delete = $table_tag->delete_by_id((int) $parameters["post"]["id"]);
        }
        catch (\PDOException $e)
        {
            // Filter tag delete fail.
            $view_name = "admin/tag/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "TAG_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        $view_name = "admin/tag/delete";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }
}
?>
