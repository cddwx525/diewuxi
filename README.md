# Introduction

A personal website, containing a simple MVC web app development framwork.

This website contains 2 APPs: "main" and "blog". "main" contains few static
pages which does not use database, this APP acts as main interface of the website.
"blog" use database, it is a simple blog APP.

![main_home](main_home)

![blog_home](blog_home)

![blog_admin](blog_admin)

## Framework Feature

* MVC code structure.
* URL pattern customize, url generation.
* Html tags generation, html code auto indent.
* Database operation class with often used functions.

## "blog" APP feature

* Unlimit category hierarchy list
* Unlimit comment hierarchy list
* Administration panel
* Cookies or session based login remember
* XSRF check
* Cookies token steal check
* File upload, management


# Files organization

    htdocs/
        apps/
            blog/
                controllers/
                lib/
                models/
                views/
                web/
                    css/
                    fonts/
                    uploads/
                config.php
                urls.php
            main/
                controllers/
                lib/
                models/
                views/
                web/
                    css/
                    fonts/
                config.php
                urls.php
        config/
            config.php
        swdf/
            base/
                application.php
                controller.php
                model.php
                view.php
                widget.php
            helpers/
                html.php
                url.php
            swdf.php
            swdf_base.php
        main.php
        robots.txt
        favicon.ico
        .htaccess

# Implenmentation

## `main.php`

### Code

    define("DEBUG", TRUE);
    define("STATIC_FILE", TRUE);

    define("WEB_DIR", "web");           // NOTE: check htaccess
    define("APP_DIR", "apps");          // NOTE: check htaccess

    define("MAIN_SCRIPT", basename(__FILE__));
    define("ROOT_PATH", __DIR__);
    define("CONFIG_PATH", ROOT_PATH . "/config");
    define("CORE_PATH", ROOT_PATH . "/swdf");
    define("RUNTIME_PATH", ROOT_PATH . "/runtime");
    define("APP_PATH", ROOT_PATH . "/" . APP_DIR);

    require CORE_PATH . "/swdf.php";

    $config = require CONFIG_PATH . "/config.php";

    $application = new swdf\base\application($config);
    $application->run();

### Exec flow

1. settings

    `swdf.php`: Define a swdf class, set autoload class, set php.
    `config.php`: Global config.

The `swdf` class is global class, it is necessary to controll the whole data, it is the "pointer".

2. Create $application instance and run with config

## Application

### Code

    // Global config.
    public $config = NULL;
    public $apps = NULL;
    public $main_app = NULL;
    public $url_map = NULL;


    // App properties from config file.
    public $name = NULL;
    public $title = NULL;
    public $version = NULL;
    public $params = NULL;
    public $db_id = NULL;
    public $meta_table = NULL;
    public $sql = NULL;

    public $special_actions = array();


    // App properties runtime.
    public $db = NULL;
    public $router = NULL;
    public $request = NULL;
    public $file = NULL;

    public $data = NULL;


    /**
     *
     *
     */
    public function __construct($config)
    {
        \swdf::$app = $this;                            // Point to this application.
        $this->configure($config);                      // Config overall settings.
    }


    /**
     *
     *
     */
    public function run()
    {
        $request_uri = $_SERVER["REQUEST_URI"];
        $router = $this->get_router($request_uri);

        if ($router === FALSE)
        {
            // Response as static file by php built-in server.

            return FALSE;
        }
        else
        {
            $this->configure_app($router);
            $this->response($router);

            return TRUE;
        }
    }


### Exec flow

1. Get request URI from `$_SERVER["REQUEST_URI"]`
2. Get router form request URI
3. Config app with router
4. Response with router


## Application response


    private function response($router)
    {
        // Special router.
        //
        // special_actions array example:
        // array(
        //     "default" => array("main", "home.show", ""),
        //     "not_found" => array("main", "not_found.show", ""),
        // ),
        if ($router["controller_type"] === "special")
        {
            $special_actions = $this->apps[$this->name]["special_actions"];
            $router["controller_name"] = explode(".", $special_actions[$router["special_flag"]][1])[0];
            $router["action_name"] = explode(".", $special_actions[$router["special_flag"]][1])[1];
        }
        else
        {
        }

        if (
            ($router["method"] === "301") ||
            ($router["method"] === "302")
        )
        {
            header("Location: " . url::get($router["target"], array(), ""), TRUE, $router["method"]);
            exit();
        }
        else
        {
            $controller_class = $this->name . "\\controllers\\" . str_replace("/", "\\", $router["controller_name"]);
            $controller = new $controller_class();

            $filter_result = $controller->filter();
            if ($filter_result === TRUE)
            {
                //$result = $controller->$router["action_name"]();
                $action_name=$router["action_name"];
                $result = $controller->$action_name();
            }
            else
            {
                $result = $filter_result;
            }


            // result[0]: view name
            // result[1]: data array
            $view_class = $this->name . "\\views\\" . str_replace("/", "\\", $result[0]);
            $view = new $view_class($result[1]);

            // Output mode.
            if ($router["method"] === "")
            {
                $view->output_html();
            }
            else if ($router["method"] === "text")
            {
                $view->output_text();
            }
            else
            {
            }
        }
    }


## URL parsing and generation `helper/url.php`

### URL definition

Single URL definition:

    array(
        string pattern,
        array url_base,
        array url_parameters,
        array action,
        array id,
    )

* `pattern`

URL regular expression to match request URI.

* `url_base`

Constant string in URL, there can be more than one element in the array.
Whole URL is made of `url_base` and `url_parameters`.

* `url_parameters`

Parameter names appeared in `pattern`, there can be more than one element in the array.
Whole URL is made of `url_base` and `url_parameters`.

* `action`

Array to location the action. 

    array(
        string app_name,
        string controller_type,
        string controller_name,
        string action_name
        string method,
        array target_url_id,
    )

    `app_name`:         App name.
    `controller_type`:  Controller type. Current only set "COMMON".
    `controller_name`:  The class name with namespace without app name.
    `action_name`:      The method name in controller class.
    `method`:           Current "301"(permanently redirect), or "302"(temporarily redirect), or "text"(use text view), or ""(normal).
    `target_url_id`:    The URL definition redirect to.

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
        array(blog, "COMMON", "guest/article", "slug_show", "", ""),        // action
        array(blog, "guest/article.slug_show", "",),                        // id
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
                array(blog, "COMMON", "admin/home", "show", "", array()),
                array(blog, "admin/home.show", "",),
            ),
            array(
                "^/articles\?action=show&id=(?P<id>\d+)$",
                array("/articles?action=show&id=",),
                array("id",),
                array($app_name, "COMMON", "admin/article", "show", "", array()),
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

    array(
        "app_name"          => $app_name,
        "controller_type"   => $controller_type,
        "special_flag"      => $special_flag,
        "controller_name"   => $controller_name,
        "action_name"       => $action_name,
        "method"            => $method,
        "target"            => $target,
        "parameters"        => array(
                "get"   => $get,
                "post"  => $post,
                "url"   => url::root_url() . $request_uri,
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

    public function get_static($filename)

Get a relate static file URL:

    public function get_static_relate($filename)

Get a static file path:

    public function get_static_file($filename)

## Model `swdf/model.php`

Inherited by app's model class, in subclass, set table name, app setting.
Define some public helper function to simplify database operation

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

    public function batch_where($where = array())
        return $this;

    public function order($order = array())
        return $this;

    public function limit($offset, $count)
        return $this;

## App

Fully use class with namespace, prefix root namespace `<app_name>`.

### App config `apps/<appname>/config.php`

Only set some constant variables.

    "name" => "blog",
    "title" => "SWDF test blog",
    "version" => "1.0.1",
    "params" => array(
    ),

    "db_id" => array(
        "host" => "localhost",
        "name" => "swdf_testblog",
        "user" => "swdf_testblog",
        "password" => "swdf_testblog",
    ),

    "special_actions" => array(
        "default" => array("blog", "guest/home.show", ""),
        "not_found" => array("blog", "common/not_found.show", ""),
    ),

    "meta_table" => "option",
    "sql" => "",

When parse request URI failed, the `NOT_FOUND` key is used to get a controller.
So main app must define this key.

### URL setting `apps/<appname>/urls.php`

Define URLs used in this app.


## simpleblog

Dynamic pages.

# htaccess file

    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/apps/\w+/web/\w+(/\w+)*/.*$
    RewriteCond %{REQUEST_URI} !^/favicon\.ico$
    RewriteCond %{REQUEST_URI} !^/robots\.txt$
    RewriteRule ^.*$ main.php [L]

# Deploy guide

* Check current program version on host
* Backup files and databases of current website
* Prepare release program code.
* Adjust page according to online file just backuped
* Config remote database in apps/{app}/config.php
* Remove local static files
* Set debug, static define in main.php
* Tar program code files
* Tar static files just backuped.
* Delete online files
* Upload program code files
* Upload static files

