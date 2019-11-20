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
    private $kilroggTokenInfo;

    public function run(array $args): HTTP\Response {
        $response = $this->login();
        return $response;
    }

    /**
     * @brief  login
     * @param
     * @return HTTP\Response 
     */
    public function login() : HTTP\Response {
        $body = 'You are logged in!';
        return $this->_login($body);
    }

    /**
     * @brief get token string of jwt
     * @param userInfo,array 
     * @return string token string
    */
    private function getToken(array $userInfo=array("isLogin"=>true)) : string {
        $basicConf = Config::getConfig('conf');
        $tokenKey = (string)$basicConf->get('token_key');
        $cookieDomain = (string)$basicConf->get('cookieDomain');
        $timeOfTakingEffect = (int)$basicConf->get('can_only_be_used_after', 0);
        $validity_time = (int)$basicConf->get('expires');

        $signer = new Lcobucci\JWT\Signer\Hmac\Sha256();

        $time = time();

        $token = (new Lcobucci\JWT\Builder())
                ->issuedBy($this->getRequest()->getHeader('Host'))
                ->permittedFor($this->getRequest()->getHeader('Host'))
                ->identifiedBy($cookieDomain, true)
                ->issuedAt($time)
                ->canOnlyBeUsedAfter($time + $timeOfTakingEffect)
                ->expiresAt($time + $validity_time)
                ->withClaim('userInfo', json_encode($userInfo))
                ->getToken($signer, new Lcobucci\JWT\Signer\Key($tokenKey));

        $token->getHeaders();
        $token->getClaims();

        return $token;
    }

    /**
     * @brief set token string of jwt in cookie
     * @param token,string 
     * @return
    */
    private function setTokenToCookie(string $token) {
        $basicConf = Config::getConfig('conf');
        $validity_time = (int)$basicConf->get('expires');
        $cookieDomain = (string)$basicConf->get('cookieDomain');

        $cookie = new \Delight\Cookie\Cookie('KilroggToken');
        $cookie->setValue($token);
        $cookie->setMaxAge($validity_time);
        $cookie->setDomain($cookieDomain);
        $cookie->setHttpOnly(true);
        #$cookie->setSecureOnly(true);
        $cookie->setSameSiteRestriction('Strict');
        $cookie->save();
    }

    /**
     * @brief  _login
     * @param $body, string http response body
     * @return HTTP\Response 
     */
    public function _login(string $body) : HTTP\Response {
        // request & response
        $request = $this->getRequest();
        $response = $this->getResponse();

        // Login
        if ($this->isLogin($request, $response)) {

            if (! \Delight\Cookie\Cookie::exists('KilroggToken')) {
                $this->setTokenToCookie($this->getToken());
            }

            $response->setStatus(HTTP_STATUS_OK);
            $response->setBody($body);
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
        // judge from cookie
        if (\Delight\Cookie\Cookie::exists('KilroggToken')) {
            $basicConf = Config::getConfig('conf');
            $cookieDomain = (string)$basicConf->get('cookieDomain');
            $host = (string)$basicConf->get('host');

            $kilroggToken = \Delight\Cookie\Cookie::get('KilroggToken');
            $token = (new \Lcobucci\JWT\Parser())->parse((string) $kilroggToken);
            $data = new \Lcobucci\JWT\ValidationData();
            $data->setIssuer($host);
            $data->setAudience($host);
            $data->setId($cookieDomain);

            if ($token->validate($data)) {
                $this->kilroggTokenInfo = $token;
                return true;
            }
        }

        // judge by digest auth
        // get users
        $user_conf = Config::getConfig('users');
        $userList = $user_conf->all();

        // Auth
        $digestAuth = new HTTP\Auth\Digest($request->getHeaders()["Host"][0], $request, $response);
        $digestAuth->init();

        if (!$userName = $digestAuth->getUsername()) { // No username given
            $digestAuth->requireLogin();
            return false;

        } elseif(!isset($userList[$userName]) || !$digestAuth->validatePassword($userList[$userName])) { // Username or password is incorrect
            $digestAuth->requireLogin();
            return false;
        }

        $this->digestAuthInfo = $digestAuth;

        return true;
    }
}
