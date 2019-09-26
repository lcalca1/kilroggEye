<?php
/************************************************************************
  > File Name: run.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Mon Sep  9 03:09:33 2019
 ************************************************************************/

namespace core;

class Run {
    private $_routeInfo;

    public function __construct(array $routeInfo) {
        $this->_routeInfo = $routeInfo;
    }

    public function run() {
        echo "框架核心入口";
    }    
}
