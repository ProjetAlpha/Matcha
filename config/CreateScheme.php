<?php

include_once("database.php");
include_once("ManageScheme.php");

$info['host'] = $DB_DSN;
$info['username'] = $DB_USER;
$info['password'] = $DB_PASSWORD;
$info['db_name'] = "Matcha";

$scheme = new ManageScheme($info);

$scheme->add(
    'User',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
      is_confirmed boolean not null default 0,
      is_reset boolean not null default 0,
      confirmation_link VARCHAR(256),
      reset_link VARCHAR(256),
      email VARCHAR(50) NOT NULL,
      username VARCHAR(30) NOT NULL,
      password VARCHAR(256) NOT NULL,
      firstname VARCHAR(30) NOT NULL,
      lastname VARCHAR(30) NOT NULL,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
);


if (isset($argv[1]) && !empty($argv[1])) {
    $scheme->displayCreate = false;
}

if ($argv[1] == "-reset" && is_string($argv[2]) && $argc == 3) {
    $scheme->add($argv[2], 'reset');
}

if ($argv[1] == "-modify" && is_string($argv[2]) && $argc == 3) {
    $scheme->add($argv[2], 'modify');
}

if ($argv[1] == "-delete" && is_string($argv[2]) && $argc == 3) {
    $scheme->delete($argv[2]);
}

if ($argv[1] !== "-delete") {
    // enleve create table si on delete.
    $scheme->run();
}

if ($argv[1] == "-resetAll" && $argc == 2) {
    $scheme->resetAll();
}

if ($argv[1] == "-deleteAll" && $argc == 2) {
    $scheme->deleteAll();
}

if ($argv[1] == "-refreshAll" && $argc == 2) {
    $scheme->refreshAll();
}
