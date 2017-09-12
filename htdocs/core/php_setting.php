<?php
class php_setting
{
    public function run()
    {
        $this->set_reporting();
        $this->set_session();
        $this->set_time();
        //$this->remove_magic_quotes();
        //$this->unregister_globals();
        spl_autoload_register("self::load_class");
    }

    private function set_reporting()
    {
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
    }

    private function set_session()
    {
        ini_set("session.use_strict_mode", "1");
        ini_set("session.use_only_cookies", "1");
        ini_set("session.name", "PHPSESSID");
    }

    private function set_time()
    {
        ini_set("date.timezone", "UTC");
    }

    private function strip_slashes_deep($value)
    {
        $value = is_array($value) ? array_map(array($this, "strip_slashes_deep"), $value) : stripslashes($value);
        return $value;
    }

    private function remove_magic_quotes()
    {
        if (get_magic_quotes_gpc())
        {
            $_GET = isset($_GET) ? $this->strip_slashes_deep($_GET ) : "";
            $_POST = isset($_POST) ? $this->strip_slashes_deep($_POST ) : "";
            $_COOKIE = isset($_COOKIE) ? $this->strip_slashes_deep($_COOKIE) : "";
            $_SESSION = isset($_SESSION) ? $this->strip_slashes_deep($_SESSION) : "";
        }
    }

    private function unregister_globals()
    {
        if (ini_get("register_globals"))
        {
            $array = array("_SESSION", "_POST", "_GET", "_COOKIE", "_REQUEST", "_SERVER", "_ENV", "_FILES");
            foreach ($array as $value)
            {
                foreach ($GLOBALS[$value] as $key => $var)
                {
                    if ($var === $GLOBALS[$key])
                    {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    public static function load_class($class)
    {
        $file = ROOT_PATH . "/apps/" . str_replace("\\", "/", $class) . ".php";

        if (file_exists($file))
        {
            include $file;
        }
        else
        {
            print "[error in load class.]";
        }
    }
}
?>
