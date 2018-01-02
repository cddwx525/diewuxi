<?php
namespace main\lib\controllers;

use main\app_setting;
use main\lib\url;

class base
{
    public $meta_data = array();

    public function __construct()
    {
        $this->set_mata_data();
    }

    public function set_mata_data()
    {
        $this->meta_data["settings"]["app_space_name"] = app_setting::APP_SPACE_NAME;
        $this->meta_data["settings"]["app_default_name"] = app_setting::APP_DEFAULT_NAME;
        $this->meta_data["settings"]["app_name"] = app_setting::APP_NAME;
        $this->meta_data["settings"]["app_description"] = app_setting::APP_DESCRIPTION;
        $this->meta_data["settings"]["begin_year"] = app_setting::BEGIN_YEAR;
    }
}
?>
