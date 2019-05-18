<?php


abstract class AbstractView implements ViewInterface
{
    protected $html;

    public function render()
    {
        return $this->html;
    }
}