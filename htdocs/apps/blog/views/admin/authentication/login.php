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
                $message = "<p class=\"failure\">Username or password is uncomplete.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
            else if (($state === "PASSWORD_WRONG") || ($state === "USERNAME_WRONG"))
            {
                $message = "<p class=\"failure\">Username or password is wrong.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
            else
            {
                $message = "<p class=\"failure\">[" . $state . "], Login wrong.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Return</a></p>"; 
            }
        }
        else
        {
            $message = "<p class=\"success\">Login successfully.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/home.show", ""), array(), "") . "\">Home</a></p>";
        }

        $content = "<div class=\"content_title border_frame\">
<h3>Login</h3>
</div>

<div class=\"message border_frame\">
" . $message . "
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $content . "\n" . "</div>";

        return array(
            "title" => $title,
            "position" => $position,
            "main" => $main,
        );
    }
}
?>
