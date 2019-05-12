<?php

class PagesController
{
    /**
     * Lands on the home page
     */
    public function overview()
    {
        // Show view
        (new OverviewView())->render();
    }

    /**
     * Show error page
     */
    public function error()
    {
        (new ErrorView())->render();
    }

    /**
     * Show login page
     */
    public function login()
    {
        if (!isset($_GET['error'])) {
            $_GET['error'] = '';
        }
        (new LoginView())->render();
    }
}

