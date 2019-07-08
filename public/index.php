<?php
    // -------------------- APP BOOT --------------------
    require_once(dirname(__DIR__).'/utils.php');
    require_once(dirname(__DIR__).'/Request.php');
    require_once(dirname(__DIR__).'/config/database.php');
    require_once(dirname(__DIR__).'/config.php');
    require_once(dirname(__DIR__).'/Message.php');
    require_once(dirname(__DIR__).'/Validate.php');
    require_once(dirname(__DIR__).'/AntiCsrf.php');
    loadSession();
    $csrf = new AntiCsrf();

    require_once(dirname(__DIR__).'/RegisterModel.php');
    // mac / docker connection
    // $redis->connect('redis', '6379');
    // windows / xammp connection

    // ---> Mettre en cache le resultat de la recherche pour chaque user.
    // ---> Mettre en cache le resultat des suggestions pour chaque user.
    // store dans un hash avec user_id
    // Trier :
    // sort by 'age' / 'popularite' / 'localisation'[+ proche - proche => distance] / 'tags'
    //
    // limit pour la pagination
    // Filtrer :
    // by 'tags=[]'
    // by 'localisation=[]'
    // by 'age > 5 ..'
    // -------------------- LOAD ROUTES --------------------
    require_once(dirname(__DIR__).'/Router.php');
