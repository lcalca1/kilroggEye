<?php
/************************************************************************
  > File Name: run.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Mon Sep  9 03:09:33 2019
 ************************************************************************/

namespace core;

class Run {
    // 路由信息
    private $_routeInfo;

    public function __construct(array $routeInfo) {
        $this->_routeInfo = $routeInfo;
    }

    /**
     * @brief 调用 controller
     * @param
     * @return
     */
    public function run(): \Sabre\HTTP\Response {
        $controllerName = $this->_routeInfo[2]['controller'];
        $controllerName = "\\" . (empty($controllerName) ? "Home" : $controllerName) . "Controller";
        $indexFuncName = $this->_routeInfo[1];

        unset($this->_routeInfo[2]['controller']);
        #var_dump($this->_routeInfo);

        return call_user_func(array($controllerName, $indexFuncName), $this->_routeInfo[2]);
    }    
}
