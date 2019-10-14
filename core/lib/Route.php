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
    public $REQUEST;

    const ALLOWED_METHOD = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];

    public function setDispatcher(FastRoute\Dispatcher\GroupCountBased $dispatcher) {
        $this->_dispatcher = $dispatcher;
    }

    public function getDispatcher() {
        return $this->_dispatcher;
    }

    public function __construct(FastRoute\Dispatcher\GroupCountBased $dispatcher) {
        // 请求对象
        $this->REQUEST = $GLOBALS['REQUEST'];

        // 路由
        $this->_dispatcher = $dispatcher;

        // 格式化 uri
        $this->formatUri($this->REQUEST->getMethod(), $this->REQUEST->getUrl());
    }

    /**
     * @brief 格式化访问的方法和路径
     * @param httpMethod, string 方法，支持类型见 ALLOWED_METHOD
     * @param uri, string 访问路径
     * @return 
     */
    protected function formatUri(string $httpMethod, string $uri){
        if (false !== $pos = strpos($uri, '?')) { // 去掉参数 RESTful uri
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
