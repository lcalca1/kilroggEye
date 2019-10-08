<?php
/************************************************************************
  > File Name: PasswdController.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Mon Oct  7 06:02:59 2019
 ************************************************************************/
use Sabre\HTTP;

class PasswdController extends BaseController
{
    public function run(array $args): HTTP\Response{
        $response = new HTTP\Response();
        $response->setStatus(201);
        $response->setHeader('X-Foo', 'bar');
        $response->setBody('success!');

        return $response;
    }

    public function isLogin(string $userName, string $passwd) : bool
    {
        return true;
    }
}
