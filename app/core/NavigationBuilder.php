<?php

class NavigationBuilder
{
    private $navBar = "";
    private $items  = 0;

    public function __construct()
    {
        $this->navBar = "<aside>";
        $this->navBar .= "<ul id='menuTop'>";
    }

    public function addItem($name, $link, $root = false)
    {
        $active = ($this->items == 0) ? " active" : "";
        $class = ($root === true ? "" : " class='indent".$active."'");
        if($root == true && $this->items == 0)
            $class = " class='".$active."'";

        $this->navBar .= "<li".$class.">";
        $this->navBar .= "<a href='#".$link."'>".$name."</a>";
        $this->navBar .= "</li>";

        $this->items++;
    }

    public function renderNavigationBar()
    {
        $this->navBar .= "</ul>";
        $this->navBar .= "</aside>";
        echo $this->navBar;
    }
}