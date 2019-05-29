<?php

require_once("Route.php");

$route = new Route();

$route->add('/', 'get', 'Home@homePage');
$route->add('/login', 'get', 'User@loginPage');
$route->add('/logout', 'post', 'User@logoutPage');
$route->add('/authenticate', 'post', 'User@login');

$route->add('/search', 'post', 'User@searchPage');
//$route->add('/page/:digits', 'get', 'Image@getAllImg');*/

$route->loadRoutes();
