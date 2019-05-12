<?php


interface ViewInterface
{
    /**
     * Render the view
     * @param bool $return - return view or output it
     * @return void|string - html
     */
    function render($return = false);
}