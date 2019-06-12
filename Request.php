<?php

class Request
{
    private $request;
    public $fetchedData = [];

    public function __construct($data)
    {
        $this->run($data);
    }

    private function setData($data)
    {
        if ($this->request === null) {
            return ;
        }
        foreach ($data as $value) {
            if (isset($this->request[$value])) {
                $this->fetchedData[$value] = $this->request[$value];
            }
        }
    }

    private function run($data)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_POST) && $method === 'POST') {
            $this->request = $_POST;
        }
        if (isset($_GET) && $method === 'GET') {
            $this->request = $_GET;
        }
        $this->setData($data);
    }

    public function get()
    {
        return ($this->fetchedData ?? null);
    }

    public function toJson($param = true)
    {
        if (is_bool($param)) {
            $this->fetchedData = json_decode($this->fetchedData, $param);
        }
        return ($this->fetchedData);
    }
}
