<?php
namespace blog\views\admin\account;

use blog\lib\url;
use blog\lib\views\admin_base;

class update extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $state = $result["state"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Update account setting";
        $position = " > <a href=\"" . $url->get(array($app_space_name, "admin/settings.show", ""), array(), "") . "\">Setting</a> > Update account setting";

        if ($state != "SUCCESS")
        {
            $message = "<p class=\"failure\">[" . $state . "], Update failed!</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/account.edit", ""), array(), "") . "\">Return</a></p>"; 
        }
        else
        {
            $message = "<p class=\"success\">Account setting have been updated successfully! Need to relogin.</p>
<p><a href=\"" . $url->get(array($app_space_name, "admin/authentication.write", ""), array(), "") . "\">Login</a></p>"; 
        }

        $content = "<div class=\"content_title border_frame\" >
<h3>Update account setting</h3>
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
