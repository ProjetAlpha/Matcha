<?php
    // -------------------- APP BOOT --------------------
    require_once(dirname(__DIR__).'/utils.php');
    require_once(dirname(__DIR__).'/config/database.php');
    require_once(dirname(__DIR__).'/config.php');
    require_once(dirname(__DIR__).'/Message.php');
    require_once(dirname(__DIR__).'/Validate.php');
    require_once(dirname(__DIR__).'/RegisterModel.php');

    // -------------------- LOAD ROUTES --------------------
    require_once(dirname(__DIR__).'/Router.php');
    loadSession();
