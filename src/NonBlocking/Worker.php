<?php

    namespace Qiannian\Io\NonBlocking;

    /**
     * Class WOrker
     * @package Qiannian\Io\NonBlocking
     * 非阻塞IO服务端
     */
    class Worker{

        public $socket = null;

        public $onConnect = null;
        public $onReceive = null;


        public function __construct($host)
        {
            $this->socket = stream_socket_server($host);
            echo "非阻塞IO{$host}\n";
        }

        public function accept(){


            while(true){

                //监听过程中是阻塞的
                $client = stream_socket_accept($this->socket);

                //设置为非阻塞状态
                stream_set_blocking($client, 0);

                if(is_callable($this->onConnect)){
                    ($this->onConnect)($this, $client);
                }

                //读取请求的数据
                $data = fread($client, 65535);

                if(is_callable($this->onReceive)){
                    ($this->onReceive)($this, $client, $res);
                }


            }
        }

        public function send($client, $res){

            //让浏览器可以访问
            $response = "HTTP/1.1 200 Ok\r\n";
            $response .= "Content-Type: text/html;charset=UTF-8\r\n";
            $response .= "Connection: keep-alive\r\n";
            $response .= "Content-length: ".strlen($res)."\r\n\r\n";
            $response .= $res;

            fwrite($client, $response);
        }

        public function start(){
            $this->accept();
        }


    }