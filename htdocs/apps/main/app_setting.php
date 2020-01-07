<?php
namespace main;

class app_setting
{
    const APP_SPACE_NAME = __NAMESPACE__;

    const APP_DEFAULT_NAME = "Main app";
    const APP_VERSION = "1.0.1";

    const SITE_NAME = "Site name when no database.";
    const SITE_DESCRIPTION = "Site description when no database.";
    const SITE_BEGIN_YEAR = "Site begin year such as 2017 when no database";

    const DB_HOST = "";
    const DB_NAME = "";
    const DB_USER = "";
    const DB_PASSWORD = "";

    const SPECIAL_ACTIONS = array(
        "DEFAULT" => array(__NAMESPACE__, "home.show", ""),
        "NOT_FOUND" => array(__NAMESPACE__, "not_found.show", ""),
    );

    const META_TABLE = "";

    const SQL = "";
}
?>
