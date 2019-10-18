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
    private $_request;
    private $_response;

    public function __construct() {
        $this->_request = HTTP\Sapi::getRequest();
        $this->_response = new HTTP\Response();
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function getResponse()
    {
        return $this->_response;
    }

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
