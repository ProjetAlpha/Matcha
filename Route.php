<?php

class Route
{
    public $routes = [];
    private $routeCounter = 0;
    private $idUrlPos = 0;
    private $root;
    private $validRegex = [":alphanum" => ALPHA_NUM, ":alpha" => ALPHA, ":digits" => DIGITS, ":page" => PAGE];

    public function __construct()
    {
        $this->root = realpath($_SERVER["DOCUMENT_ROOT"]);
    }

    public function add($url, $method, $dst)
    {
        if (!isset($url) || !is_string($url)) {
            throw new Exception("Bad url format. Url must be a string.");
        }
        $info = explode('@', $dst);
        if (isset($info[1]) && isset($info[0])) {
            $call = $info[1];
            $class = $info[0];
        } else {
            throw new Exception("No class or method call in route");
        }
        $this->routeCounter++;
        $this->addRequest($url, $method, $class, $call);
    }

    private function addRequest($url, $method, $class, $call)
    {
        $this->routes[$this->routeCounter]['method'] = $method;
        $this->routes[$this->routeCounter]['url'] = $url;
        $this->routes[$this->routeCounter]['class'] = $class;
        $this->routes[$this->routeCounter]['method_call'] = $call;
    }

    public function getRegex($url, $currentUrl)
    {
        $split = explode('/', $url);
        $currUrlSplit = explode('/', $currentUrl);
        $result = [];
        foreach ($this->validRegex as $name => $regex) {
            foreach ($split as $index => $parts) {
                if ($parts == $name) {
                    if (isset($currUrlSplit[$index]) && preg_match($regex, $currUrlSplit[$index])) {
                        $result[$index] = $currUrlSplit[$index];
                    }
                }
            }
        }
        $cmp = array_replace($split, $result);
        return ($cmp === $currUrlSplit);
    }

    private function getClass($name, $method, $param = null)
    {
        require_once(__DIR__."/controller/".$name.".php");
        if (class_exists($name) && method_exists($name, $method))
        {
            $init = new $name();
            if (isset($param))
                $init->{$method}($param);
            else
                $init->{$method}();
            return (1);
        }
        return (0);
    }

    public function loadRoutes($param = null)
    {
        $store_id = [];
        $currentUrl = $_SERVER['REQUEST_URI'];
        $serverMethod = $_SERVER['REQUEST_METHOD'];
        $found = 0;
        foreach ($this->routes as $route) {
            $method = $route['method'];
            $url = $route['url'];
            $class = $route['class'];
            $classMethod = $route['method_call'];

            if ($this->getRegex($url, $currentUrl) && $method == strtolower($serverMethod)) {
                return ($this->getClass($class, $classMethod,
                array_values(array_slice(explode('/', $currentUrl), -1))[0]));
            }
            if (isset($_GET) && $method == 'get') {
                if ($currentUrl == $url) {
                    return ($this->getClass($class, $classMethod));
                }
            }
            if (isset($_POST) && $method == 'post') {
                if ($currentUrl == $url) {
                    return ($this->getClass($class, $classMethod));
                }
            }
        }
        require_once(__DIR__."/views/page_404.php");
    }
}
