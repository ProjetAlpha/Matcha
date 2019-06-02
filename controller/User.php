<?php

class User
{
    public function login()
    {
        view('home.php');
    }

    public function loginPage()
    {
        view('user_register_forms.php', ['type' => 'register']);
    }

    public function logoutPage()
    {
        view('home.php');
    }

    public function searchPage()
    {
        view('search.php');
    }
}
