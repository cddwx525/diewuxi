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
        array("main", "common", "home", "show", "", ""),
        array("main", "home.show", "",),
    ),
    array(
        "^/about$",
        array("/about"),
        array(""),
        array("main", "common", "about", "show", "", ""),
        array("main", "about.show", "",),
    ),
    array(
        "^/one_page$",
        array("/one_page"),
        array(""),
        array("main", "common", "one_page", "show", "", ""),
        array("main", "one_page.show", "",),
    ),

    /*
     * Text mode.
     */
    array(
        "^/home\?mode=text$",
        array("/home?mode=text"),
        array(""),
        array("main", "common", "home", "show", "text", ""),
        array("main", "home.show", "text",),
    ),
    array(
        "^/about\?mode=text$",
        array("/about?mode=text"),
        array(""),
        array("main", "common", "about", "show", "text", ""),
        array("main", "about.show", "text",),
    ),
);
?>
