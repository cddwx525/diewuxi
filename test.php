<?php
//use blog\app_setting as blog_setting;
//
//$bolg_setting = new blog_setting();

//$original_string = $_SERVER["QUERY_STRING"];
//$original_string = $argv[1];

/*
$subblog_map = array(
    array("^/$", array("subAPP_NAME", "SPECIAL", "DEFAULT", "REDIRECT",)),
    array("^/home$", array("subAPP_NAME", "COMMON", "DEFAULT", "REDIRECT",)),
    array("^/article\?id=(?P<id>\d+)(?P<anchor>\#\w+)$", array("subAPP_NAME", "COMMON", "article", "GET",)),
);

$blog_map = array(
    array("^$", array("APP_NAME", "SPECIAL", "DEFAULT", "REDIRECT",)),
    array("^/$", array("APP_NAME", "SPECIAL", "DEFAULT", "REDIRECT",)),
    array("^/home$", array("APP_NAME", "COMMON", "DEFAULT", "REDIRECT",)),
    array("^/article\?id=(?P<id>\d+)(?P<anchor>\#\w+)$", array("APP_NAME", "COMMON", "article", "GET",)),
    array("^/subblog$", $subblog_map),
);
 */

$blog_map = array(
    array(
        "^/comment_add\?article_id=\d+&target_id=\w+)$",
        array("/comment_add?article_id=", "&target_id=",),
        array("article_id", "target_id",),
        array("blog", "comment_add", "GET", "")
    ),

    array(
        "^/articles(/\w+)+/[\w-]\.html$",
        array("/article/", "/", ".html"),
        array("category_full_name", "slug", ""),
        array("blog", "article_single", "GET", ""),
    ),
);

$url_map = array(
    array(
        "^$",
        array(),
        array(),
        array("defaultapp", "default", "REDIRECT", "")
    ),
    array(
        "^/$",
        array("/"),
        array(""),
        array("defaultapp", "default", "GET", "/")
    ),
    //array("^/blog", $blog_setting->map),
    array(
        "^/blog",
        array("/blog"),
        array(""),
        $blog_map
    ),
    /*
    array(
        "^/blog/\d+",
        array("/blog/"),
        array("blog_number"),
        $blog_map
    ),
     */
);


//print_r($map);
//print "\n";

function parse_uri($map, $target_string)
{
    foreach ($map as $one_map)
    {
        if (preg_match("%" . $one_map[0] . "%", $target_string, $matches) == 1)
        {
            if (is_array($one_map[1][0]) == FALSE)
            {
                return array(
                    "app_name" => $one_map[1][0],
                    "controller_type" => $one_map[1][1],
                    "controller_name" => $one_map[1][2],
                    "method" => $one_map[1][3],
                );
            }
            else
            {
                $new_string = substr($target_string, strlen($matches[0]));
                return $this->parse_uri($one_map[1], $new_string);
            }
        }
        else
        {
        }
    }

    return array(
        "app_name" => "DEFAULT",
        "controller_type" => "SPECIAL",
        "controller_name" => "NOT_FOUND",
        "method" => "GET",
    );
}

function full_url_map($url_map)
{
    $full_url_map = array();
    foreach ($url_map as $key => $value)
    {
        if (is_array($value[3][0]) == FALSE)
        {
            $full_url_map[] = $value;
        }
        else
        {
            foreach ($value[3] as $sub_url_map)
            {
                $full_url_map[] = array(
                    $value[0] . $sub_url_map[0],
                    array_merge($value[1], $sub_url_map[1]),
                    array_merge($value[2], $sub_url_map[2]),
                    $sub_url_map[3],
                );
            }
        }
    }

    return $full_url_map;
}


function search_url_record($url_record, $full_url_map)
{
    foreach ($full_url_map as $one_full_url_record)
    {
        if (in_array($url_record, $one_full_url_record) == TRUE)
        {
            return $one_full_url_record;
        }
    }

    return FALSE;
}


function url_get($url_map, $url_record, $parameter)
{
    $full_url_map = full_url_map($url_map);
    //print_r($full_url_map);
    //exit();

    $one_full_url_record = search_url_record($url_record, $full_url_map);
    //print_r($one_full_url_record);
    //exit();
    if ($one_full_url_record != FALSE)
    {
        $final_url = array();
        $i = 0;
        foreach ($one_full_url_record[1] as $url_string)
        {
            $final_url[] = $url_string;
            if ($one_full_url_record[2][$i] != "")
            {
                $final_url[] = $parameter[$one_full_url_record[2][$i]];
            }
            else
            {
            }
            $i = $i + 1;
        }
        return implode("", $final_url);
    }
    else
    {
        return FALSE;
    }
}

//print_r(parse_uri($map, $original_string, "rootapp"));
//print "\n";
$url = url_get($url_map, array("blog", "article_single", "GET", ""), array("category_full_name" => "computer/programming", "slug" => "yes-i-do"));
//print_r($url);
//print "\n";



/*
 * 2018-01-06
 */

$pattern = "^/(?P<full_category>([[:word:]-]+/)+)(?P<article>[[:word:]-]+)$";
//$pattern = "^/(?P<full_category>([[:word:]-]+/)+)$";
$string = "/test/eeee-32223/test-a-article-again-edit";

if(preg_match("%" . $pattern . "%", $string, $matches) === 1)
{
    print_r($matches);
}
else
{
    print "NO";
}
?>
