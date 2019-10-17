<?php
namespace core\lib;
 /************************************************************************
  > File Name: AutoLoad.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Tue Sep 10 07:29:40 2019
 ************************************************************************/

class AutoLoad {
    public static function AutoLoad($class) {
        $file = ROOT_PATH . "/" . $class  . ".php";
        // Linux 需要转义斜杠
        $file = str_replace('\\', '/', $file);

        if (is_file($file)) {
            include($file);
        }
    }    
}
