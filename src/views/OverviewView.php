<?php

class OverviewView extends AbstractView
{
    function __construct()
    {
        $this->html = h('div', 'This is the Home Page');

        return $this;
    }
}