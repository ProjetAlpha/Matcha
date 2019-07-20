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
      last_visited DATETIME default NULL,
      email VARCHAR(50) NOT NULL,
      username VARCHAR(30) NOT NULL,
      password VARCHAR(256) NOT NULL,
      firstname VARCHAR(30) NOT NULL,
      lastname VARCHAR(30) NOT NULL,
      age INT(3) NOT NULL,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
);

$scheme->add(
    'Profil',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
      user_id INT(11) NOT NULL,
      bio TEXT,
      score INT(3),
      genre VARCHAR(5),
      orientation VARCHAR(15),
      localisation VARCHAR(256),
      profile_pic_path VARCHAR(256),
      profile_pic_name VARCHAR(256),
      longitude FLOAT(20),
      latitude FLOAT(20)"
);

$scheme->add(
    'Tag',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    liked_by INT(11) default NULL,
    visiter_id INT(11) default NULL,
    room_id INT(11) default NULL
    name VARCHAR(256) NOT NULL"
);

//user_id INT(11) NOT NULL, liked_by INT(11)
$scheme->add(
    'Likes',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    liked_by INT(11) NOT NULL"
);

$scheme->add(
    'Visite',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY, user_id INT(11) NOT NULL, visiter_id INT(11) NOT NULL"
);

$scheme->add(
    'Image',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(256) NOT NULL,
    user_id INT(11) NOT NULL,
    path VARCHAR(256) NOT NULL,
    is_profile_pic boolean not null default 0"
);

$scheme->add(
    'Blocked',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    blocked_user INT(11) NOT NULL"
);

$scheme->add(
    'Reported',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    reported_user INT(11) NOT NULL"
);

$scheme->add(
    'Rooms',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT(11) NOT NULL,
    user2_id INT(11) NOT NULL,
    last_msg_date DATETIME default NULL"
);

$scheme->add(
    'Message',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    content TEXT NOT NULL,
    date DATETIME default NULL"
);

$scheme->add(
    'Admin',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    is_dev boolean not null default 0,
    token VARCHAR(256)"
);

$scheme->add(
    'Matched',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    user_profil_id INT(11)"
);

$scheme->add(
    'Tag_list',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(256),
    count INT(11) default 0"
);

$scheme->add(
    'Notification',
    'create',
    "id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    name VARCHAR(256)"
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
