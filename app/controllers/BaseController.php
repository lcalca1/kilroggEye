<?php
 /************************************************************************
  > File Name: BaseController.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Thu Sep 26 07:54:15 2019
 ************************************************************************/
use Sabre\HTTP;

class BaseController
{
    public function __construct() {}    

    /**
     *
     */ 
    public function home() {
        $response = new HTTP\Response();
        $response->setStatus(201);
        $response->setHeader('X-Foo', 'bar');
        $response->setBody('success!');

        return $response;
    }
}
