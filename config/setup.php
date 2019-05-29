<?php

include_once("database.php");
include_once("ManageSetup.php");


if ($argv[1] == "-create" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary', 'likes'], SETUP::CREATE);
}

if ($argv[1] == "-reset" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary', 'likes'], SETUP::RESET);
}

if ($argv[1] == "-modif" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary', 'likes'], SETUP::MODIF);
}

if ($argv[1] == "-help" && $argc == 2){
    vprintf("\e[4mUsage\e[0m\n \e[92m%s\e[0m\n \e[92m%s\e[0m\n \e[92m%s\e[0m\n", ['-create', '-reset', '-modif']);
}
