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
    // si method post / get / json ====> checkCsrf.
    // Form tags with POST hiddden --- Ajax/XHR calls.
    /*
    <input type="hidden" name="csrf_token"
      value="OWY4NmQwODE4ODRjN2Q2NTlhMmZlYWEwYzU1YWQwMTVhM2JmNGYxYjJiMGI4MjJjZDE1ZDZMGYwMGEwOA==">
      ...
    */
/*
 <meta name="csrf-token" content="{{ csrf_token() }}">

var csrf_token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

    axios.defaults.headers.post['anti-csrf-token'] = csrf_token;
    axios.defaults.headers.put['anti-csrf-token'] = csrf_token;
    axios.defaults.headers.delete['anti-csrf-token'] = csrf_token;
    axios.defaults.headers.patch['anti-csrf-token'] = csrf_token;

    // Axios does not create an object for TRACE method by default, and has to be created manually.
    axios.defaults.headers.trace = {}
    axios.defaults.headers.trace['anti-csrf-token'] = csrf_token
 */

    $csrf = new AntiCsrf();
    require_once(dirname(__DIR__).'/RegisterModel.php');
    // -------------------- LOAD ROUTES --------------------
    require_once(dirname(__DIR__).'/Router.php');
