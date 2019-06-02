<?php

include_once("database.php");
include_once("ManageScheme.php");

$info['host'] = $DB_DSN;
$info['username'] = $DB_USER;
$info['password'] = $DB_PASSWORD;
$info['db_name'] = "Matcha";

$scheme = new ManageScheme($info);

$scheme->add('User', 'create', '');

if ($argv[1] == "-reset" && is_string($argv[2]) && $argc == 3) {
    $scheme->add($argv[2], 'reset');
}

if ($argv[1] == "-modify" && is_string($argv[2]) && $argc == 3) {
    $scheme->add($argv[2], 'modify');
}

if ($argv[1] == "-resetAll" && $argc == 2) {
}

if ($argv[1] == "-refreshAll" && $argc == 2) {
}

if ($argv[1] == "-modifyAll" && $argc == 2) {
}
