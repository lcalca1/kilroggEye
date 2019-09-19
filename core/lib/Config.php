<?php
/************************************************************************
  > File Name: Config.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Tue Sep 10 08:21:03 2019
 ************************************************************************/
namespace core\lib;

use Noodlehaus\Config as Conf;
use Noodlehaus\Parser\Json;

class Config {
    public static $_instance = []; // 配置文件对象
    private $conf_name; // 配置文件的名称

    private function __construct($conf_name) {
        $this->conf_name = $conf_name;
    }

    /**
     * @desc 获取配置文件
     * @param str 配置文件名称
     * @return \Noodlehaus\Config
     */
    public static function getConfig($conf_name) {
        $conf_name = ROOT_PATH . '/config/' . $conf_name . '.json'; 
        if(empty(self::$_instance[$conf_name]) && is_file($conf_name)) {
            self::$_instance[$conf_name] = new Conf($conf_name);
        }

        return empty(self::$_instance[$conf_name]) ? null : self::$_instance[$conf_name];
    }

    /**
     * @desc 获取配置文件的名称
     * @return str 配置文件的名称
     */
    public function getConfName() {
        return $this->conf_name;
    }
}
