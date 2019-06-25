<?php

class Request
{
    private $request;
    public $headers;

    public function __construct()
    {
        $this->run();
    }

    private function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_POST)  && !empty($_POST) && $method === 'POST') {
            $this->request = $_POST;
        } elseif (isset($_GET) && !empty($_GET) && $method === 'GET') {
            $this->request = $_GET;
        } else {
            $input = file_get_contents('php://input');
            if (isset($input) && !empty($input)) {
                $this->request = $input;
            }
        }
        $this->setHeaders();
    }

    public function setHeaders()
    {
        $this->headers = getRequestHeaders();
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
