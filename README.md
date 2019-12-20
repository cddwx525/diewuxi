# Introduction

A simple MVC web app development framwork written in php.

# Feature

* URL map, and reverse map, URL custom freely.

# Implenmentation

1. htaccess file

    RewriteCond %{REQUEST_URI} !^/apps/\w+/static/\w+(/\w+)*/.*$
    RewriteCond %{REQUEST_URI} !^/favicon\.ico$
    RewriteCond %{REQUEST_URI} !^/robots\.txt$
    RewriteRule ^.*$ main.php [L]

2. main.php


    include CONFIG_PATH . "/config.php";

Define version, debug, default_app, static_file

    include CORE_PATH . "/php_setting.php";

A class with methods of setting error reporting, session, time zone, slash, magic quote, load class

    include CORE_PATH . "/url_parser.php";

A class with methods of parse URI string

    include CORE_PATH . "/db_method.php";

A class with methods of operate database

Create php_setting object and do some method.

Condition, whether use php built-in static file server.
If yes, all URI pass to the parser, except URI is a static file.
If no, all URI pass to the parser.

Dynamic match get a array dynamic_match.

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

Create a app_setting object accroding dynamic_match result, and get special actions.

If controller_type is special, get controller_name and action accroding special actions in app_setting object.

If method is 301 or 302 do something respectively.
else do some common things as below.
Create a controller object and do a action accroding dynamic_match result.
Create a view object accroding dynamic_match result.
If method is text view object do text action, or method is empty, do layout action.

3. URL parsing and generation

Get url_map from all url patterns.
Match URI with erery patterns, and get a result.

URL map example

    array(
        "^/articles/(?P<full_article_slug>([[:word:]-]+/)+[[:word:]-]+)$",  // pattern
        array("/articles/",),                                               // url base string
        array("full_article_slug", ""),                                     // url parameters
        array($app_name, "COMMON", "guest/article", "slug_show", "", ""),   // action
        array($app_name, "guest/article.slug_show", "",),                   // id
    ),


# File relations

* main.php
    * core/url_parser.php
        * config/url.php
            * apps/{<main_app_name>}/urls.php
                * apps/{<main_app_name>}/app_setting.php
            * apps/{<other_app_name>}/urls.php
                * apps/{<other_app_name>}/app_setting.php
    * core/php_setting.php
    * core/db_method.php
    * config/config.php

    * apps/{<app_name>}/app_setting.php
    * apps/{<app_name>}/controllers/{<controller_name>}.php
        * apps/{<app_name>}/models/{<model_name>}.php
        * apps/{<app_name>}/lib/controllers/guest_base.php
            * apps/{<app_name>}/models/{<model_name>}.php
                * apps/{<app_name>}/lib/db_hander.php
                    * apps/{<app_name>}/app_setting.php
                    * core/db_method.php
            * apps/{<app_name>}/app_setting.php
            * apps/{<app_name>}/lib/url.php
                    * core/url_parser.php
            * apps/{<app_name>}/lib/controllers/base.php
                * apps/{<app_name>}/models/{<model_name>}.php
                    * apps/{<app_name>}/lib/db_hander.php
                        * apps/{<app_name>}/app_setting.php
                        * core/db_method.php
                * apps/{<app_name>}/app_setting.php
                * apps/{<app_name>}/lib/url.php
                    * core/url_parser.php
    * apps/{<app_name>}/views/{<view_name>}.php
        * apps/{<app_name>}/lib/views/guest_base.php
            * apps/{<app_name>}/lib/url.php
                * core/url_parser.php
            * apps/{<app_name>}/lib/views/base.php
                * apps/{<app_name>}/lib/html.php
                    * apps/{<app_name>}/lib/url.php
                        * core/url_parser.php
                * apps/{<app_name>}/lib/url.php
                    * core/url_parser.php
        * apps/{<app_name>}/lib/url.php
            * core/url_parser.php
