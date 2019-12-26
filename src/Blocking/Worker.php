<?php

namespace Qiannian\Io\Blocking;

/**
 *
 * Class Worker
 * @package Qiannian\Io\Blocking*
 * 阻塞IO
 *
 */
class Worker{

    //连接
    public $socket = null;

    //三个闭包函数
    public $onConnect = null;
    public $onReceive = null;
    public $onClose = null;

    public function __construct($socket_address)
    {
        $this->socket = stream_socket_server($socket_address);
        echo "服务端地址：".$socket_address."\n";
    }

    public function accept(){
        $client = stream_socket_accept($this->socket);

        //is_callback判断一个参数是否是一个闭包
        if(is_callable($this->onConnect)){

            //执行闭包函数
            ($this->onConnect)($this, $client);
        }

        $data = fread($client, 65535);
        if(is_callable($this->onReceive)){
            ($this->onReceive)($this, $client, $data);
        }

        $this->close($client);

    }

    //向客户端返回数据
    public function send($client, $data){
        fwrite($client, $data);
    }
    public function start(){
        $this->accept();
    }

    public function close($client){
        fclose($client);
    }
}