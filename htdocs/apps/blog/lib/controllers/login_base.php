<?php
namespace blog\lib\controllers;

use blog\lib\controllers\base;
use blog\models\option;

class login_base extends base
{
    public function init()
    {
        $this->set_meta_data();
    }

    public function set_meta_data()
    {
    }
}
?>
