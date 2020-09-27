<?php
namespace main\views;

use main\views\layouts\base;

class about extends base
{
    public function set_items()
    {
        $this->title = "About";
        $this->position = array("About");
        $this->main = "<div>
    <h3>About</h3>

    <p>SWDF(Simple Web Development Framwork) is a simple MVC web app development framwork written in php.</p>
</div>";
    }

    public function set_text()
    {
         $this->text = "About page.";
    }
}
?>
