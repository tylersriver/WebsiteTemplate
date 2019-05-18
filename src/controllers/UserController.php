<?php

class UserController
{
    public function login()
    {
        $password =  $_POST['password'] ?? '';
        $username =  $_POST['username'] ?? '';

        // attempt login
        $userInfo = User::GetOne([
            'username' => $username,
        ]);

        // handle invalid login
        if (empty($userInfo) or !password_verify($password, $userInfo['password'])) {
            $_GET['error'] = 'Invalid Username or Password';
            return call('pages', 'login');
        }

        // Set session
        $_SESSION['login_user'] = $username;
        return call('pages', 'overview');
    }

    public function logout()
    {
        session_destroy();
        $_GET['error'] = 'Logout successful';
        return call('pages', 'login');
    }
}