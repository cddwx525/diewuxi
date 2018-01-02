<?php
namespace blog\controllers\admin;

use blog\lib\url;
use blog\lib\controllers\admin_base;
use blog\models\article as article_model;
use blog\models\media as media_model;
use blog\models\user as user_model;

class media extends admin_base
{
    public function list_all($parameters)
    {
        $table_article = new article_model();
        $table_media = new media_model();

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

        // Get articles.
        $medias = $table_media->order(array("`date` DESC"))->select()["record"];

        // Add relate data.
        foreach ($medias as $key => $media)
        {
            // Add article data.
            $media["article"] = $table_article->select_by_id((int) $media["article_id"])["record"];

            $medias[$key] = $media;
        }

        $view_name = "admin/media/list_all";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "medias" => $medias,
        );
    }


    public function list_article($parameters)
    {
        $table_article = new article_model();
        $table_media = new media_model();

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

        // Filter wrong article_id.
        if (
            (! isset($parameters["get"]["article_id"])) ||
            ($parameters["get"]["article_id"] === "") ||
            ($table_article->select_by_id((int) $parameters["get"]["article_id"])["record"] === FALSE)
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

        // Get article.
        $article = $table_article->select_by_id((int) $parameters["get"]["article_id"])["record"];

        // Get medias belonged to article.
        $where = array(
            array(
                "field" => "article_id",
                "value" => (int) $parameters["get"]["article_id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $medias = $table_media->where($where)->select()["record"];

        $view_name = "admin/media/list_article";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "medias" => $medias,
            "article" => $article,
        );
    }


    public function show($parameters)
    {
        $table_media = new media_model();
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

        // Filter wrong media_id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_media->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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

        // Get media record.
        $media = $table_media->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add article data.
        $media["article"] = $table_article->select_by_id((int) $media["article_id"])["record"];

        $view_name = "admin/media/show";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "media" => $media,
        );
    }


    public function write($parameters)
    {
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


        // Genrate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));

        $view_name = "admin/media/write";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "form_stamp" => $form_stamp,
        );
    }


    public function add($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_media = new media_model();
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
            $view_name = "admin/media/add";

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
            (! isset($parameters["post"]["date"])) ||
            ($parameters["post"]["date"] === "") ||
            (! isset($_FILES["file"]["name"])) ||
            ($_FILES["file"]["name"] === "") ||
            (! isset($parameters["post"]["article_id"])) ||
            ($parameters["post"]["article_id"] === "")
        )
        {
            $view_name = "admin/media/add";

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

        // Filter wrong article id.
        if (
            ($table_article->select_by_id((int) $parameters["post"]["article_id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/media/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_NOT_EXISTS",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter wrong file.
        if ($_FILES["file"]["error"] != UPLOAD_ERR_OK)
        {
            $error_code = array(
                0 => "There is no error, the file uploaded with success",
                1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
                2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3 => "The uploaded file was only partially uploaded",
                4 => "No file was uploaded",
                6 => "Missing a temporary folder"
            ); 

            $state = $error_code[$_FILES["file"]["error"]];
            $view_name = "admin/media/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => $state,
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        // Add media.
        $uploaddir = "media/" . date("Y") . "/" . date("m") . "/" . date("d");
        //$uploadfile = $uploaddir . "/" . basename($_FILES["file"]["name"]);
        $uploadfile = $uploaddir . "/" . $_FILES["file"]["name"];

        $real_uploaddir = $url->get_static_file($this->meta_data["settings"]["app_space_name"], $uploaddir);
        $real_uploadfile = $url->get_static_file($this->meta_data["settings"]["app_space_name"], $uploadfile);

        $data_media = array(
            "date"   =>$parameters["post"]["date"],
            "file"   => $uploadfile,
            "article_id"   => (int) $parameters["post"]["article_id"],
        );

        try
        {
            $media_add = $table_media->add($data_media);
        }
        catch (\PDOException $e)
        {
            // Filter mdia add fail.
            $view_name = "admin/media/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MEDIA_ADD_FAIL",
                "parameters" => $parameters,
            );
        }


        // Move file.

        // Create dir.
        if (file_exists($real_uploaddir) === FALSE)
        {
            $mk_result = mkdir($real_uploaddir, 0777, TRUE);

            // Create fail.
            if ($mk_result === FALSE)
            {
                $view_name = "admin/media/add";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => "CREATE_DIR_FAIL",
                    "parameters" => $parameters,
                );
            }
            else
            {
            }
        }
        else
        {
        }

        // Filter add file fail.
        $move_result = move_uploaded_file($_FILES["file"]["tmp_name"], $real_uploadfile);

        if ($move_result === FALSE)
        {
            try
            {
                $media_delete = $table_media->delete_by_id($media_add["last_id"]);
            }
            catch (\PDOException $e)
            {
                // Filter mdia roll back delete fail.
                $view_name = "admin/media/add";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => "MEDIAFILE_ADD_FAIL-MEDIA_ROLL_BACK_DELETE_FAIL",
                    "parameters" => $parameters,
                );
            }

            $view_name = "admin/media/add";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MEDIAFILE_ADD_FAIL",
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        $view_name = "admin/media/add";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
            "media_add" => $media_add,
        );
    }


    public function edit($parameters)
    {
        $table_article = new article_model();
        $table_media = new media_model();
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

        // Filter wrong media id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_media->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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


        // Get media record.
        $media = $table_media->select_by_id((int) $parameters["get"]["id"])["record"];

        // Generate form stamp.
        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));

        $where = array(
            array(
                "field" => "name",
                "value" => $_SESSION["name"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $table_user->where($where)->update(array("form_stamp" => $form_stamp,));


        $view_name = "admin/media/edit";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "media" => $media,
            "form_stamp" => $form_stamp,
        );
    }


    /*
     *
     */
    public function update($parameters)
    {
        $url = new url();
        $table_article = new article_model();
        $table_media = new media_model();
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

        // Filter wrong media id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_media->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
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
            $view_name = "admin/media/update";

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
            (! isset($parameters["post"]["date"])) ||
            ($parameters["post"]["article_id"] === "") ||
            (! isset($parameters["post"]["date"])) ||
            ($parameters["post"]["article_id"] === "")
        )
        {
            $view_name = "admin/media/update";

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

        // Filter wrong article id.
        if (
            ($table_article->select_by_id((int) $parameters["post"]["article_id"])["record"] === FALSE)
        )
        {
            $view_name = "admin/media/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "ARTICLE_NOT_EXISTS",
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Filter wrong file.
        if (
            ($_FILES["file"]["error"] != UPLOAD_ERR_OK) &&
            ($_FILES["file"]["error"] != UPLOAD_ERR_NO_FILE)
        )
        {
            $error_code = array(
                0 => "There is no error, the file uploaded with success",
                1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
                2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                3 => "The uploaded file was only partially uploaded",
                4 => "No file was uploaded",
                6 => "Missing a temporary folder"
            ); 

            $state = $error_code[$_FILES["file"]["error"]];
            $view_name = "admin/media/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => $state,
                "parameters" => $parameters,
            );
        }
        else
        {
        }

        // Get media record.
        $media = $table_media->select_by_id((int) $parameters["post"]["id"])["record"];

        // Update media.
        $data_media = array(
            "date"   =>$parameters["post"]["date"],
            "article_id"   => (int) $parameters["post"]["article_id"],
        );

        try
        {
            $media_update = $table_media->update_by_id((int) $parameters["post"]["id"], $data_media);
        }
        catch (\PDOException $e)
        {
            // Filter mdia update fail.
            $view_name = "admin/media/update";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MEDIA_UPDATE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Move file.
        if ($_FILES["file"]["error"] === UPLOAD_ERR_OK)
        {
            // Filter add file fail.
            $move_result = move_uploaded_file($_FILES["file"]["tmp_name"], $url->get_static_file($this->meta_data["settings"]["app_space_name"], $media["file"]));

            if ($move_result === FALSE)
            {
                $view_name = "admin/media/update";

                return array(
                    "meta_data" => $this->meta_data,
                    "view_name" => $view_name,
                    "state" => "MEDIAFILE_UPDATE_FAIL",
                    "parameters" => $parameters,
                );
            }
            else
            {
            }
        }
        else
        {
        }


        $view_name = "admin/media/update";

        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }


    public function delete_confirm($parameters)
    {
        $table_article = new article_model();
        $table_media = new media_model();

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

        // Filter wrong media id.
        if (
            (! isset($parameters["get"]["id"])) ||
            ($parameters["get"]["id"] === "") ||
            ($table_media->select_by_id((int) $parameters["get"]["id"])["record"] === FALSE)
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

        // Get media record.
        $media = $table_media->select_by_id((int) $parameters["get"]["id"])["record"];

        // Add article data.
        $media["article"] = $table_article->select_by_id((int) $media["article_id"])["record"];

        $view_name = "admin/media/delete_confirm";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "Y",
            "parameters" => $parameters,
            "media" => $media,
        );
    }


    public function delete($parameters)
    {
        $url = new url();
        $table_media = new media_model();
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

        // Filter wrong media id.
        if (
            (! isset($parameters["post"]["id"])) ||
            ($parameters["post"]["id"] === "") ||
            ($table_media->select_by_id((int) $parameters["post"]["id"])["record"] === FALSE)
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


        // Filter password uncomplete.
        if (
            (! isset($parameters["post"]["password"])) ||
            ($parameters["post"]["password"] === "")
        )
        {
            $view_name = "admin/media/delete";

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

        // Get media record.
        $media = $table_media->select_by_id((int) $parameters["post"]["id"])["record"];

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


        // Filter password wrong.
        if (password_verify($parameters["post"]["password"], $one_user["password_hash"]) === FALSE)
        {
            $view_name = "admin/media/delete";

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


        // Delete media.
        try
        {
            $media_delete = $table_media->delete_by_id((int) $parameters["post"]["id"]);
        }
        catch (\PDOException $e)
        {
            // Filter media delete fail.
            $view_name = "admin/media/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MEDIA_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }

        // Delete file.
        $delete_result = unlink($url->get_static_file($this->meta_data["settings"]["app_space_name"], $media["file"]));

        // Filter delete fail.
        if ($delete_result === FALSE)
        {
            $view_name = "admin/media/delete";

            return array(
                "meta_data" => $this->meta_data,
                "view_name" => $view_name,
                "state" => "MEDIAFILE_DELETE_FAIL",
                "parameters" => $parameters,
            );
        }
        else
        {
        }


        $view_name = "admin/media/delete";


        return array(
            "meta_data" => $this->meta_data,
            "view_name" => $view_name,
            "state" => "SUCCESS",
            "parameters" => $parameters,
        );
    }
}
?>
