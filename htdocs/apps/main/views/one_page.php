<?php
namespace main\views;

use main\views\layouts\base;

class one_page extends base
{
    public function set_items()
    {
        $this->title = "One page";
        $this->position = array("One page");
        $this->main = "<div>
    <h3>One page</h3>

    <h4>Title 1</h4>
    <p>Some text. Some text. Some text. Some text. Some text. Some text. Some text. Some text. Some text.</p>

    <h4>Title 2</h4>
    <ul>
        <li>item item item item item item item item item item</li>
        <li>item item item item item item item item item item</li>
        <li>item item item item item item item item item item</li>
        <li>item item item item item item item item item item</li>
        <li>item item item item item item item item item item</li>
    </ul>
</div>";
    }

    public function set_text()
    {
        $this->text = "one page";
    }
}
?>
