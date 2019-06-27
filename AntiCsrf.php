<?php

class AntiCsrf
{
    public function __construct()
    {
        if (!isset($_SESSION['csrf_token'], $_SESSION['csrf_time']) || $this->isExpired()) {
            $this->create();
        }
    }

    private function create()
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_time'] = time();
    }

    private function isExpired()
    {
        return ($this->getMinuteDiff($_SESSION['csrf_time'], time()) > 30 ? true : false);
    }

    private function getMinuteDiff($start, $end)
    {
        return (($end - $start) / 60);
    }

    public function check()
    {
        $req = new Request();
        $headers = $req->getHeaders();
        $data = $req->get();

        if (isset($headers['X-Csrf-Token'])) {
            return (hash_equals($_SESSION['csrf_token'], $headers['X-Csrf-Token']));
        }
        if (isset($data['csrf_token'])) {
            return (hash_equals($_SESSION['csrf_token'], $data['csrf_token']));
        }
        return (false);
    }
}
