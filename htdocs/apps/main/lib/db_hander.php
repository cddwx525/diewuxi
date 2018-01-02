<?php
namespace main\lib;

use main\app_setting;

class db_hander extends \db_method
{
    public function get_app_setting()
    {
        $app_setting = new app_setting();

        return $app_setting;
    }

}
?>
