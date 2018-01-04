<?php
namespace blog\views\admin\account;

use blog\lib\url;
use blog\lib\views\admin_base;

class edit extends admin_base
{
    public function get_items($result)
    {
        $url = new url();

        $parameters = $result["parameters"];
        $user = $result["user"];
        $form_stamp = $result["form_stamp"];
        $app_space_name = $result["meta_data"]["settings"]["app_space_name"];


        $title = "Edit account setting";
        $position = " > <a href=\"" . $url->get(array($app_space_name, "admin/settings.show", ""), array(), "") . "\">Setting</a> > Edit account setting";

        $account_edit = "<div class=\"content_title border_frame\">
<h3>Edit account(* must be write)</h3>
</div>

<div id=\"edit\" class=\"border_frame\">
<form action=\"". $url->get(array($app_space_name, "admin/account.update", ""), array(), "") . "\" method=\"post\">
<p><input type=\"hidden\" name=\"form_stamp\" value=\"" . $form_stamp . "\" /></p>

<p>* User name(vchar(32)):</p>
<p><input type=\"text\" name=\"name\" value=\"" . $user["name"] . "\" class=\"input_text\" /></p>

<p>* User password(vchar(256)):</p>
<p><input type=\"password\" name=\"password\" value=\"\" class=\"input_text\" /></p>

<p>* User password confirm(vchar(256)):</p>
<p><input type=\"password\" name=\"confirm_password\" value=\"\" class=\"input_text\" /></p>

<p>* User CURRENT password(vchar(256)):</p>
<p><input type=\"password\" name=\"current_password\" value=\"\" class=\"input_text\" /></p>

<p><input type=\"submit\" name=\"update\" value=\"Update\" class=\"input_submit\" /></p>
</form >
</div>";

        $main = "<div id=\"main\" class=\"border_frame\">" . "\n" . $account_edit . "\n" . "</div>";

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
