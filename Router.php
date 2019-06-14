<?php

require_once("Route.php");

$route = new Route();

/**
 *   --------- Register forms ---------
 */
$route->add('/login', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'login']);
});

$route->add('/register', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'register']);
});

$route->add('/reset', 'get', function () {
    view('user_register_forms.php', ['registerType' => 'reset']);
});

/**
 *  --------- Authentification ---------
 */
$route->add('/doLogin', 'get', 'UserController@login');
$route->add('/create', 'post', 'UserController@create');
$route->add('/confirm/:alphanum', 'get', 'UserController@confirm');
$route->add('/reset/view/:alphanum', 'get', 'UserController@resetLink');
$route->add('/reset/doReset', 'get', 'UserController@confirmReset');
$route->add('/reset/sendResetLink', 'get', 'UserController@sendResetLink');
$route->add('/logout', 'get', 'UserController@logout');
$route->add('/isAuth', 'get', function () {
    echo json_encode(['user' => ['isAuth' => isAuth(), 'id' => $_SESSION['user_id'] ?? null]]);
});


/**
 *  --------- Public search routes ---------
 */
$route->add('/search', 'get', function () {
    view('search.php', ['type' => 'search']);
});
$route->add('/search/result', 'get', function () {
    view('search.php', ['type' => 'result']);
});

/**
 *  --------- Authenticated users routes ---------
 */

$route->add('/', 'get', function () {
    view('sugestions.php');
})->addMiddleware(function () {
    if (!isAuth()) {
        //redirect('/');
    }
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

/**
 * Seeder Route --- DEV ONLY.
 */
 $route->add('/seeder', 'get', 'seederController@storeSeed')->addMiddleware(function () {
     if (SEEDER !== null) {
         redirect('/');
     }
 });

$route->loadRoutes();
