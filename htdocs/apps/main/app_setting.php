<?php
namespace main;

class app_setting
{
    const APP_SPACE_NAME = __NAMESPACE__;

    const APP_DEFAULT_NAME = "App default name when no database.";
    const APP_NAME = "App name when no database.";
    const APP_DESCRIPTION = "App description when no database.";
    const BEGIN_YEAR = "begin year such as 2017 when no database";

    const DB_HOST = "";
    const DB_NAME = "";
    const DB_USER = "";
    const DB_PASSWORD = "";

    const SPECIAL_ACTIONS = array(
        "DEFAULT" => array("home", "show"),
        "NOT_FOUND" => array("not_found", "show"),
    );

    const META_TABLE = "";

    const SQL = "";
}
?>
