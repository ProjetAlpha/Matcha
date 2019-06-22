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

$route->addMiddlewareStack(
    [
      '/like/setLike',
      '/like/getLikeByUser',
      '/like/setDisLike',
      '/like/isLikedByUser',
      '/settings',
      '/profil',
      '/profil/:digits',
      '/profil/edit',
      '/profil/edit/modif',
      '/profil/edit/getProfilData',
      '/profil/edit/addTag',
      '/profil/edit/getImg',
      '/profil/edit/deleteTag',
      '/profil/edit/getTag',
      '/profil/edit/addImg',
      '/profil/edit/deleteImg',
      '/profil/edit/addProfilImg',
      '/profil/edit/getProfilPic',
      '/profil/visit/getConsultedProfilPic',
    'function' => function () {
        if (!isAuth()) {
            redirect('/');
        }
    }]
);


$route->add('/settings', 'get', function () {
    view('settings.php');
});

$route->add('/profil/edit', 'get', function () {
    view('editProfil.php');
});

$route->add('/profil/edit/modif', 'post', 'ProfilController@editProfil');
$route->add('/profil/edit/getProfilData', 'get', 'ProfilController@getData');
$route->add('/profil/edit/addTag', 'get', 'TagController@addTag');
$route->add('/profil/edit/getImg', 'get', 'ImageController@getImg');
$route->add('/profil/edit/deleteTag', 'get', 'TagController@deleteTag');
$route->add('/profil/edit/getTag', 'get', 'TagController@getTag');
$route->add('/profil/edit/addImg', 'get', 'ImageController@addImg');
$route->add('/profil/edit/deleteImg', 'get', 'ImageController@deleteImg');
$route->add('/profil/edit/addProfilImg', 'get', 'ImageController@addProfilImg');
$route->add('/profil/edit/getProfilPic', 'get', 'ImageController@getProfilPic');
$route->add('/profil', 'get', 'ProfilController@getUserProfil');
$route->add('/profil/:digits', 'get', 'ProfilController@getVisitedProfil');
$route->add('/profil/visit/getConsultedProfilPic', 'get', 'ImageController@getConsultedProfilPic');

$route->add('/like/isLikedByUser', 'post', 'LikeController@isLikedByUser');
$route->add('/like/setLike', 'post', 'LikeController@setLike');
$route->add('/like/setDisLike', 'post', 'LikeController@setDisLike');
$route->add('/like/getLikeByUser', 'post', 'LikeController@getLikeByUser');
/**
 * Seeder Route --- DEV ONLY.
 */
 $route->add('/seeder', 'get', 'seederController@storeSeed')->addMiddleware(function () {
     if (SEEDER === null) {
         redirect('/');
     }
 });

 $route->add('/seeder/create', 'get', function () {
     view('seeder.php');
 })->addMiddleware(function () {
     if (SEEDER === null) {
         redirect('/');
     }
 });

$route->loadRoutes();
