<?php
/************************************************************************
  > File Name: PasswdController.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Mon Oct  7 06:02:59 2019
 ************************************************************************/
use Sabre\HTTP;
use \core\lib\Config;

class PasswdController extends BaseController
{

    public function run(array $args): HTTP\Response {
        $response = $this->login();
        return $response;
    }

    /**
     * @brief  login
     * @param
     * @return HTTP\Response 
     */
    private function login() : HTTP\Response {
        // request & response
        $request = $this->getRequest();
        $response = $this->getResponse();

        // Login
        if ($this->isLogin($request, $response)) {
            $response->setStatus(HTTP_STATUS_OK);
            $response->setBody('You are logged in!');
        }

        return $response;
    }


    /**
     * @brief login or not
     * @param $request 
     * @param $response
     * @return bool
     */
    public function isLogin(HTTP\Request $request, HTTP\Response $response) : bool {
        // get users
        $user_conf = Config::getConfig('users');
        $userList = $user_conf->all();

        // Auth
        $digestAuth = new HTTP\Auth\Digest('Locked down', $request, $response);
        $digestAuth->init();

        if (!$userName = $digestAuth->getUsername()) { // No username given
            $digestAuth->requireLogin();
            return false;

        } elseif(!isset($userList[$userName]) || !$digestAuth->validatePassword($userList[$userName])) { // Username or password is incorrect
            $digestAuth->requireLogin();
            return false;
        }

        return true;
    }
}
