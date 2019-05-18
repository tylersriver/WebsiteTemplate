<?php

class PagesController
{
    /**
     * Lands on the home page
     */
    public function overview()
    {
        // Show view
        return (new OverviewView())->render();
    }

    /**
     * Show error page
     */
    public function error()
    {
        return (new ErrorView())->render();
    }

    /**
     * Show login page
     */
    public function login()
    {
        if (!isset($_GET['error'])) {
            $_GET['error'] = '';
        }
        return (new LoginView())->render();
    }
}

