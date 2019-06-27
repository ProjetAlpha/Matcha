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

$route->add('/chat', 'get', function () {
    view('chat.php');
});

/**
 *  --------- Authentification ---------
 */
$route->add('/doLogin', 'post', 'UserController@login');
$route->add('/create', 'post', 'UserController@create');
$route->add('/confirm/:alphanum', 'get', 'UserController@confirm');
$route->add('/reset/view/:alphanum', 'get', 'UserController@resetLink');
$route->add('/reset/doReset', 'post', 'UserController@confirmReset');
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
    if (isAuth()) {
        setLastVisited();
    }
});

/*
   - MiddlewareStack pour les requêtes js et les requetes post des formulaires.
 */

$route->addMiddlewareStack(
    [
      '/like/setLike',
      '/like/getLikeByUser',
      '/like/setDisLike',
      '/settings/newFirstName',
      '/settings/newLastname',
      '/settings/newAge',
      '/settings/newEmail',
      '/settings/newPassword',
      '/profil/isOnline',
      '/profil/getProfilViews',
      '/profil/getProfilPicById',
      '/profil/getProfilLikes',
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
      '/report/add',
      '/block/add',
      '/report/isReported',
      '/block/isBlocked',
      '/block/unblock',
      '/settings/newFirstname',
      '/settings/newLastname',
      '/settings/newAge',
      '/settings/newEmail',
      '/settings/newPassword',
      '/settings/getUserInfo',
      '/chat/fetchMatchedUser',
      '/doLogin',
      '/reset/sendResetLink',
      '/reset/doReset',
      'callback' => function () use ($csrf) {
          if (!$crsf->check()) {
              redirect('/');
          }
      }
  ]
);

$route->addMiddlewareStack(
    [
      '/like/setLike',
      '/like/getLikeByUser',
      '/like/setDisLike',
      '/like/isLikedByUser',
      '/settings',
      '/settings/newFirstName',
      '/settings/newLastname',
      '/settings/newAge',
      '/settings/newEmail',
      '/settings/newPassword',
      '/profil',
      '/profil/:digits',
      '/profil/isOnline',
      '/profil/getProfilViews',
      '/profil/getProfilPicById',
      '/profil/getProfilLikes',
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
      '/report/add',
      '/block/add',
      '/report/isReported',
      '/block/isBlocked',
      '/block/unblock',
      '/settings/newFirstname',
      '/settings/newLastname',
      '/settings/newAge',
      '/settings/newEmail',
      '/settings/newPassword',
      '/chat/fetchMatchedUser',
      'callback' => function () {
          if (!isAuth()) {
              redirect('/');
          }
          setLastVisited();
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
$route->add('/profil/edit/addTag', 'post', 'TagController@addTag');
$route->add('/profil/edit/getImg', 'get', 'ImageController@getImg');
$route->add('/profil/edit/deleteTag', 'post', 'TagController@deleteTag');
$route->add('/profil/edit/getTag', 'get', 'TagController@getTag');
$route->add('/profil/edit/addImg', 'post', 'ImageController@addImg');
$route->add('/profil/edit/deleteImg', 'post', 'ImageController@deleteImg');
$route->add('/profil/edit/addProfilImg', 'post', 'ImageController@addProfilImg');
$route->add('/profil/edit/getProfilPic', 'get', 'ImageController@getProfilPic');

$route->add('/profil', 'get', 'ProfilController@getUserProfil');
$route->add('/profil/:digits', 'get', 'ProfilController@getVisitedProfil');
$route->add('/profil/isOnline', 'post', 'ProfilController@isOnline');

$route->add('/profil/getProfilViews', 'get', 'ProfilController@getProfilViews');
$route->add('/profil/getProfilLikes', 'get', 'ProfilController@getProfilLikes');

$route->add('/profil/getProfilPicById', 'post', 'ProfilController@getProfilPicById');
$route->add('/profil/visit/getConsultedProfilPic', 'post', 'ImageController@getConsultedProfilPic');

$route->add('/like/isLikedByUser', 'post', 'LikeController@isLikedByUser');
$route->add('/like/setLike', 'post', 'LikeController@setLike');
$route->add('/like/setDisLike', 'post', 'LikeController@setDisLike');
$route->add('/like/getLikeByUser', 'post', 'LikeController@getLikeByUser');

$route->add('/report/add', 'post', 'SignalUserController@reportUser');
$route->add('/block/add', 'post', 'SignalUserController@blockUser');
$route->add('/report/isReported', 'post', 'SignalUserController@isReported');
$route->add('/block/isBlocked', 'post', 'SignalUserController@isBlocked');
$route->add('/block/unblock', 'post', 'SignalUserController@unblock');
$route->add('/block/getBlockedUsers', 'get', 'SignalUserController@getBlockedUsers');
$route->add('/block/getBlockedUsers', 'get', 'SignalUserController@getBlockedUsers');

$route->add('/chat/fetchMatchedUser', 'get', 'ChatController@fetchMatchedUser');

$route->add('/settings/getUserInfo', 'get', 'SettingsController@getUserInfo')->addMiddleware(function () {
    if (!isAuth()) {
        redirect('/');
    }
});

$route->add('/settings/newFirstname', 'post', 'SettingsController@newFirstname');
$route->add('/settings/newLastname', 'post', 'SettingsController@newLastname');
$route->add('/settings/newAge', 'post', 'SettingsController@newAge');
$route->add('/settings/newEmail', 'post', 'SettingsController@newEmail');
$route->add('/settings/newPassword', 'post', 'SettingsController@newPassword');

/**
 * Seeder Route --- DEV ONLY.
 */
 $route->add('/seeder', 'get', 'SeederController@storeSeed')->addMiddleware(function () {
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
