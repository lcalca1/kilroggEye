<?php
/************************************************************************
  > File Name: init.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Mon Sep  9 03:08:49 2019
 ************************************************************************/

require_once ROOT_PATH . '/core/lib/AutoLoad.php';
require_once ROOT_PATH . '/core/lib/Config.php';
require_once ROOT_PATH . '/core/lib/ErrorHandler.php';
require_once ROOT_PATH . '/config/route.php';
require_once ROOT_PATH . '/core/lib/Route.php';
require_once ROOT_PATH . '/config/const.php';

use Sabre\HTTP;
use \core\lib\AutoLoad;
use \core\lib\Config;
use \core\Run;

// 自动加载
spl_autoload_register([new AutoLoad(), 'AutoLoad']);

// 加载配置文件
$conf = Config::getConfig('conf');
// 定义环境名称
define("ENV", $conf->get('env', TEST));

// 获取请求对象
$REQUEST = HTTP\Sapi::getRequest();

// 路由解析
$route = new Route($dispatcher);
$routeInfo = $route->dispatch();

// 核心入口
$run = new Run($routeInfo);
$response = $run->run();

// 输出生成内容
HTTP\Sapi::sendResponse($response);
?>
