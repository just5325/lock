<?php
require_once './vendor/autoload.php';
use Lock\Lock;

// 定义配置文件
$config = [
    'drive' =>  'redis',
    'redis' =>  [
        'host'  =>  '127.0.0.1',
        'port'  =>  '6379'
    ],
    'params' => [
        'max_queue_process' => 100,
        'expiration'        =>  5
    ]
];
// 实例化调用
$lock = new Lock($config);
// 定义锁名称
$lock_val = 'num:id:1';
// 队列锁(返回闭包内返回的数据,扩展包的异常类为\Lock\LockException)
try {
    $ret = $lock->queueLock(function($redis){
        // 业务逻辑代码...执行完自动释放锁
        return 111;
    }, $lock_val, 600);
}catch (\Lock\LockException $e){
    
}

var_dump($ret);die;
