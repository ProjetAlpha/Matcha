<?php

include_once(__DIR__."/database.php");
include_once(dirname(__DIR__)."/utils.php");

class Setup
{
    public static $db;
    private $db_name;
    private $tab_reset = [];
    const MAX_COLUMN_WIDTH = 27;
    const CREATE = 1;
    const RESET = 2;
    const MODIF = 3;

    public function __construct($argv, $argc, $info, $tables, $type, $exclude_tables = null)
    {
        if ($argc !== 2) {
            throw new Exception("Too many arguments.");
        }
        if ($argv[1] !== "-create" && $argv[1] !== "-reset" && $argv[1] !== "-modif") {
            throw new Exception("Invalid arguments.");
        }
        if (is_array($info) && keysExist(['username', 'password', 'host', 'db_name'], $info)) {
            $this->initDB($info);
            if (self::CREATE == $type) {
                $this->createDB();
                $this->createTables($tables);
            }
            if (self::RESET == $type) {
                $this->createTables($tables);
                $this->resetTables($tables);
            }
            if (self::MODIF == $type) {
                $this->deleteTables($tables);
                $this->createTables($tables);
            }
            self::$db = null;
        }
    }

    private function initDB($info)
    {
        try {
            self::$db = new PDO($DB_DSN, $info['username'], $info['password']);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db_name = $info['db_name'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    private function createDB($param = null)
    {
        if (!empty($this->db_name) && isset($this->db_name)) {
            $sql = "CREATE DATABASE IF NOT EXISTS ".$this->db_name;
            vprintf('%s \e[92m%s\e[0m'. PHP_EOL, ['Init DB', 'sucess']);
            self::$db->exec($sql);
        }
    }

    private function resetDB($param = null)
    {
        $sql = "DROP DATABASE IF EXISTS ".$this->db_name;
        self::$db->exec($sql);
    }

    private function createTables($tables)
    {

        foreach ($tables as $value) {
            $method = 'create'.ucfirst(strtolower($value)).'Table';
            $pad = self::MAX_COLUMN_WIDTH - strlen($method);
            if (method_exists($this, $method)) {
                $this->{$method}();
                vprintf("%s".str_repeat(" ", $pad)."\e[92m%s\e[0m". PHP_EOL, [$method, 'sucess']);
            }else {
                $pad = self::MAX_COLUMN_WIDTH - strlen('No method');
                vprintf("%s".str_repeat(" ", $pad)."\e[31m%s\e[0m". PHP_EOL, ['No method', 'failure']);
            }
        }
    }

    private function resetTables($tables)
    {
        foreach ($tables as $value) {
            $method = 'reset'.ucfirst(strtolower($value)).'Table';
            $pad = self::MAX_COLUMN_WIDTH - strlen($method);
            if (method_exists($this, $method) && $value) {
                $this->{$method}();
                vprintf("%s".str_repeat(" ", $pad)."\e[92m%s\e[0m". PHP_EOL, [$method, 'sucess']);
            }else {
                $pad = self::MAX_COLUMN_WIDTH - strlen('No method');
                vprintf("%s".str_repeat(" ", $pad)."\e[31m%s\e[0m". PHP_EOL, ['No method', 'failure']);
            }
        }
    }

    private function deleteTables($tables)
    {
        foreach ($tables as $value) {
            $method = 'delete'.ucfirst(strtolower($value)).'Table';
            $pad = self::MAX_COLUMN_WIDTH - strlen($method);
            if (method_exists($this, $method) && $value) {
                $this->{$method}();
                vprintf("%s".str_repeat(" ", $pad)."\e[92m%s\e[0m". PHP_EOL, [$method, 'sucess']);
            }else {
                $pad = self::MAX_COLUMN_WIDTH - strlen('No method');
                vprintf("%s".str_repeat(" ", $pad)."\e[31m%s\e[0m". PHP_EOL, ['No method', 'failure']);
            }
        }
    }

    private function createUserTable($param = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS Users(
      id INT AUTO_INCREMENT PRIMARY KEY,
      is_confirmed boolean not null default 0,
      is_reset INT(1) not null default 1,
      is_notified boolean not null default 1,
      confirmation_link VARCHAR(256),
      change_link VARCHAR(256),
      name VARCHAR(30) NOT NULL,
      password VARCHAR(256) NOT NULL,
      email VARCHAR(50) NOT NULL,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        self::$db->exec($sql);
    }

    private function createGalleryTable($param = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS Gallery(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      likes INT(11) DEFAULT 0,
      commentary_id INT(11) DEFAULT 0,
      user_id INT(11) DEFAULT 0,
      user_name VARCHAR(256),
      img_path VARCHAR(256),
      current_t TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        self::$db->exec($sql);
    }

    private function createCommentaryTable($param = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS Commentary(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      img_id INT(11),
      user_email VARCHAR(256) NOT NULL,
      user_name VARCHAR(256) NOT NULL,
      comment TEXT,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        self::$db->exec($sql);
    }

    private function createLikesTable($param = null)
    {
        $sql = "CREATE TABLE IF NOT EXISTS Likes(
      id INT(11) AUTO_INCREMENT PRIMARY KEY,
      img_id INT(11),
      user_email VARCHAR(256) NOT NULL,
      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
        self::$db->exec($sql);
    }

    private function resetUserTable($param = null)
    {
        $sql = "TRUNCATE TABLE Users";
        self::$db->exec($sql);
    }

    private function resetGalleryTable($param = null)
    {
        $sql = "TRUNCATE TABLE Gallery";
        self::$db->exec($sql);
    }

    private function resetCommentaryTable($param = null)
    {
        $sql = "TRUNCATE TABLE Commentary";
        self::$db->exec($sql);
    }

    private function resetLikesTable($param = null)
    {
        $sql = "TRUNCATE TABLE Likes";
        self::$db->exec($sql);
    }

    private function deleteUserTable($param = null)
    {
        $sql = "DROP TABLE IF EXISTS Users";
        self::$db->exec($sql);
    }

    private function deleteGalleryTable($param = null)
    {
        $sql = "DROP TABLE IF EXISTS Gallery";
        self::$db->exec($sql);
    }

    private function deleteCommentaryTable($param = null)
    {
        $sql = "DROP TABLE IF EXISTS Commentary";
        self::$db->exec($sql);
    }

    private function deleteLikesTable($param = null)
    {
        $sql = "DROP TABLE IF EXISTS Likes";
        self::$db->exec($sql);
    }

    private function isValidKeys($keys, $array)
    {
        return !array_diff_key(array_flip($keys), $array);
    }
}
