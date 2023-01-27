<?php
return array(
    array(
        "^$",
        array(""),
        array(""),
        array("main", "common", "home", "show", "", array()),
        array("main", "home.show", "",),
    ),
    array(
        "^/$",
        array("/"),
        array(""),
        array("main", "common", "home", "show", "", array()),
        array("main", "", "/",),
    ),
    array(
        "^/about$",
        array("/about"),
        array(""),
        array("main", "common", "about", "show", "", array()),
        array("main", "about.show", "",),
    ),
    array(
        "^/program/index$",
        array("/program/index"),
        array(""),
        array("main", "common", "program", "index", "", array()),
        array("main", "program.index", "",),
    ),
    array(
        "^/program/cwgcal$",
        array("/program/cwgcal"),
        array(""),
        array("main", "common", "program", "cwgcal", "", array()),
        array("main", "program.cwgcal", "",),
    ),
    array(
        "^/screenshot/v1_0$",
        array("/screenshot/v1_0"),
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
