<?php
namespace blog\views\admin\authentication;

use blog\lib\url;
use blog\lib\views\login_base;

class login extends login_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Login";

        $position = " > Login";

        if ($state != "SUCCESS")
        {
            if ($state === "UNCOMPLETE")
            {
                $message = "<p class=\"text-warning\">Username or password is uncomplete.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
            else if (($state === "PASSWORD_WRONG") || ($state === "USERNAME_WRONG"))
            {
                $message = "<p class=\"text-warning\">Username or password is wrong.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"text-warning\">[" . $state . "], Login wrong.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"text-success\">Login successfully.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Home</a></p>";
        }

        $content = "<h3 class=\"bg-primary\">Login</h3>
" . $message;

        $main = "<div>" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }

    public function get_string($result)
    {
        return "[text]";
    }
}
?>
