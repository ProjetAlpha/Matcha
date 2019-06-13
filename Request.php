<?php

class Request
{
    private $request;

    public function __construct()
    {
        $this->run();
    }

    private function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_POST) && $method === 'POST') {
            $this->request = $_POST;
        }
        if (isset($_GET) && $method === 'GET') {
            $this->request = $_GET;
        }
    }

    public function get()
    {
        return ($this->request ?? null);
    }

    public function toJson($param = true)
    {
        if (is_bool($param)) {
            $this->request = json_decode($this->request, $param);
        }
        return ($this->request);
    }
}
