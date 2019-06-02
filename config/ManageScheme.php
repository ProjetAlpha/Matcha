<?php

class ManageScheme
{
    private $db;
    private $dbName;
    private $create;

    public function __construct($info)
    {
        if (isset($info) && is_array($info) && keysExist(['username', 'password', 'host', 'db_name'], $info)) {
            $this->initDB($info);
        } else {
            throw new Exception("Invalid database information.");
        }
    }

    private function initDB($info)
    {
        try {
            $this->db = new PDO('mysql:host=127.0.0.1;port=3306;dbname=Camagru', $info['username'], $info['password']);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbName = $info['db_name'];
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function add($table, $type, $sql = null)
    {
      if (!isset($type) || $type == "" || !$this->isSupportedType($type))
        throw new Exception("Unsupported type !");
      if (!isset($table) || $table == "")
        throw new Exception("Invalid table name !");
      if (($type == "reset" || $type == "delete") && $sql !== null)
        throw new Exception("This type".$type."doesnt need an sql query !");
      if (($type == "create" || $type == 'refresh') && $sql == null)
        throw new Exception("This type : ".$type." need an sql query !");
      $this->sqlModel[] = (object)['type' => $type, 'sql' => $sql, 'table' => $table];
    }

    // reset ['table_name'] create['table_name'] delete['table_name'] ou create['*']
    private function isSupportedType($type)
    {
        return ($type == 'delete' || $type == 'create' || $type == 'reset' || $type == 'refresh');
    }

    public function run()
    {
      if (!isset($this->sqlModel) || !is_array($this->sqlModel))
          throw new Exception("No sql model added !");
        foreach ($this->sqlModel as $model) {
          $query = '';
          if ($model->type == "create"){
              $this->create($model->table, $model->sql);
          }
          if ($model->type == "reset"){
            $this->reset($model->table);
          }
          if ($model->type == "delete"){
            $this->delete($model->table);
          }
          if ($model->type == "refresh"){
            $this->delete($model->table);
            $this->create($model->table);
          }
        }
    }

    private excecute($query)
    {
      try {
        $this->db->exec($query);
      }catch (PDOException $e) {
        echo $e->getMessage();
        die();
      }
    }

    private function create($table, $sql)
    {
      $query.= "CREATE TABLE IF NOT EXISTS";
      $query.= $table." ";
      $query.= $sql;
      $this->execute($query);
    }

    private function reset($table)
    {
      $query.= "TRUNCATE TABLE ";
      $query.= $table;
      $this->execute($query);
    }

    private function reset($table)
    {
      $query.= "DELETE TABLE IF EXISTS ";
      $query.= $table;
      $this->execute($query);
    }
}
