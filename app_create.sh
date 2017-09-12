#!/bin/sh

set -o errexit

name="${1}"

cd htdocs/apps

mkdir "${name}"

cd "${name}"

cat > app_main.php << END
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


cat > app_setting.php << END
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

cat > urls.php << END
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

cat > lib/url.php << END
<?php
namespace ${name}\\lib;

class url extends \\url_parser
{
}
?>
END

cat > lib/db_hander.php << END
<?php
namespace ${name}\\lib;

use ${name}\\app_setting;

class db_hander extends \\db_method
{
}
?>
END

mkdir lib/controllers

cat > lib/controllers/base.php << END
<?php
namespace ${name}\\lib\\controllers;

use ${name}\\lib\\url;

class base
{
    public function init()
    {
    }
}
?>
END

mkdir lib/views

cat > lib/views/html.php << END
<?php
namespace ${name}\\lib\\views;

abstract class html
{
    abstract protected function get_part(\$result);

    public function layout(\$result)
    {
        \$part = \$this->get_part(\$result);

        print "<!DOCTYPE html>
<html>
<head>
" . \$part["head"] . "
</head>
<body>
" . \$part["body"] . "
</body>
</html>";
    }
}
?>
END

cat > lib/views/base.php << END
<?php
namespace ${name}\\lib\\views;

use ${name}\\lib\\url;
use ${name}\\lib\\views\\html;

abstract class base extends html
{
    /*
     * title
     * main
     */
    abstract protected function get_items(\$result);

    /*
     * Use modified variables to complete abstact function in parent.
     */
    protected function get_part(\$result)
    {
        \$url = new url();

        \$items = \$this->get_items(\$result);


        /*
         * Head part.
         */
        \$meta_http_equiv = "<meta http-equiv=\\"Content-Type\\" content=\\"text/html; charset=utf-8\\" />";
        \$meta_viewport = "<meta name=\\"viewport\\" content=\\"width=device-width, initial-scale=1\\" />";

        \$link_css = array();
        \$link_css[] = "<link rel=\\"stylesheet\\" type=\\"text/css\\" href=\\"" . \$url->get_static("css/main.css") . "\\">";
        \$link_css = implode("\\n", \$link_css);

        \$mathjax = "<script type=\\"text/x-mathjax-config\\">MathJax.Hub.Config({tex2jax: {inlineMath: [['\$','\$'], ['\\\\\\\\(','\\\\\\\\)']]}, processEscapes: true, TeX: {extensions: [\\"mhchem.js\\"]}});</script>
<script type=\\"text/javascript\\" async src=\\"https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS_CHTML\\"></script>";

        \$title_block = "<title>" . \$items["title"] . " - Site_name</title>";

        \$head = array();
        \$head[] = \$meta_http_equiv;
        \$head[] = \$meta_viewport;
        \$head[] = \$link_css;
        \$head[] = \$mathjax;
        \$head[] = \$title_block;

        \$head = implode("\\n", \$head);


        /*
         * Body part.
         */
        \$header = "<div id=\\"header\\" class=\\"border_frame\\">
<div id=\\"site_name\\">
<h1><a href=\\"" . \$url->get(array(APP_NAME, "home", ""), array(), "") . "\\">Site_name</a></h1>
</div>

<div id=\\"site_description\\">
<p>Site_description</p>
</div>
</div>

<div id=\\"top_menu\\" class=\\"border_frame\\">
<div id=\\"top_menu_list\\">
<ul>
<li><a href=\\"" . \$url->get(array(APP_NAME, "home", ""), array(), "") . "\\">Home</a></li>
<li><a href=\\"" . \$url->get(array(APP_NAME, "about", ""), array(), "") . "\\">About</a></li>
</ul>
</div>
<div class=\\"clear_both\\"></div>
</div>";

        \$footer = "<div id=\\"footer\\" class=\\"border_frame\\">
<p>Site_name this_year--" . date("Y") . "</p>
</div>";


        \$body = array();
        \$body[] = \$header;
        \$body[] = \$items["main"];
        \$body[] = \$footer;

        \$body = implode("\\n\\n", \$body);

        return array(
            "head" => \$head,
            "body" => \$body,
        );
    }
}
?>
END

mkdir static

mkdir static/css

cat > static/css/main.css << END
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
