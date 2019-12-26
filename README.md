#### 用php原生实现五种IO模型

##### 五种IO模型
    1、Blocking IO 阻塞IO
    2、Nonblocking IO 非阻塞IO
    3、IO multiplexing IO多路复用
    4、Signal driven 信号驱动IO
    5、Asynchronous 异步IO
    
 ##### 目录结构
    src：核心代码目录
    test：测试文件目录
    
 ##### 创建步骤
    1、创建库目录io,并进入目录。
    2、执行composer init ，composer初始化并生成composer.json文件。
    3、编辑composer.json文件，添加我的命名空间Qiannian\Io。
        "autoload":{
            "psr-4":{
                "Qiannian\\Io\\" : "./src/"
            」
        }
    4、执行composer update
   