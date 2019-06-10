<?php

require_once("Route.php");

$route = new Route();

$route->add('/login', 'get', function () {
    view('user_register_forms.php', ['type' => 'login']);
});
$route->add('/register', 'get', function () {
    view('user_register_forms.php', ['type' => 'register']);
});
$route->add('/reset', 'get', function () {
    view('user_register_forms.php', ['type' => 'reset']);
});

$route->add('/logout', 'post', 'User@logoutPage');

$route->add('/search', 'get', function () {
    view('search.php', ['type' => 'search']);
});

$route->add('/', 'get', function () {
    view('sugestions.php');
});

$route->add('/search/result', 'get', function () {
    view('search.php', ['type' => 'result']);
});

$route->add('/settings', 'get', function () {
    view('settings.php');
});

$route->add('/profil/edit', 'get', function () {
    view('editProfil.php');
});

$route->add('/profil', 'get', function () {
    view('profil.php');
});
//$route->add('/page/:digits', 'get', 'Image@getAllImg');*/

$route->loadRoutes();
