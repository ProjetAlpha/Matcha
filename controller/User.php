<?php

class User
{
    public function login()
    {
        view('home.php');
    }

    public function loginPage()
    {
        view('login_form.php');
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

 ?>
