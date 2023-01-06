<?php
return array(
    array(
        "^$",
        array(""),
        array(""),
        array("main", "", "", "", "301", array("main", "", "/",),),
        array("main", "", "",),
    ),
    array(
        "^/$",
        array("/"),
        array(""),
        array("main", "", "", "", "301", array("main", "home.show", "",),),
        array("main", "", "/",),
    ),
    array(
        "^/home$",
        array("/home"),
        array(""),
        array("main", "common", "home", "show", "", array()),
        array("main", "home.show", "",),
    ),
    array(
        "^/about$",
        array("/about"),
        array(""),
        array("main", "common", "about", "show", "", array()),
        array("main", "about.show", "",),
    ),
    array(
        "^/one_page$",
        array("/one_page"),
        array(""),
        array("main", "common", "one_page", "show", "", array()),
        array("main", "one_page.show", "",),
    ),
    array(
        "^/screenshot_v1_0$",
        array("/screenshot_v1_0"),
        array(""),
        array("main", "common", "screenshot", "show_v1_0", "", array()),
        array("main", "screenshot.show_v1_0", "",),
    ),

    /*
     * Text mode.
     */
    array(
        "^/home\?mode=text$",
        array("/home?mode=text"),
        array(""),
        array("main", "common", "home", "show", "text", array()),
        array("main", "home.show", "text",),
    ),
    array(
        "^/about\?mode=text$",
        array("/about?mode=text"),
        array(""),
        array("main", "common", "about", "show", "text", array()),
        array("main", "about.show", "text",),
    ),
);
?>
