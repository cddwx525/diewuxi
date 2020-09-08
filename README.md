# Introduction

A simple MVC web app development framwork written in php.

# Feature

* URL map, and reverse map, URL custom freely.

# Directory structure

    htdocs/
        apps/
            <app1>/
                controllers/
                    ...
                lib/
                    ...
                models/
                    ...
                statics/
                    css/
                        ...
                    fonts/
                        ...
                    media/
                        ...
                views/
                    ...
                app_setting.php
                urls.php
            <app2>
                controllers/
                    ...
                lib/
                    ...
                models/
                    ...
                statics/
                    css/
                        ...
                    fonts/
                        ...
                    media/
                        ...
                views/
                    ...
                app_setting.php
                urls.php
        config/
            config.php
            urls.php
        core/
            db_method.php
            php_setting.php
            url_parser.php
        main.php
        robots.txt
        favicon.ico

# File involved relations

    main.php
        ^--core/url_parser.php
            ^-- config/url.php
                ^-- apps/{<main_app_name>}/urls.php
                    ^-- apps/{<main_app_name>}/app_setting.php
                ^-- apps/{<other_app_name>}/urls.php
                    ^-- apps/{<other_app_name>}/app_setting.php
        ^-- core/php_setting.php
        ^-- core/db_method.php
        ^-- config/config.php

        ^-- apps/{<app_name>}/app_setting.php
        ^-- apps/{<app_name>}/controllers/{<controller_name>}.php
            ^-- apps/{<app_name>}/models/{<model_name>}.php
            ^-- apps/{<app_name>}/lib/controllers/guest_base.php
                ^-- apps/{<app_name>}/models/{<model_name>}.php
                    ^-- apps/{<app_name>}/lib/db_hander.php
                        ^-- apps/{<app_name>}/app_setting.php
                        ^-- core/db_method.php
                ^-- apps/{<app_name>}/app_setting.php
                ^-- apps/{<app_name>}/lib/url.php
                        ^-- core/url_parser.php
                ^-- apps/{<app_name>}/lib/controllers/base.php
                    ^-- apps/{<app_name>}/models/{<model_name>}.php
                        ^-- apps/{<app_name>}/lib/db_hander.php
                            ^-- apps/{<app_name>}/app_setting.php
                            ^-- core/db_method.php
                    ^-- apps/{<app_name>}/app_setting.php
                    ^-- apps/{<app_name>}/lib/url.php
                        ^-- core/url_parser.php
        ^-- apps/{<app_name>}/views/{<view_name>}.php
            ^-- apps/{<app_name>}/lib/views/guest_base.php
                ^-- apps/{<app_name>}/lib/url.php
                    ^-- core/url_parser.php
                ^-- apps/{<app_name>}/lib/views/base.php
                    ^-- apps/{<app_name>}/lib/html.php
                        ^-- apps/{<app_name>}/lib/url.php
                            ^-- core/url_parser.php
                    ^-- apps/{<app_name>}/lib/url.php
                        ^-- core/url_parser.php
            ^-- apps/{<app_name>}/lib/url.php
                ^-- core/url_parser.php


# Implenmentation

## Entrance file `main.php`

### Include files and setting

* Include files

    include CONFIG_PATH . "/config.php";
    include CORE_PATH . "/php_setting.php";
    include CORE_PATH . "/url_parser.php";
    include CORE_PATH . "/db_method.php";

`config.php`: Define version, debug, default app, static file.

`php_setting.php`: A class with methods of setting error reporting, session, time zone, slash, magic quote, load class.

`url_parser.php`: A class with methods of parse URI string.

`db_method.php`: A class with methods of operate database.

* Create `php_setting` object and do some actions

### Parse request URI

* Get request URI from `$_SERVER["REQUEST_URI"]`

* Create `url_parser` object

* Condition, whether use php built-in static file server

If `STATIC_FILE` configed `TRUE`, some static file are directly served by php sever, not use `url_parser`.
If `STATIC_FILE` configed `FALSE`, all URIs are passed to the `url_parser`.

* `url_parser` match the request URI and return a array `dynamic_match`

* Create a `app_setting` object accroding `dynamic_match` result

### Not found

If `controller_type` is `"SPECIAL"`, that is to say match failed.
At the same time, `app_name` is `"MAIN_APP"` and `controller_flag` is `"NOT_FOUND"`.
According `controller_flag`, in `app_setting.php` of `MAIN_APP`, a new URL definition is choosed.
Then new `controller_name` and `action_name` is assigned.

If not, use original data in `dynamic_match`.

### Redirect

If `method` is `301` or `302`, do redirection respectively, and exit.

If not, next action, see below.

### Action and response HTML

* Create a controller object and run action accroding `dynamic_match` result

Return a array which contains some data, such as `view_name`, model data.

* Create a view object accroding return value of above action

* Make the view

If `method` is `text`, view object do text view action, or method is empty, do noral view action.


## URL parsing and generation `core/url_parer.php`

### URL definition

Single URL definition:

    array(
        string pattern,
        array url_base,
        array url_parameters,
        array action,
        array id,
    )

* `pattern`, string

URL regular expression to match request URI.

* `url_base`, array

Constant string in URL, there can be more than one element in the array.
Whole URL is made of `url_base` and `url_parameters`.

* `url_parameters`, array

Parameter names appeared in `pattern`, there can be more than one element in the array.
Whole URL is made of `url_base` and `url_parameters`.

* `action`, array

Array to location the action. 

    array(
        string app_name,
        string controller_type,
        string controller_name,
        string action_name
        string method,
        array target_url_id,
    )

`app_name`: App name.

`controller_type`: Controller type. Current only set "COMMON".

`controller_name`: The class name with namespace without app name.

`action_name`: The method name in controller class.

`method`: Current "301"(permanently redirect), or "302"(temporarily redirect), or "text"(use text view), or ""(normal).

`target_url_id`: The URL definition redirect to.

* `id`

    array(
        string app_name,
        string identifier,
        string extra,
    )

`app_name`: App name.

`identifier`: Identifier to identify this single url definition, typical use `<controller_name>.<action_name>`.

`extra`: Extra identifier when some situation, for example, URL whether append "/".

example:

    array(
        "^/articles/(?P<full_article_slug>([[:word:]-]+/)+[[:word:]-]+)$",  // pattern
        array("/articles/",),                                               // url base string
        array("full_article_slug", ""),                                     // url parameters
        array(blog, "COMMON", "guest/article", "slug_show", "", ""),   // action
        array(blog, "guest/article.slug_show", "",),                   // id
    ),

    match url for example "/articles/life/how-to-drive".
    full_article_slug parameter is "life/how-to-drive."
    use `slug_show()` method in \apps\blog\guest\article class.
    no redirect.

* prefix shortcut

    array(
        string prefix_pattern,
        array prefix_url_base,
        array url_parameters,
        array url_definitions,
    )

Reduce works when some pattern are in common at home.

`prefix_pattern`: Prefix pattern.

`prefix_url_base`: Prefix url base.

`url_parameters`: Current not use, "".

`url_definitions`: Contains sub URL definitions.

example:

    array(
        "^/admin",
        array("/admin"),
        array(""),
        array(
            array(
                "^/$",
                array("/"),
                array(""),
                array(blog, "", "", "", "301", array($app_name, "admin/home.show", "",),),
                array(blog, "", "/",),
            ),
            array(
                "^/home\?action=show$",
                array("/home?action=show"),
                array(""),
                array(blog, "COMMON", "admin/home", "show", "", ""),
                array(blog, "admin/home.show", "",),
            ),
            array(
                "^/articles\?action=show&id=(?P<id>\d+)$",
                array("/articles?action=show&id=",),
                array("id",),
                array($app_name, "COMMON", "admin/article", "show", "", ""),
                array($app_name, "admin/article.show", "",),
            ),
        ),
    )

* File organization

In the app root directory `urls.php`, define URLs used in this app.
In `config/urls.php`, include URLs definitions of every app, form a big array, I call it as `url_map`.


### URL parsing

Get `url_map` from `config/urls.php`.
Use URL definitions to match the request URI, the first matched URL definition is got and a array of parameters related to the URL definition are returned.

The array:

    return array(
        "app_name" => $app_name,
        "controller_type" => $controller_type,
        "special_flag" => $special_flag,
        "controller_name" => $controller_name,
        "action_name" => $action_name,
        "method" => $method,
        "target" => $target,
        "parameters" => array(
            "get" => $get,
            "post" => $post,
            "url" => $this->root_url() . $original_string,
        ),
    );

* When match successfully:

`app_name`: App name set in URL definition.

`controller_type`: Controller type set in URL definition. 

`controller_flag`: Current "". 

`controller_name`: Controller name set in URL definition.

`action_name`: Action name set in URL definition.

`method`: Method set in URL definition.

`target`: Target set in URL definition.

`parameters`: A array. 
`get` is url parameter arrays match in URL definition , `post` is `$_POST` data array, `url` is this full URL.

* When match failed:

`app_name`: Current `"MAIN_APP"`.

`controller_type`: Current `SPECIAL`.

`controller_flag`: Current `"NOT_FOUND"`. 

`controller_name`: Current "".

`action_name`: Current "".

`method`: Current "".

`target`: Current "".

`parameters`: A array. 
`get` is array(), `post` is `$_POST` data array, `url` is this full URL.

### URL generate

Get a URL:

    public function get($url_record, $parameters, $anchor)

Get a absolute static file URL:

    public function get_static($app_name, $filename)

Get a relate static file URL:

    public function get_static_relate($app_name, $filename)

Get a static file path:

    public function get_static_file($app_name, $filename)

## Database helper class `core/db_method.php`


* Connect database with information from sub calss when object is created.

When create object, get information and run connecting database, if table not exists, create it with SQL statements setting in app setting class.

Inherited by app's model class, in subclass, set table name, app setting.

* Define some public helper function to simplify database operation


    public function raw($sql)
        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );

    public function select()
        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );

    public function select_count()
        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );

    public function select_first()
        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );

    public function select_by_id($id)
        return array(
            "errorcode" => $errorcode,
            "record" => $record,
        );

    public function add($data)
        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
            "last_id" => $last_id,
        );

    public function update($data)
        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );

    public function update_by_id($id, $data)
        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );

    public function delete()
        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );

    public function delete_by_id($id)
        return array(
            "errorcode" => $errorcode,
            "row_count" => $row_count,
        );

    public function where($where = array())
        return $this;

    public function order($order = array())
        return $this;

    public function limit($limit = array())
        return $this;

## App

Fully use class with namespace, prefix root namespace `<app_name>`.

### App setting `apps/<appname>/app_setting.php`

Only set some constant variables.

    const APP_SPACE_NAME = __NAMESPACE__;

    const APP_DEFAULT_NAME = "<app name>";
    const APP_VERSION = "<app version>";
    
    const SITE_NAME = "<site name>";
    const SITE_DESCRIPTION = "<site description>";
    const SITE_BEGIN_YEAR = "<begin year>";

Database settings:

    const DB_HOST = "<host>";
    const DB_NAME = "<database name>";
    const DB_USER = "<database username>";
    const DB_PASSWORD = "<database password>";

Session settings:

    const SESSION_REGENERATE_TIME = 900;
    const SESSION_OLD_LAST_TIME = 120;
    const COOKIES_TIME = 864000;

Upload file setting:

    const MAX_FILE_SIZE = 5000000;

Initialization tables setting:

    const META_TABLE = "option";
    const SQL = ""

`SPECIAL_ACTIONS` array:

    const SPECIAL_ACTIONS = array(
            "DEFAULT" => array(__NAMESPACE__, "guest/home.show", ""),
            "NOT_FOUND" => array(__NAMESPACE__, "common/not_found.show", ""),
        );

When parse request URI failed, the `NOT_FOUND` key is used to get a controller.
So main app must define this key.

### URL setting `apps/<appname>/urls.php`

Define URLs used in this app.


# Example app

## main

Static pages.

## simpleblog

Dynamic pages.

### Feature

* Add, update, delete, get function for article, category, tag
* Edit about and home page
* Edit article with markdown syntax
* Unlimit category hierarchy list
* Unlimit comment hierarchy list
* Article-tag many-to-many relation
* All left-align HTML code
* Cookies or session based login remember
* XSRF check
* Cookies token steal check
* Media managent

# htaccess file

    RewriteCond %{REQUEST_URI} !^/apps/\w+/static/\w+(/\w+)*/.*$
    RewriteCond %{REQUEST_URI} !^/favicon\.ico$
    RewriteCond %{REQUEST_URI} !^/robots\.txt$
    RewriteRule ^.*$ main.php [L]

