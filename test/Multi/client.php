<?php


require  __DIR__.'/../../vendor/autoload.php';

use Qiannian\Io\Multi\Worker;

$host = "tcp://127.0.0.1:9506";
$server = new Worker($host);

$server->onConnect = function($socket, $client){
    echo "有一个连接进来了\n";
};

$server->onReceive = function($socket, $client, $data){
    echo "给连接发送信息\n";
    $socket->send($client, "返回的数据：3333\n");
};



$server->start();






