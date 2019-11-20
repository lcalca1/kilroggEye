<?php 
/************************************************************************
  > File Name: config/route.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Fri Sep 13 05:50:47 2019
 ************************************************************************/

define("ROOT_URI", "/kilroggEye");

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r){
    $r->addGroup(ROOT_URI, function(FastRoute\RouteCollector $r){
        // home
        $r->addRoute('GET', '/{controller:}', 'home');
        $r->addRoute('GET', '/{controller:Home}', 'home');

        // password
        $r->addRoute('GET', '/{controller:Passwd}', 'run');

        // img upload
        $r->addRoute('POST', '/{controller:ImgUpload}', 'run');

    });
});
