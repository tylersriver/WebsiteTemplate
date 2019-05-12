<?php


abstract class AbstractView implements ViewInterface
{
    protected $html;

    public function render($return = false)
    {
        if($return) {
            return $this->html;
        }
        echo $this->html;
    }
}