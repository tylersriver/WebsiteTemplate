<?php


class ErrorView extends AbstractView
{
    function __construct()
    {
        $this->html =
            h('p', 'Oops, this is the error page.') .
            h('p', 'Looks like something went wrong.');
    }
}