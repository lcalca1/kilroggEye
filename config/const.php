 <?php
 /************************************************************************
  > File Name: const.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Thu Sep 26 07:00:52 2019
 ************************************************************************/

// ENV 
define("TEST", "test", true);

// HTTP STATUS
$http_status = "HTTP_STATUS_";
define($http_status."OK", 200);
define($http_status."Created", 201);
define($http_status."Accepted", 202);
define($http_status."Non_Auth", 203);
