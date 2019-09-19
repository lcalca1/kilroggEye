<?php
/************************************************************************
  > File Name: ErrorHandler.php
  > Author: lca
  > Mail: liuchang@xiaodutv.com
  > Created Time: Wed Sep 11 06:59:33 2019
 ************************************************************************/

// Whoops 调试
use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\Handler;
#use Whoops\Handler\JsonResponseHandler;
#use Noodlehaus\Parser\Json;

$whoops = new WhoopsRun();
$handler = new PrettyPageHandler();
#$handler_json = new JsonResponseHandler();

#$handler->setApplicationPaths([__FILE__]);
// additional infomation for the handler
$handler->addDataTable("Lok'tar Ogar", [
    'Orcs are never slaves!' => 'we will be conquerors.',
    'Illidan Stormrage' => 'You are not prepared!',
]);

// additional infomation for the handler
$handler->addDataTableCallback('Details', function(\Whoops\Exception\Inspector $inspector){
    $data = array();
    $exception = $inspector->getException();

    if( $exception instanceof SomeSpecificException ) {
        $data['import exception data'] = $exception->getSomenSpecificData();
    }

    $data['Exception class'] = get_class($exception);
    $data['Exception code'] = $exception->getCode();

    return $data;
});

// push error handler
$whoops->pushHandler($handler);
$whoops->pushHandler(function($exception, $inspector, $run){
    if (ENV != "test") { // stop handling when not in testing environment
        echo "something went wrong.";
        return Handler::LAST_HANDLER;
    }
});

$whoops->register();
