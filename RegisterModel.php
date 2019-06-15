<?php
class Models
{
    const FETCH_ONE = 1;
    const FETCH_ALL = 2;
    public $db;

    public function __construct($classArray)
    {
        $this->db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->createObjects($classArray);
    }

    private function createObjects($classArray)
    {
        foreach ($classArray as $key => $value) {
            if (!property_exists($this, $key)) {
                $propertyName = str_replace('models', '', strtolower($key));
                if (property_exists($value, 'linkTable') && isset($_SESSION, $_SESSION['user_id'])) {
                    // Todo : relations entre les tables (inner join, left join...)
                    //$this->{strtolower($linkTable)} = $this->fetchAll($linkTable, ['user_id' => $_SESSION['user_id']], PDO::FETCH_OBJ);
                }
                $this->{$propertyName} = $value;
            }
        }
    }

    private function buildSelect($table, $columns)
    {
        $sql = "SELECT * ";
        $sql .= " FROM ";
        $sql .= $table;
        $sql .= " WHERE ";
        $sql.=  implodeToPdo('=', ' AND ', $columns);
        return ($sql);
    }

    private function buildInsert($table, $columns)
    {
        $sql = "INSERT INTO ";
        $sql .= $table." ";
        $sql .= '('.implode(",", array_keys($columns)).')';
        $sql .= " VALUES ";
        $sql .= '('.implodeToPdo('?', ', ', $columns, true).')';
        return ($sql);
    }

    private function buildUpdate($table, $columns, $condition)
    {
        $sql = "UPDATE ";
        $sql .= $table." SET ";
        $sql .= implodeToPdo('=', ',', $columns);
        $sql .= " WHERE ";
        $sql .= implodeToPdo('=', ' AND ', $condition);
        return ($sql);
    }

    private function buildDelete($table, $columns)
    {
        $sql = "DELETE FROM ";
        $sql .= $table;
        $sql .= " WHERE ";
        $sql .= implodeToPdo('=', ' AND ', $columns);
        return ($sql);
    }

    public function fetch($table, $columns, $option = false)
    {
        $sql = $this->buildSelect($table, $columns);
        $result = $this->exec($sql, $columns, $option, self::FETCH_ONE);
        return ($result);
    }

    public function fetchAll($table, $colums, $option = false)
    {
        $sql = $this->buildSelect($table, $columns);
        $result = $this->exec($sql, $columns, $option);
        return ($result);
    }

    public function insert($table, $columns, $option = false)
    {
        $sql = $this->buildInsert($table, $columns);
        $this->exec($sql, $columns, $option);
    }

    public function update($table, $columns, $conditions, $option = false)
    {
        $sql = $this->buildUpdate($table, $columns, $conditions);
        $this->exec($sql, array_merge($columns, $conditions), $option);
    }

    public function delete($table, $columns, $option = false)
    {
        $sql = $this->buildDelete($table, $columns);
        $this->exec($sql, $columns, $option);
    }

    private function exec($sql, $data, $option, $fetchMethod = false)
    {
        $prepare = $this->db->prepare($sql);
        try {
            $prepare->execute(array_values($data));
        } catch (PDOException $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }

        if ($fetchMethod !== false && ($fetchMethod == self::FETCH_ALL || self::FETCH_ONE)) {
            return ($fetchMethod === self::FETCH_ALL ? $prepare->fetchAll($option) : $prepare->fetch($option));
        }
    }
}
/*
    --> Usage <--
    class A extends Models
    {
        public function __construct()
        {
            parent::__construct(createClassArray(__DIR__.'/model/'));
        }
        // acces a $this->className->method();
    }
*/
