<?php
namespace blog\lib\controllers;

use blog\lib\controllers\base;
use blog\models\user;

class admin_base extends base
{
    public function init()
    {
        $this->set_meta_data();
    }

    public function set_meta_data()
    {
        $table_user = new user();

        if ($this->authentication === TRUE)
        {
            $where = array(
                array(
                    "field" => "name",
                    "value" => $_SESSION["name"],
                    "operator" => "=",
                    "condition" => "",
                ),
            );
            $user = $table_user->where($where)->select_first()["record"];

            $this->meta_data["session"]["user"] = $user;
        }
        else
        {
        }
    }

    public function get_form_stamp()
    {
        $table_user = new user();

        $form_stamp = bin2hex(openssl_random_pseudo_bytes(32));

        $table_user->update_by_id((int) $this->meta_data["session"]["user"]["id"], array("form_stamp" => $form_stamp,));

        return $form_stamp;
    }
}
?>
