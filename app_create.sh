#!/bin/sh

set -o errexit

name="${1}"

cd htdocs/apps

mkdir "${name}"

cd "${name}"

cat >> app_main.php << END
<?php
namespace ${name};

use ${name}\\app_setting;

class app_main extends \\start_app
{
    public function run(\$dynamic_match)
    {
        \$app_setting = new app_setting();

        \$this->set_app(\$app_setting);
        \$this->route(\$dynamic_match, \$app_setting);
    }
}
?>
END


cat >> app_setting.php << END
<?php
namespace ${name};

class app_setting
{
    public static \$app_name = __NAMESPACE__;

    public function set_app()
    {
        define("APP_NAME", __NAMESPACE__);

        define("DB_HOST", "");
        define("DB_NAME", "");
        define("DB_USER", "");
        define("DB_PASSWORD", "");
    }

    public function special_controllers()
    {
        return array(
            "DEFAULT" => "home",
            "NOT_FOUND" => "not_found",
        );
    }

    public static \$meta_table = "";

    public static \$sql = "";
}
?>
END

cat >> urls.php << END
<?php
namespace ${name};

class urls
{
    public static \$app_name = __NAMESPACE__;

    public function url_map()
    {
        \$app_name = \$this::\$app_name;

        return array(
            array(
                "^$",
                array(""),
                array(""),
                array(\$app_name, "", "", "301", array(\$app_name, "", "/",),),
                array(\$app_name, "", "",),
            ),
            array(
                "^/$",
                array("/"),
                array(""),
                array(\$app_name, "", "", "301", array(\$app_name, "home", "",),),
                array(\$app_name, "", "/",),
            ),
            array(
                "^/home$",
                array("/home"),
                array(""),
                array(\$app_name, "COMMON", "home", "", ""),
                array(\$app_name, "home", "",),
            ),
        );
    }
}
?>
END

mkdir controllers

mkdir models

mkdir views

mkdir lib

cat >> lib/url.php << END
<?php
namespace ${name}\\lib;

class url extends \\url_parser
{
}
?>
END

cat >> lib/db_hander.php << END
<?php
namespace ${name}\\lib;

use ${name}\\app_setting;

class db_hander extends \\db_method
{
}
?>
END

mkdir lib/controllers

mkdir lib/views

mkdir static

mkdir static/css

cat >> static/css/main.css << END
/*******************************************************************************
 * Main css.
 ******************************************************************************/

*
{
    /*
    border-style: solid;
    border-width: 1px;
    margin: 0;
    padding: 0;
    */
}

body
{      
    /*
    margin: 0em;
    padding: 0.6em;
    */

    /*
    width: 100%;
    border: solid Brown 1px;
    */

    font-family: Monospace;
    font-size: 100%;

    color: Black;
    background-color: White;
}


/**************************************
 * Link css.
 *************************************/

/*
 * 未被访问的链接
 */
a:link
{
    /*
    color: #00FFFF;
    background-color: #000000;
    */
    color: Blue;
    text-decoration: none;
}

/*
 * 鼠标指针移动到链接上
 */
a:hover
{
    /*
    color: #00FFFF;
    background-color: #000000;
    */
    color: Blue;
    text-decoration: underline;
}

/*
 * 正在被点击的链接
 */
a:active
{
    /*
    color: #00FFFF;
    background-color: #000000;
    */
    color: Blue;
    text-decoration: underline;
}

/*
 * 已被访问的链接
 */
a:visited
{
    /*
    color: #00FFFF;
    background-color: #000000;
    */
    color: Blue;
}


/***************************************
 * General class
 **************************************/
.clear_both
{
    clear: both;
}

.input_text
{
    width: 100%;
}

.input_submit
{
    width: 100%;
    height: 3em;
}

.textarea
{
    width: 100%;
    height: 10em;
}

.description
{
    color: Brown;
}

.border_frame
{
    margin: 0.3em 0em;
    padding: 0.6em;

    border: solid Green 1px;
}
END

mkdir static/image
