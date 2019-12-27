<?php

    namespace Qiannian\Io\Multi;

    /**
     * Class Worker
     * @package Qiannian\Io\Multi
     * IO多路复用
     */
    class Worker{

        public $socket = null;
        protected $sockets = [];

        public $onConnect = null;
        public $onReceive = null;

        public function __construct($host)
        {
            $this->socket = stream_socket_server($host);

            //设置为非阻塞
            stream_set_blocking($this->socket, 0);

            //资源id是唯一的
            $source_id = (int)$this->socket;
            // 相当于连接池
            $this->sockets[$source_id] = $this->socket;

            echo "服务器：{$host},资源ID：{$source_id}\n";
        }
        public function accept(){

            //接收和处理连接
            while(true){

                $read = $this->sockets;
                $w = null;
                $e = null;

                //检测连接池是否有可用的连接
                stream_select($read,$w,$e, 1);

                foreach ($read as $socket){
                    //判断是否为当前连接
                    if($socket == $this->socket){
                        echo 1111;
                        $this->createSocket();
                    }else{
                        $this->receive($socket);
                        echo 2222;
                    }
                }
            }
        }
        public function createSocket(){
            $client = stream_socket_accept($this->socket);
            if(is_callable($this->onConnect)){
                ($this->onConnect)($this, $client);
            }

            //把创建的连接放入连接池
            $this->sockets[(int)$client] = $client;
        }
        public function receive($client){
            $data = fread($client,65535);

            if($data == '' || $data == false){

                unset($this->sockets[(int)$client]);
                return null;
            }
            if(is_callable($this->onReceive)){
                ($this->onReceive)($this, $client, $data);
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