<?php
namespace blog\models;

use swdf\base\model;
use swdf\helpers\url;
use blog\models\article;
use blog\models\article_file;

class file extends model
{
    /**
     *
     *
     */
    public function get_table_name()
    {
        return "file";
    }


    /**
     *
     *
     */
    public function find_all()
    {
        $records = $this->select()["record"];

        $files = array();
        foreach ($records as $key => $item)
        {
            $one_file = new file();
            $one_file->record = $item;
            $files[$key] = $one_file;
        }

        return $files;
    }


    /**
     *
     *
     */
    public function get_by_id($id)
    {
        $this->record = $this->select_by_id($id)["record"];

        return $this;
    }

    /**
     *
     *
     */
    public function get_articles()
    {
        $article_file = new article_file();

        $where = array(
            array(
                "field" => "file_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );
        $records = $article_file->where($where)->select()["record"];

        $articles = array();
        foreach ($records as $key => $item)
        {
            $one_article = new article();
            $one_article->record = $item;
            $articles[$key] = $one_article;
        }

        return $articles;
    }

    /**
     *
     *
     */
    public function get_article_count()
    {
        $article_file = new article_file();

        $where = array(
            array(
                "field" => "file_id",
                "value" => (int) $this->record["id"],
                "operator" => "=",
                "condition" => "",
            ),
        );

        return $article_file->where($where)->select_count()["record"];
    }


    /**
     *
     *
     */
    public function get_url()
    {
        return url::get_static("uploads/" . $this->get_path_string());
    }



    /**
     *
     *
     */
    public function get_path()
    {
        return url::get_path("uploads/" . $this->get_path_string());
    }



    /**
     *
     *
     */
    public function get_is_id($id)
    {
        if (
            (isset($id) === FALSE)
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
                    ($this->select_by_id($id)["record"] === FALSE)
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
     *
     *
     */
    public function validate_add()
    {
        $ret = $this->validate();

        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            if (\swdf::$app->file["file"]["error"] !== UPLOAD_ERR_OK)
            {
                $error_code = array(
                    0 => "There is no error, the file uploaded with success",
                    1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
                    2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
                    3 => "The uploaded file was only partially uploaded",
                    4 => "No file was uploaded",
                    6 => "Missing a temporary folder"
                ); 

                return array(
                    "result" => FALSE,
                    "message" => $error_code[\swdf::$app->file["file"]["error"]]
                );
            }
            else
            {
                return array(
                    "result" => TRUE,
                );
            }
        }
    }


    /**
     *
     *
     */
    public function add_data()
    {
        if (
            (isset(\swdf::$app->request["post"]["name"]) === FALSE) ||
            (\swdf::$app->request["post"]["name"] === "")
        )
        {
            // Name field is not set in form.
            $data_file = array(
                "date"   => \swdf::$app->request["post"]["date"],
                "name"   => \swdf::$app->file["file"]["name"],
                "host"   => "local",
                "folder" => "uploads",
            );
        }
        else
        {
            // Name field is set in form.
            $data_file = array(
                "date"   => \swdf::$app->request["post"]["date"],
                "name"   => \swdf::$app->request["post"]["name"],
                "host"   => "local",
                "folder" => "uploads",
            );
        }
        $ret = $this->add($data_file);

        $this->get_by_id($ret["last_id"]);

        $ret = $this->save_file($this->get_path());
        if ($ret["result"] === FALSE)
        {
            // Save failed, delete added record.
            $this->delete_by_id($this->record["id"]);

            return $ret;
        }
        else
        {
            // Save successfully.
            return array(
                "result" => TRUE,
            );
        }

    }




    /**
     *
     *
     */
    public function validate_update()
    {
        if (
            (isset(\swdf::$app->request["post"]["form_stamp"]) === FALSE) ||
            (\swdf::$app->request["post"]["form_stamp"] !== \swdf::$app->data["user"]->record["form_stamp"])
        )
        {
            return array(
                "result" => FALSE,
                "message" => "XSRF."
            );
        }
        else
        {
            if (
                (isset(\swdf::$app->request["post"]["date"]) === FALSE) ||
                (isset(\swdf::$app->request["post"]["name"]) === FALSE)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more field not set."
                );
            }
            else
            {
                if (
                    (\swdf::$app->request["post"]["date"] === "") ||
                    (\swdf::$app->request["post"]["name"] === "")
                )
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Form uncomplete, one or more necessary field is empty."
                    );
                }
                else
                {
                    if (
                        (\swdf::$app->file["file"]["error"] !== UPLOAD_ERR_OK) &&
                        (\swdf::$app->file["file"]["error"] !== UPLOAD_ERR_NO_FILE)
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

                        return array(
                            "result" => FALSE,
                            "message" => $error_code[\swdf::$app->file["file"]["error"]]
                        );
                    }
                    else
                    {
                        return array(
                            "result" => TRUE,
                        );
                    }
                }
            }
        }
    }



    /**
     *
     *
     */
    public function update_data()
    {
        // Save path value before update.
        $original_path = $this->get_path();
        $backup_path = $original_path . ".bak";

        $data_file = array(
            "date"   => \swdf::$app->request["post"]["date"],
            "name"   => \swdf::$app->request["post"]["name"],
            "host"   => "local",
            "folder" => "uploads",
        );
        $this->update_by_id($this->record["id"], $data_file);

        $this->get_by_id($this->record["id"]);

        if (
            (\swdf::$app->file["file"]["error"] === UPLOAD_ERR_OK)
        )
        {
            // TODO: test if file exists.
            $ret = rename($original_path, $backup_path);
            if ($ret === FALSE)
            {
                return array(
                    "result" => FALSE,
                    "message" => "Backup file failed."
                );
            }
            else
            {
                $ret = $this->save_file($this->get_path());
                if ($ret["result"] === FALSE)
                {
                    // Save failed. Recover backup file back.
                    // TODO: test if file exists.
                    rename($backup_path, $original_path);

                    return $ret;
                }
                else
                {
                    // Save successfully. Remove backup file.
                    // TODO: test if file exists.
                    $ret = unlink($backup_path);
                    if ($ret === FALSE)
                    {
                        return array(
                            "result" => FALSE,
                            "message" => "Remove backup file failed."
                        );
                    }
                    else
                    {
                        return array(
                            "result" => TRUE,
                        );
                    }
                }
            }
        }
        else
        {
            $ret = rename($original_path, $this->get_path());
            if ($ret === FALSE)
            {
                return array(
                    "result" => FALSE,
                    "message" => "Rename file failed."
                );
            }
            else
            {
                return array(
                    "result" => TRUE,
                );
            }
        }

    }


    /**
     *
     *
     */
    public function validate_delete()
    {
        $ret = \swdf::$app->data["user"]->validate_password(\swdf::$app->request["post"]["password"]);
        if ($ret["result"] === FALSE)
        {
            return $ret;
        }
        else
        {
            if (
                ((int) $this->get_article_count() !== 0)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Related to article."
                );
            }
            else
            {
                return array(
                    "result" => TRUE,
                );
            }
        }
    }


    /**
     *
     *
     */
    public function delete_data()
    {
        // TODO: test if file exists.
        $ret = unlink($this->get_path());
        if ($ret === FALSE)
        {
            return array(
                "result" => FALSE,
                "message" => "Remove file failed."
            );
        }
        else
        {
            $this->delete_by_id($this->record["id"]);

            return array(
                "result" => TRUE,
            );
        }
    }










    /**
     *
     *
     */
    private function validate()
    {
        if (
            (isset(\swdf::$app->request["post"]["form_stamp"]) === FALSE) ||
            (\swdf::$app->request["post"]["form_stamp"] !== \swdf::$app->data["user"]->record["form_stamp"])
        )
        {
            return array(
                "result" => FALSE,
                "message" => "XSRF."
            );
        }
        else
        {
            if (
                (isset(\swdf::$app->request["post"]["date"]) === FALSE)
            )
            {
                return array(
                    "result" => FALSE,
                    "message" => "Form uncomplete, one or more field not set."
                );
            }
            else
            {
                if (
                    (\swdf::$app->request["post"]["date"] === "")
                )
                {
                    return array(
                        "result" => FALSE,
                        "message" => "Form uncomplete, one or more necessary field is empty."
                    );
                }
                else
                {
                    return array(
                        "result" => TRUE,
                    );
                }
            }
        }
    }


    /**
     *
     *
     */
    private function save_file($path)
    {

        $ret = $this->create_dir($path);
        if ($ret === FALSE)
        {
            return array(
                "result" => FALSE,
                "message" => "Directory created fail."
            );
        }
        else
        {
            // TODO: test if file exists.
            $ret = move_uploaded_file(\swdf::$app->file["file"]["tmp_name"], $path);
            if ($ret === FALSE)
            {
                return array(
                    "result" => FALSE,
                    "message" => "File move fail."
                );
            }
            else
            {
                chmod($path, 0777);

                return array(
                    "result" => TRUE,
                );
            }
        }
    }


    /**
     *
     *
     */
    private function create_dir($path)
    {
        if (file_exists(dirname($path)) === FALSE)
        {
            $mk_result = mkdir(dirname($path), 0777, TRUE);

            if ($mk_result === FALSE)
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
            return TRUE;
        }
    }



    /**
     *
     *
     *
     */
    private function get_path_string()
    {
        $id_string = str_pad($this->record["id"], 12, "0", STR_PAD_LEFT);
        $path_string = substr($id_string, 0, -9) . "/" . implode("/", str_split(substr($id_string, -9), 3));

        //$file_extension = strtolower(pathinfo($this->record["name"], PATHINFO_EXTENSION));
        //if ($file_extension !== "")
        //{
        //    $path_string = $path_string . "." . $file_extension;
        //}
        //else
        //{
        //}

        // Format: {number}-{name}
        //     NNN-a.b      // standard
        //     NNN-a        // no extension
        //     NNN-.b       // no basename

        return $path_string . "-" . $this->record["name"];
    }
}
?>
