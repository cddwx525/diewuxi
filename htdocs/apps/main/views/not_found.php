<?php
namespace main\views;

use main\views\layouts\base;

class not_found extends base
{
    public function set_items()
    {
        $this->title = "Not found";
        $this->position = array("Not Found");
        $this->main = "<div>
    <h3>Not Found!</h3>
    <p>Your request page: \"" . \swdf::$app->request["url"] . "\" is not found on this server.</p>
</div>";
    }

    public function set_text()
    {
        $this->text = "################################################################################
This is text mode of not found page.
################################################################################";
    }
}
?>
