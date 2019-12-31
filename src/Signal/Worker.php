<?php

    namespace Qiannian\Io\Signal;

    /**
     * Class Worker
     * @package Qniannian\Io\Signal
     * 信号驱动IO
     */
    class Worker{

        public $socket = null;

        //三个必报函数，自定义事件
        public $onConnect = null;
        public $onReceive = null;
        public $onClose = null;

        public function __construct($host)
        {
            $this->socket = stream_socket_server($host);
            echo "信号驱动IO:{$host}\n";

        }

        public function accept(){
            while(1){

                //监听是阻塞的
                $client = stream_socket_accept($this->socket);
                pcntl_signal(SIGIO, $this->sigHandler($client));
                posix_kill(posix_getpid(), SIGIO);
                //分发
                pcntl_signal_dispatch();
            }
        }

        public function sigHandler($client){
            return function($sig) use($client){
                if(is_callable($this->onConnect)){
                    ($this->onConnect)($this, $client);
                };
                $data = fread($client, 65535);

                if(is_callable($this->onReceive)){
                    ($this->onReceive)($this, $client, $data);
                };
            };
        }
        // 发送信息
        public function send($client, $data)
        {
            $response = "HTTP/1.1 200 OK\r\n";
            $response .= "Content-Type: text/html;charset=UTF-8\r\n";
            $response .= "Connection: keep-alive\r\n";
            $response .= "Content-length: ".strlen($data)."\r\n\r\n";
            $response .= $data;
            fwrite($client, $response);
        }
        public function start(){
            $this->accept();
        }
    }