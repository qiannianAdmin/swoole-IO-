<?php


require  __DIR__.'/../../vendor/autoload.php';

use Qiannian\Io\NonBlocking\Worker;

$host = "tcp://127.0.0.1:9506";//如果是阿里云服务器的话，这里可以设置成私网ip地址，用公网访问即可
$server = new Worker($host);

$server->onConnect = function($socket, $client){
    echo "有一个连接进来了\n";
};

$server->onReceive = function($socket, $client, $data){
    echo "给连接发送信息\n";
    $socket->send($client, "返回的数据：3333\n");

    $r = 0;
//模拟定时器，进行轮询访问
    while(!feof($client)){
        echo $r++."\n";
        var_dump(fread($client, 65535));

        sleep(1);
    }
};



$server->start();






