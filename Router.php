<?php

require_once("Route.php");

$route = new Route();

$route->add('/', 'get', function () {
    view('sugestions.php');
});

$route->add('/login', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'login']);
});

$route->add('/doLogin', 'get', 'UserController@login');

$route->add('/register', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'register']);
});

$route->add('/create', 'post', 'UserController@create');

$route->add('/reset', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'reset']);
});

$route->add('/search', 'get', function () {
    view('search.php', ['type' => 'search']);
});

$route->add('/search/result', 'get', function () {
    view('search.php', ['type' => 'result']);
});

$route->add('/settings', 'get', function () {
    view('settings.php');
})->addMiddleware(function () {
    if (!isAuth()) {
        redirect('/');
    }
});;

$route->add('/profil/edit', 'get', function () {
    view('editProfil.php');
})->addMiddleware(function () {
    if (!isAuth()) {
        redirect('/');
    }
});

$route->add('/profil', 'get', function () {
    view('profil.php');
})->addMiddleware(function () {
    if (!isAuth()) {
        redirect('/');
    }
});

$route->add('/logout', 'get', 'UserController@logout');

$route->add('/confirm/:alphanum', 'get', 'UserController@confirm');

$route->add('/isAuth', 'get', function () {
    echo json_encode(['user' => ['isAuth' => isAuth(), 'id' => $_SESSION['user_id'] ?? null]]);
});



$route->loadRoutes();
