<?php

class PagesController 
{
    /**
     * Lands on the home page
     */
    public function overview() 
    {
        // Show view
        require_once(__DIR__.'/../views/pages/overview.php');
    }

    /** 
     * Show error page
     */
    public function error() 
    {
        require_once(__DIR__.'/../views/pages/error.php');
    }

    /** 
     * Show login page
     */
    public function login() 
    {
        if(!isset($_GET['error'])) {
            $_GET['error'] = '';
        }
        require_once(__DIR__.'/../views/pages/login.php');
    }
}

