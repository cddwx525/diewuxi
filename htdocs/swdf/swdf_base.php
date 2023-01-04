<?php
namespace swdf;

class swdf_base
{
    public static $app = NULL;

    /**
     *
     *
     */
    public static function set_php()
    {
        // set_reporting
        if (DEBUG === true)
        {
            error_reporting(E_ALL);
            ini_set("display_errors","On");
        }
        else
        {
            error_reporting(E_ALL);
            ini_set("display_errors","Off");
            ini_set("log_errors", "On");
            ini_set("error_log", RUNTIME_PATH. "logs/error.log");
        }

        // set_session
        ini_set("session.use_strict_mode", "1");
        ini_set("session.use_only_cookies", "1");
        ini_set("session.name", "PHPSESSID");

        // set_time
        ini_set("date.timezone", "UTC");
    }


    /**
     *
     *
     */
    public static function load_class($class)
    {
        $path_list = array();
        $path_list[] = ROOT_PATH . "/" . APP_DIR . "/" . str_replace("\\", "/", $class) . ".php";
        $path_list[] = ROOT_PATH . "/" . str_replace("\\", "/", $class) . ".php";

        $file_path = NULL;

        foreach ($path_list as $one_path)
        {
            if (file_exists($one_path))
            {
                $file_path = $one_path;
                break;
            }
            else
            {
            }
        }

        if (! is_null($file_path))
        {
            include $file_path;
        }
        else
        {
            print "Error load class " . $class . " at: " . $one_path . "<br />";
            exit();
        }
    }


    /**
     *
     *
     */
    //public static function create_object($config)
    //{
    //}
}
?>
