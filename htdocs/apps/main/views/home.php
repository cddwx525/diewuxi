<?php
namespace main\views;

use main\views\layouts\base;

class home extends base
{
    /**
     *
     */
    protected function set_items()
    {
        $this->description = "Home page swdf(Simple Web development framwork)";
        $this->title = "Home";
        $this->position = array("Home");

        $this->main = "<div>
    <h3>Home</h3>

    <h4>Wellcom to SWDF!</h4>
</div>";
    }


    /**
     *
     *
     */
    protected function set_text()
    {
        $this->text = "################################################################################
This is text mode of home page.


<a href=\"https://www.baidu.com\">Baidu</a>
<img src=\"http://dwx.22web.org/apps/blog/static/media/2018/01/04/diewuxi.png\" />

################################################################################";
    }
}
?>
