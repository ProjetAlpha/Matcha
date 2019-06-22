<?php

class Route
{
    public $routes = [];
    private $validRegex = [
      ":alphanum" => ALPHA_NUM,
      ":alpha" => ALPHA,
      ":digits" => DIGITS,
      ":page" => PAGE
    ];
    private $middleware;
    private $currentUrl;
    private $isRegexRouteAdded = false;
    private $matchedRegex;
    private $middlewareStack;

    public function add($url, $method, $dst)
    {
        if (!isset($url) || !is_string($url)) {
            throw new Exception("Bad url format. Url must be a string.");
        }
        if (!is_callable($dst)) {
            $info = explode('@', $dst);
        }
        if (isset($info[1]) && isset($info[0])) {
            $call = $info[1];
            $class = $info[0];
        } elseif (is_callable($dst)) {
            $call = $dst;
        } else {
            throw new Exception("No class or function call in route");
        }
        $this->addRequest($url, $method, $class ?? '', $call);
        return $this;
    }

    private function getRegexUrlPos($url)
    {
        $regex = [];
        $splitUrl = explode('/', $url);
        foreach ($splitUrl as $key => $value) {
            if (isset($this->validRegex[$value])) {
                $regex[] = $key;
            }
        }
        return (!empty($regex) ? $regex : null);
    }

    private function addRequest($url, $method, $class, $call)
    {
        $regexPos = $this->getRegexUrlPos($url);
        $routeSettings = [
          'method' => $method,
          'url' => $url,
          'class' => $class,
          'method_call' => $call,
          'regex_pos' => $regexPos
        ];
        if ($regexPos === null) {
            $this->isRegexRouteAdded = false;
            array_unshift($this->routes, $routeSettings);
        } else {
            $this->isRegexRouteAdded = true;
            $this->routes[] = $routeSettings;
        }
    }

    public function getRegex($url, $currentUrl, $regexPos)
    {
        if ($regexPos === null) {
            return (0);
        }
        $split = explode('/', $url);
        $currUrlSplit = explode('/', $currentUrl);
        $validRegex = [];
        foreach ($regexPos as $value) {
            if (isset($currUrlSplit[$value], $split[$value], $this->validRegex[$split[$value]])) {
                if (preg_match($this->validRegex[$split[$value]], $currUrlSplit[$value])) {
                    $validRegex[$value] = $currUrlSplit[$value];
                }
            }
        }
        $cmp = array_replace($split, $validRegex);
        if (empty($validRegex)) {
            return (0);
        }
        $this->matchedRegex = array_values($validRegex);
        $cmp = array_replace($split, $validRegex);
        return ($cmp === $currUrlSplit);
    }

    private function getClass($name, $method, $param = null)
    {
        $this->runMiddleware();
        if (!isset($name, $method)) {
            return ;
        }
        if (file_exists(__DIR__."/controller/".$name.".php")) {
            require_once(__DIR__."/controller/".$name.".php");
        }
        if (class_exists($name) && method_exists($name, $method)) {
            $init = new $name();
            if (isset($param)) {
                $init->regex = $this->matchedRegex;
                $init->{$method}($param);
            } else {
                $init->{$method}();
            }
            return (1);
        }
        return (0);
    }

    public function loadRoutes($param = null)
    {
        $store_id = [];
        $currentUrl = $_SERVER['REQUEST_URI'];
        $serverMethod = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            $method = $route['method'];
            $url = $route['url'];
            $class = $route['class'];
            $classMethod = $route['method_call'];
            $regexPos = $route['regex_pos'];

            $this->currentUrl = $url;
            if ($class == '' && is_callable($classMethod)
              && $method == strtolower($serverMethod)
              && $currentUrl == $url) {
                $this->runMiddleware();
                return ($classMethod());
            }

            if ($this->getRegex($url, $currentUrl, $regexPos) && $method == strtolower($serverMethod)) {
                return ($this->getClass(
                    $class,
                    $classMethod,
                    array_values(array_slice(explode('/', $currentUrl), -1))[0]
                ));
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

    public function addMiddleware($target)
    {
        if ($this->isRegexRouteAdded === false) {
            $lastRoute = $this->routes[0]['url'];
        } else {
            $lastRoute = $this->routes[key(array_slice($this->routes, -1, 1, true))]['url'];
        }
        if (is_callable($target)) {
            $this->middleware[$lastRoute] = $target;
        }
    }

    public function addMiddlewareStack($target)
    {
        if (is_array($target) && isset($target['function'])
          && is_callable($target['function']) && count($target) > 1) {
            $this->middlewareStack[] = $target;
        }
    }

    public function runMiddleware()
    {
        if (isset($this->middleware[$this->currentUrl])
        && is_callable($this->middleware[$this->currentUrl])) {
            $this->middleware[$this->currentUrl]();
        }
        // add middleware function pour un tableau de route.
        // des que l'on rencontre une des routes => applique le middelware.
        if (isset($this->middlewareStack) && is_array($this->middlewareStack)) {
            foreach ($this->middlewareStack as $targetRoutes) {
                foreach ($targetRoutes as $url) {
                    if ($this->currentUrl == $url) {
                        return ($targetRoutes['function']());
                    }
                }
            }
        }
    }
}
