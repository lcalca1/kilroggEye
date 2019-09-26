<?php
/************************************************************************
  > File Name: route.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Fri Sep 13 05:55:36 2019
 ************************************************************************/

class Route {
    protected $httpMethod;
    protected $uri;
    private $_dispatcher;

    const ALLOWED_METHOD = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];

    public function setDispatcher(FastRoute\Dispatcher\GroupCountBased $dispatcher) {
        $this->_dispatcher = $dispatcher;
    }

    public function getDispatcher() {
        return $this->_dispatcher;
    }

    public function __construct(FastRoute\Dispatcher\GroupCountBased $dispatcher) {
        $this->_dispatcher = $dispatcher;
        $this->construct($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    }

    /**
     * @brief 获取访问的方法和路径
     * @param httpMethod, string 方法，支持类型见 ALLOWED_METHOD
     * @param uri, string 访问路径
     * @return 
     */
    protected function construct(string $httpMethod, string $uri){
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $this->uri = rawurldecode($uri);

        if (in_array($httpMethod, Route::ALLOWED_METHOD)) {
            $this->httpMethod = $httpMethod;
        }
    }

    /**
     * @brief 路由类执行方法
     * @param
     * @return
     */
    public function dispatch(){
        $routeInfo = $this->_dispatcher->dispatch($this->httpMethod, $this->uri);

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo "404 NOT FOUND.";
                die();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                echo "405 METHOD NOT ALLOWED.";
                die();
                break;
            case FastRoute\Dispatcher::FOUND:
                return $routeInfo;
        }
    }
}
