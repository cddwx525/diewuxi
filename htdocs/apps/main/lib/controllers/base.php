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

        $this->meta_data["settings"]["special_actions"] = app_setting::SPECIAL_ACTIONS;

        $main_app_setting_class_name = "main\\app_setting";
        $this->meta_data["main_app"]["app_space_name"] = $main_app_setting_class_name::APP_SPACE_NAME;
        $this->meta_data["main_app"]["app_default_name"] = $main_app_setting_class_name::APP_DEFAULT_NAME;
        $this->meta_data["main_app"]["special_actions"] = $main_app_setting_class_name::SPECIAL_ACTIONS;
        $this->meta_data["main_app"]["site_name"] = $main_app_setting_class_name::SITE_NAME;

        $this->meta_data["main_app"]["site_description"] = $main_app_setting_class_name::SITE_DESCRIPTION;
        $this->meta_data["main_app"]["site_begin_year"] = $main_app_setting_class_name::SITE_BEGIN_YEAR;
    }
}
?>
