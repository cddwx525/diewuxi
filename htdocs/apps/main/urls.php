<?php
namespace main;

use main\app_setting;

class urls
{
    public function url_map()
    {
        $app_name = app_setting::APP_SPACE_NAME;

        return array(
            array(
                "^$",
                array(""),
                array(""),
                array($app_name, "", "", "", "301", array($app_name, "", "/",),),
                array($app_name, "", "",),
            ),
            array(
                "^/$",
                array("/"),
                array(""),
                array($app_name, "", "", "", "301", array($app_name, "home.show", "",),),
                array($app_name, "", "/",),
            ),
            array(
                "^/home$",
                array("/home"),
                array(""),
                array($app_name, "COMMON", "home", "show", "", ""),
                array($app_name, "home.show", "",),
            ),
            array(
                "^/about$",
                array("/about"),
                array(""),
                array($app_name, "COMMON", "about", "show", "", ""),
                array($app_name, "about.show", "",),
            ),
            array(
                "^/one_page$",
                array("/one_page"),
                array(""),
                array($app_name, "COMMON", "one_page", "show", "", ""),
                array($app_name, "one_page.show", "",),
            ),

            /*
             * Text mode.
             */
            array(
                "^/home\?mode=text$",
                array("/home?mode=text"),
                array(""),
                array($app_name, "COMMON", "home", "show", "text", ""),
                array($app_name, "home.show", "text",),
            ),
            array(
                "^/about\?mode=text$",
                array("/about?mode=text"),
                array(""),
                array($app_name, "COMMON", "about", "show", "text", ""),
                array($app_name, "about.show", "text",),
            ),
        );
    }
}
?>
